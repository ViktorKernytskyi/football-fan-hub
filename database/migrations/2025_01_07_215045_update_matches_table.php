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
            if (!Schema::hasColumn('matches', 'stadium_id')) {
                $table->foreignId('stadium_id') // Adding a foreign key for the stadium - Додаємо зовнішній ключ для стадіону
                    ->constrained('stadiums')  // Link to the stadiums table - Зв'язуємо з таблицею stadiums
                    ->onDelete('cascade');  // if a stadium is deleted, all matches with it are also deleted - Якщо стадіон видаляється, то всі матчі з ним теж видаляються

                $table->softDeletes();
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropForeign(['stadium_id']); // Removing a foreign key - Видаляємо зовнішній ключ
            $table->dropColumn('stadium_id'); // Delete the stadium_id column - Видаляємо колонку stadium_id
        });
    }
};
