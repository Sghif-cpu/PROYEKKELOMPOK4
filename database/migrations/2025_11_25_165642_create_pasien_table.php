<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm')->unique();
            $table->string('nama');
            $table->string('nik')->nullable()->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O'])->nullable();
            $table->text('alamat');
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('pekerjaan')->nullable();
            $table->enum('status_perkawinan', ['Belum Menikah', 'Menikah', 'Cerai'])->nullable();
            $table->enum('jenis_bayar', ['UMUM / SWASDAYA', 'BPJS PBI', 'BPJS NON PBI', 'JAMKESDA', 'UKS']);
            $table->string('no_bpjs')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('hubungan_wali')->nullable();
            $table->string('telepon_wali')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};