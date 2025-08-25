<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PergerakanBarang extends Model
{
    // database/migrations/xxxx_create_pergerakan_barangs_table.php
public function up(): void
{
    Schema::create('pergerakan_barangs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('barang_id')->constrained()->onDelete('cascade');
        $table->integer('jumlah');
        $table->enum('tipe', ['masuk', 'keluar']);
        $table->string('keterangan')->nullable();
        $table->timestamps();
    });
}
// app/Models/PergerakanBarang.php
protected $fillable = ['barang_id', 'jumlah', 'tipe', 'keterangan', 'tanggal']; // <-- Tambahkan 'tanggal'

public function barang()
{
    return $this->belongsTo(Barang::class);
}
}
