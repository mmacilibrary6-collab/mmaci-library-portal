<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\NewArrival;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $events = CalendarEvent::query()
            ->where('status', 'published')
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        $arrivals = NewArrival::query()
            ->where('resource_type', 'printed')
            ->where('availability_status', 'available')
            ->orderByDesc('arrival_date')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        return view('home', compact(
            'events',
            'arrivals'
        ));
    }
}