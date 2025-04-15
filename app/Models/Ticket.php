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
        'client_id',
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

    // Обчислення проданих квитків
    public static function soldTickets($matchId)
    {
        return self::where('match_id', $matchId)->whereNotNull('client_id')->count();
    }

    // Обчислення доступних квитків
    public static function availableTickets($matchId, $seatCount)
    {
        $soldTickets = self::soldTickets($matchId);
        return $seatCount - $soldTickets;
    }
    //  Метод для покупки квитка
    public function purchaseBy($clientId)
    {
        if ($this->client_id !== null) {
            throw new \Exception('Цей квиток вже придбано.');
        }

        $this->update([
            'client_id' => $clientId,
        ]);
    }

    //  Метод для створення нового квитка для користувача (наприклад, адміністратора)
    public static function createForUser(array $data): self
    {
        return self::create([
            'match_id' => $data['match_id'],
            'client_id' => $data['client_id'], // або null, якщо ще не продано
            'seat_number' => $data['seat_number'] ?? null,
            'price' => $data['price'] ?? 20, // якщо не вказано — фіксована ціна
        ]);
    }
}
