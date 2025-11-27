<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    use HasFactory;

    protected $table = 'kasir'; // Nama tabel di database

    protected $fillable = [
        'no_antrian',
        'nama_pasien',
        'alamat',
        'no_rm',
        'no_ktp',
        'poli',
        'jenis_bayar',
        'status',
        // tambahkan kolom lain sesuai kebutuhan
    ];
}