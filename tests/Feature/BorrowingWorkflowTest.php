<?php

namespace Tests\Feature;

use App\Mail\BorrowingUpdateMail;
use App\Models\BorrowingEmailUpdate;
use App\Services\BorrowingEmails;
use Illuminate\Support\Facades\Mail;
use App\Models\Borrower;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BorrowingWorkflowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost', 'database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        app('url')->forceRootUrl('http://localhost');
        DB::purge('sqlite');
        foreach (['0001_01_01_000000_create_users_table.php', '2026_07_23_064736_create_new_arrivals_table.php', '2026_08_06_051132_add_accession_number_to_new_arrivals_table.php', '2026_09_17_000001_create_book_borrowing_system_tables.php', '2026_09_17_000000_add_borrower_type_to_borrowers_table.php', '2026_09_17_000001_add_released_by_to_borrowings_table.php', '2026_09_17_000003_add_borrowing_email_updates.php'] as $file) {
            (require database_path('migrations/'.$file))->up();
        }
        Mail::fake();
        $this->actingAs(User::factory()->create(['name' => 'Library Staff']));
    }

    private function loan(string $status = 'pending'): Borrowing
    {
        $borrower = Borrower::create(['name' => 'Test Borrower', 'id_number' => uniqid(), 'borrower_type' => 'student', 'department' => 'Education', 'semester' => '1st']);
        return Borrowing::create(['borrower_id' => $borrower->id, 'accession_number' => 'BOOK-1', 'bibliographical_description' => 'Test Book', 'status' => $status]);
    }

    public function test_approve_release_and_return_with_clear_staff_roles(): void
    {
        $loan = $this->loan();
        $this->get(route('admin.borrowings.show', $loan))->assertOk()->assertDontSeeText('Step 1: Review Request')->assertDontSeeText('Confirm Book Release');
        $this->patch(route('admin.borrowings.approve', $loan))->assertSessionHas('success');
        $this->get(route('admin.borrowings.show', $loan))->assertOk()->assertSeeText('Confirm Book Release');
        $this->patch(route('admin.borrowings.borrowed', $loan), ['date_borrowed' => now()->toDateString(), 'due_date' => now()->addWeek()->toDateString(), 'released_by' => 'Release Staff'])->assertSessionHasNoErrors()->assertSessionHas('success');
        $this->assertSame('Release Staff', $loan->refresh()->released_by);
        $this->assertSame('borrowed', $loan->status);
        $this->assertSame('Test Borrower', $loan->received_by);
        $this->patch(route('admin.borrowings.returned', $loan), ['returned_by' => 'Test Borrower'])->assertSessionHasNoErrors()->assertSessionHas('success');
        $this->assertSame('returned', $loan->refresh()->status);
        $this->assertSame('Test Borrower', $loan->received_by);
        $this->assertSame('Test Borrower', $loan->returned_by);
        $this->assertSame('Release Staff', $loan->released_by);
        $this->patch(route('admin.borrowings.approve', $loan))->assertSessionHas('error');
        $this->assertSame('returned', $loan->refresh()->status);
    }

    public function test_release_requires_approval_and_valid_dates_and_staff(): void
    {
        $loan = $this->loan();
        $this->patch(route('admin.borrowings.borrowed', $loan))->assertSessionHas('error');
        $this->patch(route('admin.borrowings.returned', $loan))->assertSessionHas('error');
        $loan->update(['status' => 'approved']);
        $this->patch(route('admin.borrowings.borrowed', $loan), ['date_borrowed' => now()->toDateString(), 'due_date' => now()->subDay()->toDateString()])->assertSessionHasErrors(['due_date', 'released_by']);
        $this->assertSame('approved', $loan->refresh()->status);
    }

    public function test_approved_requests_do_not_become_overdue_and_pending_requests_do_not_block_approval(): void
    {
        $loan = $this->loan('approved');
        $loan->update(['date_borrowed' => now()->subWeek(), 'due_date' => now()->subDay()]);
        $this->assertSame('approved', $loan->display_status);
        $this->assertFalse($loan->markOverdueIfNeeded());
        $this->get(route('admin.borrowings.index'))->assertOk();
        $this->assertSame('approved', $loan->refresh()->status);
        $loan->update(['status' => 'pending']);
        $other = $this->loan();
        $this->patch(route('admin.borrowings.approve', $loan))->assertSessionHas('success');
        $this->patch(route('admin.borrowings.approve', $other))->assertSessionHas('error');
        $this->assertSame('pending', $other->refresh()->status);
    }

    public function test_edit_persists_released_by_and_cannot_bypass_workflow(): void
    {
        $loan = $this->loan('borrowed');
        $loan->update(['date_borrowed' => now(), 'due_date' => now()->addWeek()]);
        $data = ['name' => $loan->borrower->name, 'id_number' => $loan->borrower->id_number, 'borrower_type' => 'student', 'department' => 'Education', 'semester' => '1st', 'accession_number' => 'BOOK-1', 'bibliographical_description' => 'Test Book', 'status' => 'borrowed', 'date_borrowed' => now()->toDateString(), 'due_date' => now()->addWeek()->toDateString(), 'released_by' => 'Corrected Staff'];
        $this->put(route('admin.borrowings.update', $loan), $data)->assertSessionHasNoErrors();
        $this->assertSame('Corrected Staff', $loan->refresh()->released_by);
        $this->put(route('admin.borrowings.update', $loan), array_replace($data, ['status' => 'returned']))->assertSessionHasErrors('status');
        $this->get(route('admin.borrowings.edit', $loan))->assertOk();
    }

    public function test_public_request_only_needs_title_and_email_and_ignores_accession_input(): void
    {
        $this->get(route('more.borrow-books'))->assertOk()->assertSee('name="book_title"', false)->assertDontSee('name="accession_number"', false)->assertDontSee('name="bibliographical_description"', false);
        $data = ['name' => 'Public Borrower', 'id_number' => 'PUBLIC-1', 'borrower_type' => 'student', 'department' => 'Education', 'semester' => '1st', 'email' => 'borrower@example.com', 'book_title' => 'Requested Title', 'accession_number' => 'UNTRUSTED'];
        $this->post(route('more.borrow-books.store'), $data)->assertSessionHasNoErrors();
        $loan = Borrowing::firstOrFail();
        $this->assertNull($loan->accession_number);
        $this->assertNull($loan->new_arrival_id);
        $this->assertSame('Requested Title', $loan->bibliographical_description);
        $this->post(route('more.borrow-books.store'), array_replace($data, ['book_title' => 'requested title']))->assertSessionHasErrors('book_title');
        $this->post(route('more.borrow-books.store'), array_replace($data, ['email' => '']))->assertSessionHasErrors('email');
        $this->patch(route('admin.borrowings.approve', $loan))->assertSessionHas('error');
        $this->assertSame('pending', $loan->refresh()->status);
        Mail::assertNothingSent();
        $this->get(route('admin.borrowings.show', $loan))->assertOk()->assertSeeText('Not assigned');
        $this->patch(route('admin.borrowings.reject', $loan))->assertSessionHas('success');
        Mail::assertSent(BorrowingUpdateMail::class, fn ($mail) => $mail->event === 'rejected' && $mail->hasTo('borrower@example.com'));
    }

    public function test_approval_emails_the_borrower_once(): void
    {
        $loan = $this->loan();
        $loan->borrower->update(['email' => 'borrower@example.com']);
        $this->patch(route('admin.borrowings.approve', $loan))->assertSessionHas('success');
        $this->patch(route('admin.borrowings.approve', $loan))->assertSessionHas('error');
        $this->artisan('borrowings:send-updates')->assertSuccessful();
        Mail::assertSent(BorrowingUpdateMail::class, fn ($mail) => $mail->event === 'approved' && $mail->hasTo('borrower@example.com'));
        Mail::assertSentCount(1);
        $this->assertNotNull(BorrowingEmailUpdate::first()->sent_at);
        $this->assertStringContainsString('approved', (new BorrowingUpdateMail($loan->refresh()->load('borrower'), 'approved'))->render());
    }

    public function test_due_and_overdue_reminders_are_once_per_due_date_and_only_for_active_loans(): void
    {
        $this->travelTo(now()->startOfDay()->addHours(9));
        $loan = $this->loan('borrowed');
        $loan->borrower->update(['email' => 'borrower@example.com']);
        $loan->update(['date_borrowed' => today()->subWeek(), 'due_date' => today()]);
        $approved = $this->loan('approved');
        $approved->update(['due_date' => today()]);
        $returned = $this->loan('returned');
        $returned->update(['due_date' => today(), 'date_returned' => today()]);
        $this->artisan('borrowings:send-updates')->assertSuccessful();
        $this->artisan('borrowings:send-updates')->assertSuccessful();
        Mail::assertSentCount(1);
        Mail::assertSent(BorrowingUpdateMail::class, fn ($mail) => $mail->event === 'due');
        $this->travel(1)->days();
        $this->artisan('borrowings:send-updates')->assertSuccessful();
        $this->artisan('borrowings:send-updates')->assertSuccessful();
        Mail::assertSentCount(2);
        Mail::assertSent(BorrowingUpdateMail::class, fn ($mail) => $mail->event === 'overdue');
        $this->assertSame('overdue', $loan->refresh()->status);
        $this->assertSame('approved', $approved->refresh()->status);
        $loan->update(['due_date' => today()]);
        $this->artisan('borrowings:send-updates')->assertSuccessful();
        Mail::assertSentCount(3);
        $this->travelBack();
    }

    public function test_smtp_failure_preserves_approval_and_can_be_retried(): void
    {
        $loan = $this->loan();
        $loan->borrower->update(['email' => 'borrower@example.com']);
        Mail::shouldReceive('to')->once()->andThrow(new \RuntimeException('SMTP unavailable'));
        $this->patch(route('admin.borrowings.approve', $loan))->assertSessionHas('success', fn ($message) => str_contains($message, 'pending delivery'));
        $this->assertSame('approved', $loan->refresh()->status);
        $update = BorrowingEmailUpdate::firstOrFail();
        $this->assertNull($update->sent_at);
        Mail::swap(new \Illuminate\Mail\MailManager(app()));
        Mail::fake();
        $this->artisan('borrowings:send-updates')->assertSuccessful();
        Mail::assertSentCount(1);
        $this->assertNotNull($update->refresh()->sent_at);
    }

    public function test_stale_email_is_cancelled_after_return_or_due_date_change(): void
    {
        $loan = $this->loan('borrowed');
        $loan->borrower->update(['email' => 'borrower@example.com']);
        $loan->update(['due_date' => today()]);
        $update = app(BorrowingEmails::class)->record($loan, 'due');
        $loan->update(['due_date' => today()->addWeek()]);
        $this->artisan('borrowings:send-updates')->assertSuccessful();
        $this->assertNotNull($update->refresh()->cancelled_at);
        Mail::assertNothingSent();
        $loan->update(['due_date' => today()->subDay()]);
        $overdue = app(BorrowingEmails::class)->record($loan, 'overdue');
        $loan->update(['status' => 'returned', 'date_returned' => today()]);
        $this->artisan('borrowings:send-updates')->assertSuccessful();
        $this->assertNotNull($overdue->refresh()->cancelled_at);
        Mail::assertNothingSent();
    }

    public function test_admin_can_save_unassigned_request_then_assign_accession_before_approval(): void
    {
        $loan = $this->loan();
        $loan->update(['accession_number' => null]);
        $data = ['name' => $loan->borrower->name, 'id_number' => $loan->borrower->id_number, 'borrower_type' => 'student', 'department' => 'Education', 'semester' => '1st', 'email' => 'borrower@example.com', 'bibliographical_description' => 'Requested Title', 'status' => 'pending'];
        $this->put(route('admin.borrowings.update', $loan), $data)->assertSessionHasNoErrors();
        $this->assertNull($loan->refresh()->accession_number);
        $this->put(route('admin.borrowings.update', $loan), $data + ['accession_number' => 'COPY-100'])->assertSessionHasNoErrors();
        $this->assertSame('COPY-100', $loan->refresh()->accession_number);
        $this->patch(route('admin.borrowings.approve', $loan))->assertSessionHas('success');
        Mail::assertSent(BorrowingUpdateMail::class, fn ($mail) => $mail->event === 'approved');
    }

    public function test_borrowing_excel_exports_filter_status_and_deduplicate_borrowers(): void
    {
        $loan = $this->loan('borrowed');
        $loan->update(['date_borrowed' => today()->subWeek(), 'due_date' => today()->subDay()]);
        foreach (range(1, 12) as $number) {
            Borrowing::create(['borrower_id' => $loan->borrower_id, 'accession_number' => 'COPY-'.$number, 'bibliographical_description' => 'Additional Book', 'status' => 'returned']);
        }
        $other = $this->loan('approved');
        $other->borrower->update(['borrower_type' => 'faculty']);
        $read = function (array $filters): array {
            $response = $this->get(route('admin.borrowings.export', $filters))->assertOk()
                ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $path = $response->baseResponse->getFile()->getPathname();
            $zip = new \ZipArchive;
            $this->assertTrue($zip->open($path));
            try {
                $xml = simplexml_load_string($zip->getFromName('xl/worksheets/sheet1.xml'));
                return array_map(fn ($row) => array_map(fn ($cell) => (string) $cell->is->t, iterator_to_array($row->c, false)), iterator_to_array($xml->sheetData->row, false));
            } finally { $zip->close(); unlink($path); }
        };
        $this->assertCount(15, $read(['list' => 'borrowings']));
        $this->assertCount(15, $read(['list' => 'borrowings', 'date_borrowed' => '2000-01-01', 'due_date' => '2000-01-02']));
        $this->assertStringNotContainsString('type="date"', view('admin.borrowings.export')->render());
        $this->assertCount(3, $read(['list' => 'borrowers']));
        $overdue = $read(['list' => 'borrowings', 'status' => 'overdue']);
        $this->assertCount(2, $overdue);
        $this->assertSame('Overdue', $overdue[1][10]);
        $this->assertSame('borrowed', $loan->refresh()->status);
        $this->assertCount(1, $read(['list' => 'borrowings', 'status' => 'borrowed']));
        $this->assertCount(2, $read(['list' => 'borrowers', 'status' => 'returned']));
        $this->assertCount(2, $read(['list' => 'borrowers', 'borrower_type' => 'faculty']));
        $this->assertCount(1, $read(['list' => 'borrowings', 'search' => 'no matching book']));
        $this->getJson(route('admin.borrowings.export', ['list' => 'invalid']))->assertUnprocessable();
        $this->getJson(route('admin.borrowings.export', ['list' => 'borrowers', 'status' => 'invalid']))->assertUnprocessable();
        $this->get(route('admin.borrowings.index'))->assertOk()->assertSeeText('Export to Excel');
        auth()->logout();
        $this->get(route('admin.borrowings.export', ['list' => 'borrowers']))->assertRedirect(route('login'));
    }
}
