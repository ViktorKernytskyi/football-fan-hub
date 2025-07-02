<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Matches</title>
</head>
<body>
<h1>Upcoming Matches</h1>
<div class="col-sm-8">
    <div class="menu pull-right">
        <ul class="nav navbar-nav ms-auto">
            <li><a href="{{ route('matches.home') }}"><i class="fa fa-crosshairs"></i>Upcoming Matches</a></li>
            <li><a href="{{ route('matches.index') }}"><i class="fa fa-crosshair"></i> Match Schedule</a></li>
            <li><a href="{{ route('news.index') }}"><i class="fa fa-crosshairs"></i> Latest Football News</a></li>
            <li><a href="{{ route('tickets.store') }}"><i class="fa fa-crosshairs"></i> My Tickets</a></li>
        </ul>
    </div>
</div>
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
