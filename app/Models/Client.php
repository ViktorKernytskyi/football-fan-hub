<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    // Fields that can be filled in bulk - Поля, які можуть бути заповнені масово.
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    // Fields that will be hidden when converting the model to JSON - Поля, які будуть приховані при перетворенні моделі у JSON.
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
