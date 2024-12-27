<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballMatch extends Model
{
    use HasFactory;

    protected $table = 'matches'; // Name of the table in the database
   // protected $fillable = ['team1', 'team2', 'match_date', 'stadium', 'score'];
}
