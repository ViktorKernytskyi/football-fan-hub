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
    // Метод для відображення сторінки покупки квитків
    public function buyTickets()
    {
        $tickets = Ticket::where('client_id')->with('match')->get();
        $matches = FootballMatch::all();
        return view('tickets.tickets_buy', compact('tickets', 'matches'));
    }
    // Купівля нових квитків
    public function buy(Request $request)
    {
       dd($request->all());
        $request->validate([
            'match_id' => 'required|exists:matches,id',
            'quantity' => 'required|integer|min:1',
        ]);
        // Знаходимо матч за його ID
        $match = FootballMatch::find($request->match_id);
        $pricePerTicket = 20; // Фіксована ціна за квиток

        // Логіка генерації місць
        // Для простоти припустимо, що є поле "seat_number" з номерами місць
        $seatNumbers = $this->generateSeatNumbers($request->quantity); // Метод для генерації місць

        // Створення квитків для кожного місця
        foreach ($seatNumbers as $seatNumber) {
            Ticket::create([
                'client_id' => Auth::id(),
                'match_id' => $request->match_id,
                'seat_number' => $seatNumber,
                'price' => $pricePerTicket,
            ]);
        }
        return redirect()->route('tickets.index')->with('success', 'Квитки успішно придбані!');
    }
        // Метод для генерації номери місць (можна додати складнішу логіку)
       private function generateSeatNumbers($quantity)
      {
        $seatNumbers = [];
        for ($i = 1; $i <= $quantity; $i++) {
            $seatNumbers[] = 'Seat ' . ($i); // Простий формат для місця
        }
        return $seatNumbers;
    }
}
