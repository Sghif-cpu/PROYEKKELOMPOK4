<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Pasien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pasien';

    protected $fillable = [
        'no_rm',
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'telepon',
        'email',
        'pekerjaan',
        'status_perkawinan',
        'jenis_bayar',
        'no_bpjs',
        'nama_wali',
        'hubungan_wali',
        'telepon_wali',
        'foto'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Accessor untuk usia
     */
    public function getUsiaAttribute()
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    /**
     * Accessor untuk foto URL
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/no-photo.png');
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_rm', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
    }
}