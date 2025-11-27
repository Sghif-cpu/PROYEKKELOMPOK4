<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function lama()
    {
        // Tampilkan view pendaftaran pasien lama
        return view('pendaftaran.lama');
    }

    public function baru()
    {
        // Tampilkan view pendaftaran pasien baru
        return view('pendaftaran.baru');
    }
}
