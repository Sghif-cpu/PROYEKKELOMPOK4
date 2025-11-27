@extends('layouts.app')

@section('title', 'Pasien Baru')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Tambah Pasien Baru</h2>
        <a href="{{ route('pasien.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="formPasien" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary">Data Identitas</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">No. RM <span class="text-danger">*</span></label>
                            <input type="text" name="no_rm" class="form-control" value="{{ $noRM }}" readonly required>
                            <small class="text-muted">Nomor rekam medis otomatis</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" maxlength="16">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Golongan Darah</label>
                                <select name="golongan_darah" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelurahan</label>
                                <input type="text" name="kelurahan" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kota/Kabupaten</label>
                                <input type="text" name="kota" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="text" name="provinsi" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary">Kontak & Pembayaran</h5>

                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="telepon" class="form-control" maxlength="15">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Perkawinan</label>
                                <select name="status_perkawinan" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Cerai">Cerai</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                            <select name="jenis_bayar" class="form-select" id="jenisBayar" required>
                                <option value="">Pilih</option>
                                <option value="UMUM / SWASDAYA">UMUM / SWASDAYA</option>
                                <option value="BPJS PBI">BPJS PBI</option>
                                <option value="BPJS NON PBI">BPJS NON PBI</option>
                                <option value="JAMKESDA">JAMKESDA</option>
                                <option value="UKS">UKS</option>
                            </select>
                        </div>

                        <div class="mb-3" id="bpjsField" style="display: none;">
                            <label class="form-label">No. BPJS</label>
                            <input type="text" name="no_bpjs" class="form-control" maxlength="20">
                        </div>

                        <h5 class="mb-3 mt-4 text-primary">Data Wali / Keluarga</h5>

                        <div class="mb-3">
                            <label class="form-label">Nama Wali / Keluarga</label>
                            <input type="text" name="nama_wali" class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hubungan</label>
                                <input type="text" name="hubungan_wali" class="form-control" placeholder="Ayah, Ibu, Suami, dll">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telepon Wali</label>
                                <input type="text" name="telepon_wali" class="form-control" maxlength="15">
                            </div>
                        </div>

                        <h5 class="mb-3 mt-4 text-primary">Foto Pasien</h5>
                        
                        <div class="mb-3">
                            <div class="text-center mb-3">
                                <img id="previewFoto" src="{{ asset('images/no-photo.png') }}" 
                                     class="img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
                            </div>
                            <input type="file" name="foto" class="form-control" id="inputFoto" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="text-end">
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Show/hide BPJS field
document.getElementById('jenisBayar').addEventListener('change', function() {
    const bpjsField = document.getElementById('bpjsField');
    if (this.value.includes('BPJS')) {
        bpjsField.style.display = 'block';
    } else {
        bpjsField.style.display = 'none';
    }
});

// Preview foto
document.getElementById('inputFoto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewFoto').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// Submit form
document.getElementById('formPasien').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const btnSubmit = document.getElementById('btnSubmit');
    
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    
    fetch('{{ route("pasien.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Data pasien berhasil disimpan!');
            window.location.href = '/pasien/lama/' + data.data.id;
        } else {
            alert('Gagal menyimpan data: ' + (data.message || 'Terjadi kesalahan'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan data');
    })
    .finally(() => {
        btnSubmit.disabled = false;
        btnSubmit.innerHTML = '<i class="fas fa-save"></i> Simpan Data';
    });
});
</script>
@endsection