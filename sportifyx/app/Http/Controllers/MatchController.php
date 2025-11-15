<?php

namespace App\Http\Controllers;

use App\Models\MatchResult;

class MatchController extends Controller
{
    public function index()
    {
        $matches = MatchResult::with('sport')
            ->whereMonth('tanggal', now()->month)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('matches.index', compact('matches'));
    }
}