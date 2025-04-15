<?php

namespace App\Http\Controllers;

use App\Models\FootballMatch;
use App\Models\Ticket;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['match', 'client'])->get();
        return view('tickets.index', compact('tickets'));
    }

    // Список квитків для авторизованого користувача
    public function indexlist()
    {
        $tickets = Ticket::where('client_id', Auth::id())->with('match')->get();

        return view('tickets.index', compact('tickets'));
    }

    // Метод для покупки квитка
    public function purchase($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->purchaseBy(Auth::id());

            return back()->with('success', 'Квиток успішно придбано!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Купівля нових квитків
    public function buy(Request $request)
    {
        $request->validate([
            'match_id' => 'required|exists:matches,id',
            'quantity' => 'required|integer|min:1',
        ]);

       // $match = FootballMatch::find($request->match_id);
        $pricePerTicket = 20; // Фіксована ціна за квиток

        // Створення квитка
        for ($i = 0; $i < $request->quantity; $i++) {
            Ticket::create([
                'client_id' => Auth::id(),
                'match_id' => $request->match_id,
                'quantity' => $request->quantity,
                'total_price' => $pricePerTicket * $request->quantity,
                'price' => $pricePerTicket,
            ]);
        }
        return redirect()->route('tickets.index')->with('success', 'Квитки успішно придбані!');
    }

}
