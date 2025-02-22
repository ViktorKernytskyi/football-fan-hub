<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name;
    public $token;

    public function __construct($name, $token)
    {
        $this->name = $name;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Замінили на роботу з моделлю Client
        $client = Client::where('email', $this->name)->first(); // Заміна на пошук по email у таблиці clients
        if ($client) {
            $user['name'] = $client->name;
            $user['token'] = $this->token;
        } else {
            // Якщо клієнт не знайдений, можна додати обробку помилки
            $user['name'] = $this->name;
            $user['token'] = $this->token;
        }

        return $this->from("yoursenderemail@mail.com", "Sender Name")
            ->subject('Password Reset Link')
            ->view('template.reset-password', ['user' => $user]);
    }
}
