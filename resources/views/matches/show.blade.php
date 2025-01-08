
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


<h3>Stadium Details</h3>
<p>Stadium: {{ $match->stadium->name }}</p>
<p>Location: {{ $match->stadium->location }}</p>
<p>Address: {{ $match->stadium->address }}</p>
<p>Total Seats: {{ $match->stadium->seat_count }}</p>


<h3>Ticket Information</h3>
<p>Sold Tickets: {{ $soldTickets }}</p>
<p>Available Tickets: {{ $availableTickets }}</p>

@if($availableTickets > 0)
    <h3>Available Tickets</h3>
    <ul>
        @foreach($match->tickets->whereNull('client_id') as $ticket)
            <li>
                Seat: {{ $ticket->seat_number }} - Price: ${{ $ticket->price }}
                <form action="{{ route('tickets.purchase', $ticket->id) }}" method="POST">
                    @csrf
                    <button type="submit">Buy</button>
                </form>
            </li>
        @endforeach
    </ul>
@else
    <p>No tickets available at the moment.</p>
@endif



{{--<p>Stadium: {{ $match->stadium }}</p>--}}

{{--<h3>Available Tickets</h3>--}}
{{--@if($match->tickets->isEmpty())--}}
{{--    <p>No tickets available at the moment.</p>--}}
{{--@else--}}
{{--    <ul>--}}
{{--        @foreach ($match->tickets as $ticket)--}}
{{--            <li>--}}
{{--                Seat: {{ $ticket->seat_number }} - Price: ${{ $ticket->price }}--}}
{{--                <form action="{{ route('tickets.purchase', $ticket->id) }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <button type="submit">Buy Ticket</button>--}}
{{--                </form>--}}
{{--            </li>--}}
{{--        @endforeach--}}
{{--    </ul>--}}
{{--@endif--}}
</body>
</html>
