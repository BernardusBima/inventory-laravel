<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id', // <-- TAMBAHKAN
        'supplier_id', // <-- TAMBAHKAN
        'nama_barang',
        'jumlah',
        'harga',
        'tanggal_masuk',
    ];

    /**
     * Relasi ke model Kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Relasi ke model Supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}