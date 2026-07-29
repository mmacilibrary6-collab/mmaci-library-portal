<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Models\EbookProgram;
use App\Models\NewArrival;
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

        $totalEbooks = EbookProgram::count();

        $totalGallery = Gallery::count();

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

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', compact(

            'totalEvents',

            'totalBooks',

            'totalEbooks',

            'totalGallery',

            'latestEvents',
            'latestBooks'

        ));
    }
}
