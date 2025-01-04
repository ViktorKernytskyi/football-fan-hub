<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FootballMatch;

class MatchController extends Controller
{
    public function index()
    {
//        $matches = FootballMatch::all();

        $matches = FootballMatch::where('match_date', '>=', now())
            ->orderBy('match_date', 'asc')
            ->get(); // Отримуємо всі майбутні матчі
        return view('matches.index', compact('matches'));// Passing the list of matches to the view for display
    }
}
