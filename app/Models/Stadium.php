<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Stadium extends Model
{
    protected $table = 'stadiums';
    protected $fillable = [
        'name',
        'location',
        'seat_count',
        'address'];

    public function matches()
    {
        return $this->hasMany(FootballMatch::class);
    }

}
