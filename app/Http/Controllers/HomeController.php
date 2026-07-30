<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\LibraryUpdate;
use App\Models\NewArrival;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(): View
    {
        $eventsQuery = CalendarEvent::query();
        $eventTable = $eventsQuery->getModel()->getTable();

        if (Schema::hasColumn($eventTable, 'status')) {
            $eventsQuery->where('status', 'published');
        }

        if (Schema::hasColumn($eventTable, 'event_date')) {
            $eventsQuery->whereDate('event_date', '>=', today())
                ->orderBy('event_date');
        }

        if (Schema::hasColumn($eventTable, 'start_time')) {
            $eventsQuery->orderBy('start_time');
        }

        $events = $eventsQuery->get();

        $arrivals = NewArrival::query()
            ->where('resource_type', 'printed')
            ->where('availability_status', 'available')
            ->orderByDesc('arrival_date')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $libraryUpdates = LibraryUpdate::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        return view('home', compact(
            'events',
            'arrivals',
            'libraryUpdates'
        ));
    }
}
