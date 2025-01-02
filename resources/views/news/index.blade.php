<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football News</title>
</head>
<body>

<div class="news-section">
    <h1>Latest Football News</h1>

    <!-- Checking for news - Перевірка чи є новини -->
    @if($news->isEmpty())
        <p>No news available at the moment.</p>
    @else
        <ul>
            @foreach ($news as $article)
                <li class="news-item">
                    <h2>{{ $article->title }}</h2>
                    <p>{{ Str::limit($article->content, 200) }}...</p>
                    <p><small>Published on: {{ $article->published_date }}</small></p>
                    <a href="{{ url('news/'.$article->id) }}" class="read-more">Read more</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

</body>
</html>
