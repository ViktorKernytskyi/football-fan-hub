@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
    <title>Match Schedule</title>


<body>
<h1>Match Schedule</h1>
<div  class="col-sm-8">
    @if (session('client'))
        @auth('client')

            <a class="nav-link">
                <form method="post" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" style="border: unset; background: white">
                        Привіт, {{ session('client')->client_name }}! Ви успішно увійшли
{{--                        /--}}
{{--                        <i class="fa fa-unlock"></i>--}}
{{--                        Logout--}}
                    </button>
                </form>
            </a>

        @endauth
    @else
        Привіт, Гість! Ви не увійшли
    @endif
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
</div>

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

<table class="table table-bordered">
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
@endsection
