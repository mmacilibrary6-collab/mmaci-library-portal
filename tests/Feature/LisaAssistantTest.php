<?php

namespace Tests\Feature;

use App\Services\LisaAssistant;
use Tests\TestCase;

class LisaAssistantTest extends TestCase
{
    public function test_it_answers_natural_gmail_contact_questions_directly(): void
    {
        $reply = app(LisaAssistant::class)->reply(
            'no like how do i contact mmaci library thru gmail'
        );

        $this->assertStringContainsString(
            'mmacilibrary@mmacibutuan.edu.ph',
            $reply['answer']
        );
        $this->assertStringContainsString(
            'mmacilibrary@gmail.com',
            $reply['answer']
        );
        $this->assertStringContainsString(
            '/more/ask-librarian',
            $reply['pageUrl']
        );
    }

    public function test_it_answers_phone_and_location_contact_questions(): void
    {
        $phoneReply = app(LisaAssistant::class)->reply(
            'what number can i call for the mmaci librarian'
        );
        $locationReply = app(LisaAssistant::class)->reply(
            'where is the mmaci library located'
        );

        $this->assertStringContainsString('+63 948 553 2601', $phoneReply['answer']);
        $this->assertStringContainsString('North Montilla', $locationReply['answer']);
    }

    public function test_a_new_topic_does_not_inherit_the_previous_contact_context(): void
    {
        $reply = app(LisaAssistant::class)->reply(
            'how do i view journals',
            [
                ['role' => 'user', 'text' => 'how do i contact mmaci library'],
                ['role' => 'assistant', 'text' => 'You can email the library.'],
            ]
        );

        $this->assertSame('Periodicals', $reply['title']);
        $this->assertStringContainsString('/collection/periodicals', $reply['pageUrl']);
        $this->assertStringNotContainsString('email', strtolower($reply['answer']));
        $this->assertFalse(collect($reply['suggestions'])->contains(
            fn ($suggestion) => str_contains(strtolower($suggestion), 'http')
        ));
        $this->assertFalse(collect($reply['suggestions'])->contains(
            fn ($suggestion) => mb_strlen($suggestion) > 55
        ));
    }

    public function test_an_explicit_follow_up_keeps_the_previous_topic(): void
    {
        $reply = app(LisaAssistant::class)->reply(
            'what about facebook',
            [
                ['role' => 'user', 'text' => 'how do i contact mmaci library'],
            ]
        );

        $this->assertStringContainsString('Facebook', $reply['answer']);
    }

    public function test_it_lists_actual_facilities_and_services(): void
    {
        $facilities = app(LisaAssistant::class)->reply('What facilities are available?');
        $services = app(LisaAssistant::class)->reply('What services does the library offer?');

        $this->assertStringContainsString('Discussion Room', $facilities['answer']);
        $this->assertStringContainsString('Reading Area', $facilities['answer']);
        $this->assertStringContainsString('Audio Visual Room', $facilities['answer']);
        $this->assertStringContainsString('OPAC', $services['answer']);
        $this->assertStringContainsString('laptop', strtolower($services['answer']));
    }

    public function test_suggestions_do_not_repeat_the_current_question(): void
    {
        $reply = app(LisaAssistant::class)->reply('What facilities are available?');

        $this->assertFalse(collect($reply['suggestions'])->contains(
            fn ($suggestion) => str_contains(strtolower($suggestion), 'facilities are available')
        ));
        $this->assertNotEmpty($reply['suggestions']);
    }

    public function test_it_answers_hours_borrowing_and_specific_facilities(): void
    {
        $hours = app(LisaAssistant::class)->reply('What are the library hours?');
        $borrowing = app(LisaAssistant::class)->reply('How many books can students borrow?');
        $room = app(LisaAssistant::class)->reply('How many people fit in the discussion room?');
        $laptop = app(LisaAssistant::class)->reply('Can I use a library laptop?');

        $this->assertStringContainsString('8:00 AM to 9:00 PM', $hours['answer']);
        $this->assertStringContainsString('3 books', $borrowing['answer']);
        $this->assertStringContainsString('8 persons', $room['answer']);
        $this->assertStringContainsString('one hour', $laptop['answer']);
    }
}
