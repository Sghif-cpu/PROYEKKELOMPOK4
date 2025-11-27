<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasien = Pasien::orderBy('created_at', 'desc')->paginate(10);
        return view('pasien.index', compact('pasien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $noRM = $this->generateNoRM();
        return view('pasien.create', compact('noRM'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'no_rm' => 'required|unique:pasien,no_rm',
                'nama' => 'required|string|max:255',
                'nik' => 'nullable|string|max:16|unique:pasien,nik',
                'tempat_lahir' => 'required|string|max:100',
                'tanggal_lahir' => 'required|date|before:today',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'golongan_darah' => 'nullable|in:A,B,AB,O',
                'alamat' => 'required|string|max:500',
                'kelurahan' => 'nullable|string|max:100',
                'kecamatan' => 'nullable|string|max:100',
                'kota' => 'nullable|string|max:100',
                'provinsi' => 'nullable|string|max:100',
                'telepon' => 'nullable|string|max:15|regex:/^[0-9]+$/',
                'email' => 'nullable|email|max:255|unique:pasien,email',
                'pekerjaan' => 'nullable|string|max:100',
                'status_perkawinan' => 'nullable|in:Belum Menikah,Menikah,Cerai',
                'jenis_bayar' => 'required|in:UMUM / SWASDAYA,BPJS PBI,BPJS NON PBI,JAMKESDA,UKS',
                'no_bpjs' => 'nullable|string|max:20',
                'nama_wali' => 'nullable|string|max:255',
                'hubungan_wali' => 'nullable|string|max:50',
                'telepon_wali' => 'nullable|string|max:15|regex:/^[0-9]+$/',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'no_rm.required' => 'Nomor RM wajib diisi',
                'no_rm.unique' => 'Nomor RM sudah terdaftar',
                'nama.required' => 'Nama lengkap wajib diisi',
                'nik.unique' => 'NIK sudah terdaftar',
                'nik.max' => 'NIK maksimal 16 digit',
                'tempat_lahir.required' => 'Tempat lahir wajib diisi',
                'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
                'tanggal_lahir.before' => 'Tanggal lahir tidak boleh lebih dari hari ini',
                'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
                'alamat.required' => 'Alamat lengkap wajib diisi',
                'telepon.regex' => 'Nomor telepon hanya boleh berisi angka',
                'telepon_wali.regex' => 'Nomor telepon wali hanya boleh berisi angka',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'jenis_bayar.required' => 'Jenis pembayaran wajib dipilih',
                'foto.image' => 'File harus berupa gambar',
                'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg',
                'foto.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Handle upload foto
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoName = 'pasien_' . time() . '_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
                $fotoPath = $foto->storeAs('pasien', $fotoName, 'public');
                $data['foto'] = $fotoPath;
            }

            // Jika bukan BPJS, set no_bpjs ke null
            if (!str_contains($data['jenis_bayar'], 'BPJS')) {
                $data['no_bpjs'] = null;
            }

            // Format tanggal lahir
            $data['tanggal_lahir'] = Carbon::parse($data['tanggal_lahir'])->format('Y-m-d');

            $pasien = Pasien::create($data);

            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($pasien)
                ->log('Menambah pasien baru: ' . $pasien->nama);

            return response()->json([
                'success' => true,
                'message' => 'Data pasien berhasil disimpan',
                'data' => $pasien
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Error storing patient: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $pasien = Pasien::findOrFail($id);
            return view('pasien.show', compact('pasien'));
        } catch (\Exception $e) {
            return redirect()->route('pasien.index')
                ->with('error', 'Data pasien tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $pasien = Pasien::findOrFail($id);
            return view('pasien.edit', compact('pasien'));
        } catch (\Exception $e) {
            return redirect()->route('pasien.index')
                ->with('error', 'Data pasien tidak ditemukan');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $pasien = Pasien::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'nik' => 'nullable|string|max:16|unique:pasien,nik,' . $id,
                'tempat_lahir' => 'required|string|max:100',
                'tanggal_lahir' => 'required|date|before:today',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'golongan_darah' => 'nullable|in:A,B,AB,O',
                'alamat' => 'required|string|max:500',
                'kelurahan' => 'nullable|string|max:100',
                'kecamatan' => 'nullable|string|max:100',
                'kota' => 'nullable|string|max:100',
                'provinsi' => 'nullable|string|max:100',
                'telepon' => 'nullable|string|max:15|regex:/^[0-9]+$/',
                'email' => 'nullable|email|max:255|unique:pasien,email,' . $id,
                'pekerjaan' => 'nullable|string|max:100',
                'status_perkawinan' => 'nullable|in:Belum Menikah,Menikah,Cerai',
                'jenis_bayar' => 'required|in:UMUM / SWASDAYA,BPJS PBI,BPJS NON PBI,JAMKESDA,UKS',
                'no_bpjs' => 'nullable|string|max:20',
                'nama_wali' => 'nullable|string|max:255',
                'hubungan_wali' => 'nullable|string|max:50',
                'telepon_wali' => 'nullable|string|max:15|regex:/^[0-9]+$/',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = $validator->validated();

            // Handle upload foto baru
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($pasien->foto && Storage::disk('public')->exists($pasien->foto)) {
                    Storage::disk('public')->delete($pasien->foto);
                }

                $foto = $request->file('foto');
                $fotoName = 'pasien_' . time() . '_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
                $fotoPath = $foto->storeAs('pasien', $fotoName, 'public');
                $data['foto'] = $fotoPath;
            }

            // Jika bukan BPJS, set no_bpjs ke null
            if (!str_contains($data['jenis_bayar'], 'BPJS')) {
                $data['no_bpjs'] = null;
            }

            // Format tanggal lahir
            $data['tanggal_lahir'] = Carbon::parse($data['tanggal_lahir'])->format('Y-m-d');

            $pasien->update($data);

            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($pasien)
                ->log('Memperbarui data pasien: ' . $pasien->nama);

            return redirect()->route('pasien.show', $pasien->id)
                ->with('success', 'Data pasien berhasil diperbarui');

        } catch (\Exception $e) {
            \Log::error('Error updating patient: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pasien = Pasien::findOrFail($id);

            // Hapus foto jika ada
            if ($pasien->foto && Storage::disk('public')->exists($pasien->foto)) {
                Storage::disk('public')->delete($pasien->foto);
            }

            $pasien->delete();

            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->log('Menghapus pasien: ' . $pasien->nama);

            return response()->json([
                'success' => true,
                'message' => 'Data pasien berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error deleting patient: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate nomor RM otomatis sesuai format OPUS
     */
    private function generateNoRM()
    {
        $currentYear = date('y');
        $currentMonth = date('m');
        
        $lastPasien = Pasien::where('no_rm', 'like', 'RM' . $currentYear . $currentMonth . '%')
            ->orderBy('no_rm', 'desc')
            ->first();
        
        if ($lastPasien) {
            $lastNumber = (int) substr($lastPasien->no_rm, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'RM' . $currentYear . $currentMonth . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Untuk halaman pasien lama (sesuai dengan redirect di JavaScript)
     */
    public function pasienLama($id)
    {
        try {
            $pasien = Pasien::findOrFail($id);
            return view('pasien.show', compact('pasien'));
        } catch (\Exception $e) {
            return redirect()->route('pasien.index')
                ->with('error', 'Data pasien tidak ditemukan');
        }
    }

    /**
     * Search patients for autocomplete
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        $pasien = Pasien::where('nama', 'like', "%{$search}%")
            ->orWhere('no_rm', 'like', "%{$search}%")
            ->orWhere('nik', 'like', "%{$search}%")
            ->limit(10)
            ->get(['id', 'no_rm', 'nama', 'nik', 'telepon']);

        return response()->json($pasien);
    }

    /**
     * Get patient data by ID for API
     */
    public function getPasien($id)
    {
        try {
            $pasien = Pasien::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $pasien
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pasien tidak ditemukan'
            ], 404);
        }
    }
}