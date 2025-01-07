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
        Schema::create('stadiums', function (Blueprint $table) {
            $table->id(); // Unique stadium identifier - Унікальний ідентифікатор стадіону
            $table->string('name'); // Stadium name - Назва стадіону
            $table->string('location'); // Місце розташування (місто)
            $table->integer('seat_count'); // Number of seats in the stadium - Кількість місць на стадіоні
            $table->string('address'); // Stadium address - Адреса стадіону
            $table->timestamps();


            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stadiums');
    }
};
