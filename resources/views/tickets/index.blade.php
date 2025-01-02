<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets</title>
</head>
<body>
<h1>My Tickets</h1>
<table border="1">
    <thead>
    <tr>
        <th>Match</th>
        <th>Seat Number</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tickets as $ticket)
        <tr>
            <td>{{ $ticket->match->team_home }} vs {{ $ticket->match->team_away }}</td>
            <td>{{ $ticket->seat_number }}</td>
            <td>{{ $ticket->price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
