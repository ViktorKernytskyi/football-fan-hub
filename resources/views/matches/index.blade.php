<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Schedule</title>
</head>
<body>
<h1>Match Schedule</h1>
@if (session('client'))
    Привіт, {{ session('client')->client_name }}! Ви успішно увійшли
@else
    Привіт, Гість! Ви не увійшли
@endif


<table border="1">
    <thead>
    <tr>
        <th>Home Team</th>
        <th>Away Team</th>
        <th>Date</th>
        <th>Stadium</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($matches as $match)
        <tr>
            <td>{{ $match->team_home }}</td>
            <td>{{ $match->team_away }}</td>
            <td>{{ $match->match_date }}</td>
            <td>
                @if($match->stadium)
                    {{ $match->stadium->name }} town: {{ $match->stadium->location }}
                @else
                    No stadium assigned
                @endif

            </td>


        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
