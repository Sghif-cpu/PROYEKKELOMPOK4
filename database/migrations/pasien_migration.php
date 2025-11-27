<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            
            // Data Identitas
            $table->string('no_rm', 20)->unique();
            $table->string('nama', 255);
            $table->string('nik', 16)->nullable();
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir', 100);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            
            // Alamat
            $table->text('alamat');
            $table->string('kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            
            // Kontak
            $table->string('telepon', 15)->nullable();
            $table->string('email', 100)->nullable();
            
            // Data Medis
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O'])->nullable();
            
            // Pembayaran
            $table->string('jenis_bayar', 50);
            $table->string('no_bpjs', 20)->nullable();
            
            // Data Tambahan
            $table->string('pekerjaan', 100)->nullable();
            $table->enum('status_perkawinan', ['Belum Menikah', 'Menikah', 'Cerai'])->nullable();
            
            // Data Wali/Keluarga
            $table->string('nama_wali', 255)->nullable();
            $table->string('hubungan_wali', 50)->nullable();
            $table->string('telepon_wali', 15)->nullable();
            
            // Foto
            $table->string('foto', 255)->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('no_rm');
            $table->index('nama');
            $table->index('nik');
            $table->index('jenis_kelamin');
            $table->index('jenis_bayar');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};