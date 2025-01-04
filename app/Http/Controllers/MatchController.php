<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FootballMatch;

class MatchController extends Controller
{
    public function index()
    {
        // If this is a page with a full list of matches
        if (request()->routeIs('matches.index')) {
            $matches = $this->getAllMatches();
            return view('matches.index', compact('matches'));
        }

        // For the main page, where we limit the number to 10
        $matches = $this->getUpcomingMatches();
        return view('matches.home', compact('matches'));
    }

    // Logic for the page with the full list of matches
    private function getAllMatches()
    {
        return FootballMatch::where('match_date', '>=', now())
            ->orderBy('match_date', 'asc')
            ->get();
    }

    // Logic for the main page
    private function getUpcomingMatches()
    {
        return FootballMatch::where('match_date', '>=', now())
            ->orderBy('match_date', 'asc')
            ->take(10) // limit up to 10 matches
            ->get();

    }
}
