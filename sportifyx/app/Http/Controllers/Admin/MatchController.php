<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MatchResult;
use App\Models\Sport;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
    {
        $matches = MatchResult::with('sport')->latest('tanggal')->paginate(15);
        return view('admin.matches.index', compact('matches'));
    }

    public function create()
    {
        $sports = Sport::all();
        return view('admin.matches.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'team_a' => 'required|string|max:255',
            'team_b' => 'required|string|max:255',
            'score_a' => 'required|integer|min:0',
            'score_b' => 'required|integer|min:0',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'highlight_url' => 'nullable|url',
        ]);

        MatchResult::create($validated);

        return redirect()->route('admin.matches.index')->with('success', 'Hasil pertandingan berhasil ditambah');
    }

    public function edit(MatchResult $match)
    {
        $sports = Sport::all();
        return view('admin.matches.edit', compact('match', 'sports'));
    }

    public function update(Request $request, MatchResult $match)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'team_a' => 'required|string|max:255',
            'team_b' => 'required|string|max:255',
            'score_a' => 'required|integer|min:0',
            'score_b' => 'required|integer|min:0',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'highlight_url' => 'nullable|url',
        ]);

        $match->update($validated);

        return redirect()->route('admin.matches.index')->with('success', 'Hasil pertandingan berhasil diupdate');
    }

    public function destroy(MatchResult $match)
    {
        $match->delete();
        return redirect()->route('admin.matches.index')->with('success', 'Hasil pertandingan berhasil dihapus');
    }
}