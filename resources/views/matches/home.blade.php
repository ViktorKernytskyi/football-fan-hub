<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Matches</title>
</head>
<body>
<h1>Upcoming Matches</h1>
<ul>
    @foreach ($matches as $match)
        <li>
            <h2>{{ $match->home_team }} vs {{ $match->away_team }}</h2>
            <p>Date: {{ $match->match_date->format('F j, Y, g:i a') }}</p>
            <p>Stadium: {{ $match->stadium }}</p>
        </li>
    @endforeach
</ul>
</body>
</html>
