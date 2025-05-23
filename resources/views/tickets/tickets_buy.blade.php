<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Tickets</title>
</head>
<body>
<h1>Buy Tickets</h1>
<div class="col-sm-8">
    <div class="menu pull-right">
        <ul class="nav navbar-nav ms-auto">
            <li><a href="{{ route('matches.home') }}"><i class="fa fa-crosshairs"></i>Upcoming Matches</a></li>
            <li><a href="{{ route('matches.index') }}"><i class="fa fa-crosshair"></i> Match Schedule</a></li>
            <li><a href="{{ route('news.index') }}"><i class="fa fa-crosshairs"></i> Latest Football News</a></li>
            <li><a href="{{ route('tickets.index') }}"><i class="fa fa-crosshairs"></i> My Tickets</a></li>
        </ul>
    </div>
</div>

{{-- Повідомлення про успішні операції або помилки --}}
@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if($errors->any())
    <p style="color: red;">{{ implode('', $errors->all(':message')) }}</p>
@endif

{{-- Форма купівлі квитків --}}
<form method="POST" action="{{ route('tickets.buy') }}">
    @csrf
    <label>Оберіть матч:</label>
    <select name="match_id" required>
        @foreach($matches as $match)
            <option value="{{ $match->id }}">{{ $match->team_home }} vs {{ $match->team_away }} ({{ $match->date }})</option>
        @endforeach
    </select>

    <label>Кількість:</label>
    <input type="number" name="quantity" min="1" value="1" required>

    <button type="submit">Купити квитки</button>
</form>

<br><br>

{{-- Таблиця квитків користувача --}}
<table border="1">
    <thead>
    <tr>
        <th>Match</th>
        <th>Seat Number</th>
        <th>Price</th>
        <th>Дія</th>
        <th>quantity</th>
        <th>total_price</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tickets as $ticket)
        <tr>
            <td>{{ $ticket->match->team_home }} vs {{ $ticket->match->team_away }}</td>
            <td>{{ $ticket->seat_number ?? 'N/A' }}</td>
            <td>{{ $ticket->price ?? 'N/A' }}</td>
            <td>{{ $ticket->quantity ?? 1 }}</td>
            <td>{{ $ticket->total_price ?? $ticket->price }}</td>

            <td>
                @if($ticket->client_id === null)
                    <form method="POST" action="{{ route('tickets.purchase', $ticket->id) }}">
                        @csrf
                        <button type="submit">Придбати</button>
                    </form>
                @else
                    <span>Придбано</span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
