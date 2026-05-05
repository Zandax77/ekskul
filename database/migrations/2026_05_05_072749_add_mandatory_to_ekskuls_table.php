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
        Schema::table('ekskuls', function (Blueprint $table) {
            $table->boolean('is_wajib')->default(false);
            $table->string('wajib_kelas')->nullable(); // e.g. "X,XI"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ekskuls', function (Blueprint $table) {
            $table->dropColumn(['is_wajib', 'wajib_kelas']);
        });
    }
};
