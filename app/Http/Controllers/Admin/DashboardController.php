<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Models\EbookProgram;
use App\Models\ThesisProgram;
use App\Models\PeriodicalProgram;
use App\Models\NewArrival;
use App\Models\DonatedBook;
use App\Models\LibraryUpdate;
use App\Models\Gallery;

class DashboardController extends Controller
{
    /**
     * Display the administrator dashboard.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalEvents = CalendarEvent::count();

        $totalBooks = NewArrival::where('resource_type', 'printed')->count();

        $totalDonatedBooks = DonatedBook::count();

        $totalEbooks = EbookProgram::count();

        $totalThesisPrograms = ThesisProgram::count();

        $totalPeriodicalPrograms = PeriodicalProgram::count();

        $totalGallery = Gallery::count();

        $totalLibraryUpdates = LibraryUpdate::count();

        /*
        |--------------------------------------------------------------------------
        | Latest Data
        |--------------------------------------------------------------------------
        */

        $latestEvents = CalendarEvent::latest()
            ->take(5)
            ->get();

        $latestBooks = NewArrival::latest()
            ->take(5)
            ->get();

        $ebookPrograms = EbookProgram::query()
            ->withCount('folders')
            ->orderBy('title')
            ->get();

        $thesisPrograms = ThesisProgram::query()
            ->withCount('folders')
            ->orderBy('title')
            ->get();

        $periodicalPrograms = PeriodicalProgram::query()
            ->withCount('folders')
            ->orderBy('title')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', compact(

            'totalEvents',

            'totalBooks',
            'totalDonatedBooks',

            'totalEbooks',

            'totalThesisPrograms',

            'totalPeriodicalPrograms',

            'totalGallery',
            'totalLibraryUpdates',

            'latestEvents',
            'latestBooks',
            'ebookPrograms',
            'thesisPrograms',
            'periodicalPrograms'

        ));
    }
}
