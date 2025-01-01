<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FootballMatch;

class MatchController extends Controller
{
    public function index()
    {
        $matches = FootballMatch::all();
       echo "I see page";
        return view('matches.index', compact('matches'));
    }
}
