<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratorium extends Model
{
    use HasFactory;

    protected $table = 'laboratorium';

    protected $fillable = [
        'no_antrian',
        'nama_pasien',
        'dari',
        'jenis_bayar',
        'status'
    ];
}
