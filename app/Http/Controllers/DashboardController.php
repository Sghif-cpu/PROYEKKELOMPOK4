<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display dashboard with statistics
     */
    public function index()
    {
        $today = Carbon::today();
        
        try {
            // Statistics data - PERBAIKAN: gunakan model Pasien yang benar
            $stats = [
                'total_pasien' => Pasien::count(),
                'pasien_hari_ini' => Pasien::whereDate('created_at', $today)->count(),
                'total_users' => User::count(),
                'kunjungan_bulan_ini' => Pasien::whereMonth('created_at', $today->month)
                                        ->whereYear('created_at', $today->year)
                                        ->count(),
            ];

            // Recent patients (last 5)
            $recent_pasien = Pasien::orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('dashboard', compact('stats', 'recent_pasien'));

        } catch (\Exception $e) {
            // Jika tabel pasien belum ada, tampilkan data kosong
            $stats = [
                'total_pasien' => 0,
                'pasien_hari_ini' => 0,
                'total_users' => User::count(),
                'kunjungan_bulan_ini' => 0,
            ];

            $recent_pasien = collect();

            return view('dashboard', compact('stats', 'recent_pasien'))
                ->with('error', 'Tabel pasien belum tersedia. Silakan jalankan migration.');
        }
    }
}