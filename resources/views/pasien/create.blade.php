<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pasien</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Tambah Pasien</h4>
        </div>

        <div class="card-body">
            <form id="formPasien">

                <div class="row">
                    <!-- No Rekam Medis -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No Rekam Medis (Auto)</label>
                        <input type="text" id="no_rm" class="form-control" readonly>
                    </div>

                    <!-- Nama -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Pasien</label>
                        <input type="text" id="nama" class="form-control" required>
                    </div>

                    <!-- NIK -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" id="nik" class="form-control" maxlength="16" required>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select id="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" class="form-control">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" class="form-control">
                    </div>

                    <!-- No HP -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" id="no_hp" class="form-control">
                    </div>

                    <!-- Alamat -->
                    <div class="col-12 mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea id="alamat" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Foto -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto Pasien</label>
                        <input type="file" id="fotoInput" class="form-control" accept="image/*">
                    </div>

                    <!-- Preview -->
                    <div class="col-md-6 mb-3 text-center">
                        <img id="previewFoto" src="https://via.placeholder.com/120" 
                             class="img-thumbnail" width="150">
                    </div>
                </div>

                <button class="btn btn-success mt-3 w-100" type="submit">Simpan Pasien</button>
            </form>
        </div>
    </div>
</div>

<!-- JS -->
<script>
// AUTO GENERATE RM ---------------------------------------
function generateNoRM() {
    let tgl = new Date();
    let y = tgl.getFullYear().toString().slice(2);
    let m = ("0" + (tgl.getMonth() + 1)).slice(-2);
    let d = ("0" + tgl.getDate()).slice(-2);
    let rand = Math.floor(100 + Math.random() * 900);

    return "RM" + y + m + d + rand;
}

document.getElementById("no_rm").value = generateNoRM();


// PREVIEW FOTO -------------------------------------------
let fotoBase64 = "";

document.getElementById("fotoInput").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        fotoBase64 = e.target.result;
        document.getElementById("previewFoto").src = fotoBase64;
    };
    reader.readAsDataURL(file);
});


// SAVE DATA + REDIRECT ------------------------------------
document.getElementById("formPasien").addEventListener("submit", function(e) {
    e.preventDefault();  

    let pasien = {
        rm: document.getElementById("no_rm").value,
        nama: document.getElementById("nama").value,
        nik: document.getElementById("nik").value,
        jk: document.getElementById("jenis_kelamin").value,
        tempat_lahir: document.getElementById("tempat_lahir").value,
        tanggal_lahir: document.getElementById("tanggal_lahir").value,
        no_hp: document.getElementById("no_hp").value,
        alamat: document.getElementById("alamat").value,
        foto: fotoBase64
    };

    // Ambil data lama
    let data = JSON.parse(localStorage.getItem("dataPasien")) || [];

    // Tambahkan pasien baru
    data.push(pasien);

    // Simpan kembali
    localStorage.setItem("dataPasien", JSON.stringify(data));

    // Redirect kembali ke index.html
    alert("Pasien berhasil disimpan!");
    window.location.href = "index.html";  
});
</script>

</body>
</html>
