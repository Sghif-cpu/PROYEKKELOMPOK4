<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laboratorium; // opsional jika pakai model
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaboratoriumExport; // opsional bila pakai export

class LaboratoriumController extends Controller
{
    public function index(Request $request)
    {
        return view('laboratorium.index'); 
    }

    public function getData(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today()->toDateString();
        $status  = $request->status ?? 'semua';

        // Contoh data dummy (nanti bisa dihubungkan ke DB)
        $data = [
            [
                'no_antrian' => 'LAB-001',
                'nama_pasien' => 'Budi Santoso',
                'dari' => 'Poli Umum',
                'jenis_bayar' => 'BPJS',
                'status' => 'Telah Dilayani',
            ],
            [
                'no_antrian' => 'LAB-002',
                'nama_pasien' => 'Siti Aminah',
                'dari' => 'IGD',
                'jenis_bayar' => 'Umum',
                'status' => 'Sedang Antri',
            ]
        ];

        // Filter status
        if ($status !== 'semua') {
            $data = array_filter($data, function($item) use ($status) {
                return strtolower(str_replace(' ', '_', $item['status'])) == strtolower($status);
            });
        }

        return response()->json(array_values($data));
    }

    public function exportExcel()
    {
        return Excel::download(new LaboratoriumExport, 'laboratorium.xlsx');
    }
}
