@extends('layouts.app')

@section('title', 'Pasien Lama')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Data Pasien Lama</h2>
        <div>
            <a href="{{ route('pasien.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pasien
            </a>
            <button class="btn btn-success" onclick="exportExcel()">
                <i class="fas fa-file-excel"></i> Export
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari No RM, Nama, NIK, Telp...">
                </div>
                <div class="col-md-2">
                    <select id="filterJenisKelamin" class="form-select">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="filterJenisBayar" class="form-select">
                        <option value="">Semua Jenis Bayar</option>
                        <option value="UMUM / SWASDAYA">UMUM / SWASDAYA</option>
                        <option value="BPJS PBI">BPJS PBI</option>
                        <option value="BPJS NON PBI">BPJS NON PBI</option>
                        <option value="JAMKESDA">JAMKESDA</option>
                        <option value="UKS">UKS</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" id="filterTanggalDari" class="form-control" placeholder="Dari Tanggal">
                </div>
                <div class="col-md-2">
                    <input type="date" id="filterTanggalSampai" class="form-control" placeholder="Sampai Tanggal">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary w-100" onclick="loadData()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pasien</h5>
                    <h2 id="totalPasien">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Laki-laki</h5>
                    <h2 id="totalLaki">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Perempuan</h5>
                    <h2 id="totalPerempuan">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Pasien Baru (Bulan Ini)</h5>
                    <h2 id="totalBulanIni">0</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">No. RM</th>
                            <th width="10%">Foto</th>
                            <th width="20%">Nama Lengkap</th>
                            <th width="10%">NIK</th>
                            <th width="10%">Jenis Kelamin</th>
                            <th width="15%">Alamat</th>
                            <th width="10%">Telepon</th>
                            <th width="10%">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <select id="perPage" class="form-select form-select-sm" onchange="loadData()">
                        <option value="10">10 per halaman</option>
                        <option value="20" selected>20 per halaman</option>
                        <option value="50">50 per halaman</option>
                        <option value="100">100 per halaman</option>
                    </select>
                </div>
                <nav>
                    <ul class="pagination mb-0" id="pagination">
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalDetailContent">
                <!-- Content akan di-load via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
let currentPage = 1;
let totalPages = 1;

document.addEventListener('DOMContentLoaded', function() {
    loadData();
    
    // Search on enter
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            currentPage = 1;
            loadData();
        }
    });
});

function loadData(page = 1) {
    currentPage = page;
    
    const params = new URLSearchParams({
        page: currentPage,
        per_page: document.getElementById('perPage').value,
        search: document.getElementById('searchInput').value,
        jenis_kelamin: document.getElementById('filterJenisKelamin').value,
        jenis_bayar: document.getElementById('filterJenisBayar').value,
        tanggal_dari: document.getElementById('filterTanggalDari').value,
        tanggal_sampai: document.getElementById('filterTanggalSampai').value,
    });
    
    fetch(`/pasien/lama/data?${params}`)
        .then(response => response.json())
        .then(data => {
            renderTable(data.data);
            renderPagination(data);
            updateStats(data);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tableBody').innerHTML = 
                '<tr><td colspan="9" class="text-center text-danger">Gagal memuat data</td></tr>';
        });
}

function renderTable(data) {
    const tbody = document.getElementById('tableBody');
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" class="text-center">Tidak ada data</td></tr>';
        return;
    }

    tbody.innerHTML = data.map((item, index) => `
        <tr>
            <td>${((currentPage - 1) * 20) + index + 1}</td>
            <td><strong>${item.no_rm}</strong></td>
            <td>
                <img src="${item.foto ? '/storage/' + item.foto : '/images/no-photo.png'}" 
                     class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
            </td>
            <td>${item.nama}</td>
            <td>${item.nik || '-'}</td>
            <td>
                <span class="badge bg-${item.jenis_kelamin === 'Laki-laki' ? 'primary' : 'danger'}">
                    ${item.jenis_kelamin}
                </span>
            </td>
            <td>${item.alamat ? (item.alamat.substring(0, 30) + '...') : '-'}</td>
            <td>${item.telepon || '-'}</td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-info" onclick="viewDetail(${item.id})" title="Detail">
                        <i class="fas fa-eye"></i>
                    </button>
                    <a href="/pasien/lama/${item.id}/edit" class="btn btn-warning" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-danger" onclick="deleteData(${item.id})" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function renderPagination(data) {
    totalPages = data.last_page;
    const pagination = document.getElementById('pagination');
    
    let html = '';
    
    // Previous
    html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="loadData(${currentPage - 1}); return false;">Previous</a>
             </li>`;
    
    // Pages
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="loadData(${i}); return false;">${i}</a>
                     </li>`;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }
    
    // Next
    html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="loadData(${currentPage + 1}); return false;">Next</a>
             </li>`;
    
    pagination.innerHTML = html;
}

function updateStats(data) {
    document.getElementById('totalPasien').textContent = data.total || 0;
    // Stats lain bisa di-update via endpoint terpisah
}

function viewDetail(id) {
    fetch(`/pasien/lama/${id}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('modalDetailContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('modalDetail')).show();
        });
}

function deleteData(id) {
    if (confirm('Yakin ingin menghapus data pasien ini?\nSemua riwayat kunjungan juga akan terhapus!')) {
        fetch(`/pasien/lama/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Data berhasil dihapus');
                loadData(currentPage);
            }
        });
    }
}

function exportExcel() {
    const params = new URLSearchParams({
        search: document.getElementById('searchInput').value,
        jenis_kelamin: document.getElementById('filterJenisKelamin').value,
        jenis_bayar: document.getElementById('filterJenisBayar').value,
        tanggal_dari: document.getElementById('filterTanggalDari').value,
        tanggal_sampai: document.getElementById('filterTanggalSampai').value,
    });
    window.location.href = `/pasien/export-excel?${params}`;
}
</script>
@endsection