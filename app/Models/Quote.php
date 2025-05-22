<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    // Jika nama tabel di database bukan 'quotes', definisikan secara eksplisit:
    // protected $table = 'nama_tabel';

    // Field yang boleh diisi (mass assignment)
    protected $fillable = [
        'text',       // ganti sesuai nama kolom di tabel
        'author',     // ganti sesuai nama kolom di tabel
        // tambahkan field lain jika ada
    ];
}