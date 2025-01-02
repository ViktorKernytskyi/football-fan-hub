<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballMatch extends Model
{
    use HasFactory;

    protected $table = 'matches'; // Name of the table in the database
   // protected $fillable = ['team1', 'team2', 'match_date', 'stadium', 'score'];

    // Fields that can be filled in bulk - Поля, які можуть бути заповнені масово.
    protected $fillable = [
        'team_home',
        'team_away',
        'match_date',
        'stadium',

    ];
    // Defining a relationship with the ticket table - Визначення зв'язку з таблицею квитків
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

}
