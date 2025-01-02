<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //  Method for displaying all news - Метод для відображення всіх новин
    public function index()
    {
        $news = News::latest()->take(10)->get(); // We get the last 10 news - Отримуємо останні 10 новин
        return view('news.index', compact('news'));
    }

    // Method for viewing a full news article - Метод для перегляду повної статті новини
    public function show($id)
    {
        $news = News::findOrFail($id); // Searching for news by ID - Шукаємо новину за ID
        return view('news.show', compact('news'));
    }
}
