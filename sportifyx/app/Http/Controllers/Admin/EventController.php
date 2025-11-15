<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Sport;
use App\Models\Ticket;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('sport')->latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $sports = Sport::all();
        return view('admin.events.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lokasi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'poster' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'tickets' => 'required|array',
            'tickets.*.kategori' => 'required|in:VVIP,VIP,Reguler,Ekonomi',
            'tickets.*.harga' => 'required|numeric|min:0',
            'tickets.*.kuota' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $event = Event::create($validated);

        foreach ($request->tickets as $ticketData) {
            Ticket::create([
                'event_id' => $event->id,
                'kategori' => $ticketData['kategori'],
                'harga' => $ticketData['harga'],
                'kuota' => $ticketData['kuota'],
            ]);
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat');
    }

    public function edit(Event $event)
    {
        $sports = Sport::all();
        $event->load('tickets');
        return view('admin.events.edit', compact('event', 'sports'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lokasi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'poster' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diupdate');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus');
    }
}