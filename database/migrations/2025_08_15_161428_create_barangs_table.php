<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_xxxxxx_create_barangs_table.php
public function up(): void
{
    Schema::create('barangs', function (Blueprint $table) {
        $table->id(); // Otomatis jadi id (BIGINT, PRIMARY KEY, AUTO_INCREMENT)
        $table->string('nama_barang');
        $table->integer('jumlah');
        $table->decimal('harga', 10, 2);
        $table->date('tanggal_masuk');
        $table->timestamps(); // Otomatis membuat kolom created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
