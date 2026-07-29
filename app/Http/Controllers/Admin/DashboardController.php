<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Models\NewArrival;
use App\Models\Gallery;
use App\Models\AskLibrarian;
use App\Models\VisitingUser;

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

        $totalEbooks = NewArrival::where('resource_type', 'ebook')->count();

        $totalGallery = Gallery::count();

        $totalMessages = AskLibrarian::count();

        $pendingMessages = AskLibrarian::where('status', 'pending')->count();

        $totalVisitors = VisitingUser::count();

        $pendingVisitors = VisitingUser::where('status', 'pending')->count();

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

        $latestMessages = AskLibrarian::latest()
            ->take(5)
            ->get();

        $latestVisitors = VisitingUser::latest()
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

            'totalMessages',

            'pendingMessages',

            'totalVisitors',

            'pendingVisitors',

            'latestEvents',

            'latestBooks',

            'latestMessages',

            'latestVisitors'

        ));
    }
}