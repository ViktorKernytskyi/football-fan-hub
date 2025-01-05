
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Schedule</title>
</head>
<body>
<h1>Match Details</h1>
<h2>{{ $match->home_team }} vs {{ $match->away_team }}</h2>
<p>Date: {{ $match->match_date->format('F j, Y, g:i a') }}</p>
<p>Stadium: {{ $match->stadium }}</p>

<h3>Available Tickets</h3>
@if($match->tickets->isEmpty())
    <p>No tickets available at the moment.</p>
@else
    <ul>
        @foreach ($match->tickets as $ticket)
            <li>
                Seat: {{ $ticket->seat_number }} - Price: ${{ $ticket->price }}
                <form action="{{ route('tickets.purchase', $ticket->id) }}" method="POST">
                    @csrf
                    <button type="submit">Buy Ticket</button>
                </form>
            </li>
        @endforeach
    </ul>
@endif
</body>
</html>
