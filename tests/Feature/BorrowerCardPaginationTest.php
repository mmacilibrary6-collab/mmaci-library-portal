<?php

namespace Tests\Feature;

use App\Models\Borrower;
use App\Models\Borrowing;
use DOMDocument;
use DOMXPath;
use Tests\TestCase;

class BorrowerCardPaginationTest extends TestCase
{
    public function test_all_records_print_once_in_five_row_pages_with_repeated_details(): void
    {
        foreach (['student', 'faculty'] as $type) {
            foreach ([0, 1, 5, 6, 10, 11] as $count) {
                $borrower = new Borrower(['name' => 'Sample Borrower', 'id_number' => 'CARD-001', 'borrower_type' => $type, 'department' => 'Education', 'semester' => '1st']);
                $records = collect();
                for ($number = 1; $number <= $count; $number++) {
                    $records->push(new Borrowing(['accession_number' => 'BOOK-'.$number, 'bibliographical_description' => 'Sample title '.$number]));
                }
                $borrower->setRelation('borrowings', $records);
                $html = view('admin.borrowings.print-card', compact('borrower'))->render();
                $dom = new DOMDocument;
                $previous = libxml_use_internal_errors(true);
                try {
                    $dom->loadHTML($html);
                } finally {
                    libxml_clear_errors();
                    libxml_use_internal_errors($previous);
                }
                $xpath = new DOMXPath($dom);
                $pages = $xpath->query('//section[@class="sheet"]');
                $pageCount = max(1, (int) ceil($count / 5));
                $this->assertCount($pageCount, $pages);
                $titles = [];
                foreach ($pages as $index => $page) {
                    $pageNumbers = $xpath->query('.//p[@class="page-number"]', $page);
                    if ($pageCount > 1) {
                        $this->assertSame('Page '.($index + 1).' of '.$pageCount, trim($pageNumbers->item(0)->textContent));
                    } else {
                        $this->assertCount(0, $pageNumbers);
                    }
                    $this->assertCount(1, $xpath->query('.//header//img', $page));
                    $this->assertStringContainsString(strtoupper($type)." BORROWER'S CARD", $page->textContent);
                    $this->assertStringContainsString('Sample Borrower', $page->textContent);
                    $this->assertStringContainsString('CARD-001', $page->textContent);
                    $this->assertStringContainsString('QF-SOF-LRC-BRB-03', $page->textContent);
                    $rows = $xpath->query('.//table[@class="borrow-table"]/tbody/tr', $page);
                    $this->assertCount(5, $rows);
                    foreach ($rows as $row) {
                        $title = trim(str_replace("\xc2\xa0", '', $xpath->query('./td[4]', $row)->item(0)->textContent));
                        if ($title !== '') $titles[] = $title;
                    }
                }
                $this->assertSame($records->pluck('bibliographical_description')->all(), $titles);
            }
        }
    }
}
