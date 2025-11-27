<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        // Tampilkan form kasir
        return view('kasir.index');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_rm'         => 'required|string|max:50',
            'nama_pasien'   => 'required|string|max:100',
            'jenis_layanan' => 'required|string',
            'biaya'         => 'required|numeric|min:0',
            'bayar'         => 'required|numeric|min:0',
        ]);

        // Proses pembayaran (contoh: simpan ke database, dsb)
        // Kasus ini hanya menampilkan pesan sukses

        return redirect()->route('kasir.index')->with('success', 'Pembayaran berhasil diproses!');
    }
}