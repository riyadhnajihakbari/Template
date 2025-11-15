<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Sport;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['sport', 'tickets'])
            ->where('status', 'published')
            ->where('tanggal_mulai', '>', now());

        if ($request->sport) {
            $query->whereHas('sport', function ($q) use ($request) {
                $q->where('slug', $request->sport);
            });
        }

        if ($request->date) {
            $query->whereDate('tanggal_mulai', $request->date);
        }

        if ($request->location) {
            $query->where('lokasi', 'like', '%' . $request->location . '%');
        }

        if ($request->min_price || $request->max_price) {
            $query->whereHas('tickets', function ($q) use ($request) {
                if ($request->min_price) {
                    $q->where('harga', '>=', $request->min_price);
                }
                if ($request->max_price) {
                    $q->where('harga', '<=', $request->max_price);
                }
            });
        }

        $events = $query->orderBy('tanggal_mulai')->paginate(12);
        $sports = Sport::all();

        return view('events.index', compact('events', 'sports'));
    }

    public function show(Event $event)
    {
        $event->load(['sport', 'tickets']);
        return view('events.show', compact('event'));
    }

    public function bySport(Sport $sport)
    {
        $events = Event::with('tickets')
            ->where('sport_id', $sport->id)
            ->where('status', 'published')
            ->where('tanggal_mulai', '>', now())
            ->orderBy('tanggal_mulai')
            ->paginate(12);

        return view('events.by-sport', compact('events', 'sport'));
    }
}