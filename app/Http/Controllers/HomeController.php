<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\LibraryUpdate;
use App\Models\NewArrival;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        /*
         * Upcoming calendar events
         */
        $eventsQuery = CalendarEvent::query();
        $eventTable = $eventsQuery->getModel()->getTable();

        if (Schema::hasColumn($eventTable, 'status')) {
            $eventsQuery->where('status', 'published');
        }

        if (Schema::hasColumn($eventTable, 'event_date')) {
            $eventsQuery
                ->where(function ($query) use ($eventTable) {
                    $query->whereDate(
                        'event_date',
                        '>=',
                        today()
                    );

                    if (
                        Schema::hasColumn(
                            $eventTable,
                            'event_end_date'
                        )
                    ) {
                        $query->orWhereDate(
                            'event_end_date',
                            '>=',
                            today()
                        );
                    }
                })
                ->orderBy('event_date');
        }

        if (Schema::hasColumn($eventTable, 'start_time')) {
            $eventsQuery->orderBy('start_time');
        }

        $events = $eventsQuery->get();

        /*
         * New arrivals
         *
         * Resource type was completely removed, so this query
         * only filters available materials.
         */
        $arrivals = NewArrival::query()
            ->where('availability_status', 'available')
            ->orderByDesc('arrival_date')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        /*
         * Library updates
         */
        $libraryUpdateTable = (new LibraryUpdate())->getTable();
        $libraryUpdateExpiryDays = max(1, (int) config('security.library_update_expiry_days', 10));

        $libraryUpdates = LibraryUpdate::query()
            ->where('status', true)
            ->where('created_at', '>=', now()->subDays($libraryUpdateExpiryDays))
            ->when(
                Schema::hasColumn(
                    $libraryUpdateTable,
                    'sort_order'
                ),
                function ($query) {
                    $query->orderBy('sort_order');
                }
            )
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        return view(
            'home',
            compact(
                'events',
                'arrivals',
                'libraryUpdates'
            )
        );
    }
}
