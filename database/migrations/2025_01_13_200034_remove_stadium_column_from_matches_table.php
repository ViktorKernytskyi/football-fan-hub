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
        Schema::table('matches', function (Blueprint $table) {
            if (Schema::hasColumn('matches', 'stadium')) {
                $table->dropColumn('stadium'); // Removing the old column - Видаляємо стару колонку
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->string('stadium')->nullable(); // We turn the column - Повертаємо колонку

        });
    }
};
