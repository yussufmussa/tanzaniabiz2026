<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BusinessEvent;
use Illuminate\Http\Request;

class BusinessEventPageController extends Controller
{
    public function allEvents()
{
    $today = now()->toDateString();

    $events = BusinessEvent::query()
        ->select('*')
        ->selectRaw("CASE WHEN closing_date >= ? THEN 'upcoming' ELSE 'ended' END as status", [$today])
        ->orderByDesc('starting_date')
        ->paginate(30);

    return view('frontend.pages.events.all', compact('events'));
}

    public function eventDetail(string $slug)
    {
        $event = BusinessEvent::query()
            ->where('slug', $slug)
            ->firstOrFail();


        $moreEvents = BusinessEvent::query()
            ->whereDate('closing_date', '>=', now()->toDateString())
            ->where('id', '!=', $event->id)
            ->orderBy('starting_date')
            ->limit(6)
            ->get();

        return view('frontend.pages.events.details', compact('event', 'moreEvents'));
    }
}
