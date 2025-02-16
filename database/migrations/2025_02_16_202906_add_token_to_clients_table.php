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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('token', 255)->nullable()->after('email');
            $table->boolean('is_verified')->default(0); // додаємо поле is_verified
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('token');
            $table->dropColumn('is_verified'); // скасовуємо зміни в разі відкату
        });
    }
};
