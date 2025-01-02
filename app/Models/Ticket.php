<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Fields that can be filled in bulk - Поля, які можуть бути заповнені масово.
    protected $fillable = [
        'match_id',
        'user_id',
        'seat_number',
        'price',
    ];

    // Determining the relationship with the match table - Визначення зв'язку з таблицею матчів
    public function match()
    {
        return $this->belongsTo(FootballMatch::class);
    }

    // Defining a relationship with the users table - Визначення зв'язку з таблицею користувачів
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
