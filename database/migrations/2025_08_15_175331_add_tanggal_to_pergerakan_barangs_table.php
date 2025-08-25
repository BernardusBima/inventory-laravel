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
        Schema::table('pergerakan_barangs', function (Blueprint $table) {
            $table->date('tanggal')->after('tipe')->nullable(); // <-- TAMBAHKAN INI
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pergerakan_barangs', function (Blueprint $table) {
            //
        });
    }
};
