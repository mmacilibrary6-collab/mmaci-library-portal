<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CalendarController extends Controller
{
    /**
     * Display all calendar events.
     */
    public function index(Request $request)
    {
        $query = CalendarEvent::query();
        $table = $query->getModel()->getTable();

        /*
        |--------------------------------------------------------------------------
        | Search Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status') && Schema::hasColumn($table, 'status')) {
            $query->where('status', $request->input('status'));
        }

        /*
        |--------------------------------------------------------------------------
        | Retrieve Events
        |--------------------------------------------------------------------------
        */

        $events = $query
            ->orderByDesc('event_date')
            ->orderByDesc('start_time')
            ->paginate(10)
            ->withQueryString();

        return view('admin.calendar.list', compact('events'));
    }

    /**
     * Display the create-event form.
     */
    public function create()
    {
        return view('admin.calendar.create');
    }

    /**
     * Store a newly created calendar event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'event_date' => [
                'required',
                'date',
            ],

            'event_end_date' => [
                'nullable',
                'date',
                'after_or_equal:event_date',
            ],

            'start_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'end_time' => [
                'nullable',
                'date_format:H:i',
                'after:start_time',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:draft,published,cancelled',
            ],
        ]);

        $event = new CalendarEvent();
        $columns = Schema::getColumnListing($event->getTable());
        $payload = array_intersect_key($validated, array_flip($columns));

        CalendarEvent::create($payload);

        return redirect()
            ->route('admin.calendar.index')
            ->with('success', 'Calendar event created successfully.');
    }

    /**
     * Display the edit-event form.
     */
    public function edit(CalendarEvent $calendar)
    {
        return view('admin.calendar.edit', [
            'event' => $calendar,
        ]);
    }

    /**
     * Update an existing calendar event.
     */
    public function update(Request $request, CalendarEvent $calendar)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'event_date' => [
                'required',
                'date',
            ],

            'event_end_date' => [
                'nullable',
                'date',
                'after_or_equal:event_date',
            ],

            'start_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'end_time' => [
                'nullable',
                'date_format:H:i',
                'after:start_time',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:draft,published,cancelled',
            ],
        ]);

        $columns = Schema::getColumnListing($calendar->getTable());
        $payload = array_intersect_key($validated, array_flip($columns));

        $calendar->update($payload);

        return redirect()
            ->route('admin.calendar.index')
            ->with('success', 'Calendar event updated successfully.');
    }

    /**
     * Delete a calendar event.
     */
    public function destroy(CalendarEvent $calendar)
    {
        $calendar->delete();

        return redirect()
            ->route('admin.calendar.index')
            ->with('success', 'Calendar event deleted successfully.');
    }
}
