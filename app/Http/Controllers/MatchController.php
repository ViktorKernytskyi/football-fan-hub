<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
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

    private function getMatchDetails($id = null)
    {
        // If the ID is passed, we look for a matching match - Якщо ID передано, шукаємо відповідний матч
        if ($id) {
            $match = FootballMatch::with('stadium', 'tickets')->findOrFail($id);
        } else {
            // If ID is not passed, we take the first match as the default - Якщо ID не передано, беремо перший матч як дефолтний
            $match = FootballMatch::with('stadium', 'tickets')->first();
            if (!$match) {
                abort(404, 'No matches found.');
            }
        }

        // We count sold and available tickets - Рахуємо продані та доступні квитки
        $soldTickets = Ticket::soldTickets($match->id);
        $availableTickets = Ticket::availableTickets($match->id, $match->stadium->seat_count);

        return [
            'match' => $match,
            'soldTickets' => $soldTickets,
            'availableTickets' => $availableTickets,
        ];
    }
    public function show($id)
    {
        $data = $this->getMatchDetails($id);
        return view('matches.show', $data);
    }
    public function showDefault()
    {
        $data = $this->getMatchDetails();
        return view('matches.show', $data);
    }



}
