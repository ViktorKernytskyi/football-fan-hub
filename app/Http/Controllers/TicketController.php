<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['match', 'client'])->get();
        return view('tickets.index', compact('tickets'));
    }

    // Метод для покупки квитка
    public function purchase($id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->client_id) {
            return back()->withErrors(['error' => 'This ticket is no longer available.']);
        }

        // Прив'язка квитка до клієнта (припускаємо, що є авторизований користувач)
        $ticket->update(['client_id' => auth()->id()]);

        return back()->with('success', 'Ticket purchased successfully!');
    }

}
