<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laboratorium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f5f7fa;
        }
        .filter-btn.active {
            background-color: #28a745 !important;
            color: white !important;
        }
        /* Tambahan untuk responsif sidebar */
        .main-content {
            margin-left: 260px;
            transition: margin-left 0.3s;
        }
        .sidebar.collapsed ~ .main-content {
            margin-left: 70px;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 70px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    @include('components.sidebar')

    <div class="main-content">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Laboratorium</h3>
                <button class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center mb-3 gap-2">
                        <input type="date" class="form-control w-auto" />
                        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                    </div>

                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <button class="btn btn-success filter-btn">Sedang Antri</button>
                        <button class="btn btn-success filter-btn active">Telah Dilayani</button>
                        <button class="btn btn-success filter-btn">Semua</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>No Antrian</th>
                                    <th>Nama Pasien</th>
                                    <th>Dari</th>
                                    <th>Jenis Bayar</th>
                                    <th>Status</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data dinamis -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<script>
// Sinkronisasi margin main-content dengan sidebar collapse
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    function updateMargin() {
        if (sidebar.classList.contains('collapsed')) {
            mainContent.style.marginLeft = '70px';
        } else {
            mainContent.style.marginLeft = '260px';
        }
    }
    // Hook ke tombol toggle sidebar
    window.toggleSidebar = function() {
        sidebar.classList.toggle('collapsed');
        updateMargin();
    }
    updateMargin();
});
</script>
</body>
</html>