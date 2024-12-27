<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary(); // id as autoincrement value, primary key
            $table->integer('match_id'); // match_id як int (foreign key)
            $table->integer('client_id'); // client_id as int (foreign key, reference to the clients table)
            $table->string('seat_number'); // seat_number як varchar
            $table->decimal('price', 8, 2); // price as decimal with 8 digits, 2 of which are after the decimal point
            $table->timestamps(); // creating fields to save time

            // Foreign keys
            $table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
