<!DOCTYPE html>
<html>
<head>
    <title>Kasir - Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Container utama */
        .kasir-container {
            max-width: 1100px;
            margin: 32px auto;
            padding: 0 16px;
            transition: margin-left .3s;
        }

        @media (min-width: 1200px) {
            .kasir-container { margin-left: 280px; }
        }

        @media (max-width: 1199.98px) {
            .kasir-container { margin-left: 80px; }
        }

        @media (max-width: 991.98px) {
            .kasir-container {
                margin-left: 0;
                margin-top: 16px;
            }
        }

        /* Card */
        .card { border-radius: 12px; }

        /* Tabel */
        .table {
            font-size: 14px;
            margin-bottom: 0;
        }
        .table th, .table td {
            vertical-align: middle !important;
            padding: 10px 12px !important;
        }
        .table th {
            font-weight: 600;
            background: #f1f3f5;
        }

        /* Tombol */
        .btn-sm {
            font-size: 13px;
            padding: 4px 8px;
        }
        .btn {
            border-radius: 6px !important;
        }

        /* Badge */
        .badge { font-size: 12px; }

        /* Responsive table scroll */
        .table-responsive {
            overflow-x: auto;
        }

        /* Mobile adjust */
        @media (max-width: 768px) {
            .table th, .table td { font-size: 12px; padding: 6px !important; }
            .btn-sm { font-size: 11px; padding: 4px 6px; }
        }
    </style>
</head>

<body>

@include('components.sidebar')

<div class="kasir-container">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h4 class="mb-0 fw-bold">Kasir</h4>

        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-secondary d-flex align-items-center gap-2">
                <i class="fa fa-gear"></i> Pengaturan Cetak
            </button>

            <select class="form-select w-auto">
                <option>KLINIK UTAMA</option>
            </select>

            <select class="form-select w-auto">
                <option>(Semua Jenis Pembayar)</option>
            </select>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-body pb-3">

            <!-- Filter -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <input type="date" class="form-control w-auto" style="min-width:140px;" value="2025-11-22">

                <div class="d-flex gap-2 filter-btns">
                    <button class="btn btn-success d-flex align-items-center gap-2">
                        <i class="fa fa-circle"></i> Sedang Antri 
                        <span class="badge bg-light text-dark">2</span>
                    </button>

                    <button class="btn btn-success d-flex align-items-center gap-2">
                        <i class="fa fa-check"></i> Telah Dilayani 
                        <span class="badge bg-light text-dark">2</span>
                    </button>

                    <button class="btn btn-success d-flex align-items-center gap-2">
                        <i class="fa fa-list"></i> Semua 
                        <span class="badge bg-light text-dark">2</span>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>No Antrian</th>
                            <th>Nama Pasien</th>
                            <th>Poli</th>
                            <th>Jenis Bayar</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </thead>

                    <tbody>

                        <!-- Row 1 -->
                        <tr>
                            <td>001-1</td>
                            <td>
                                <strong>SINTA</strong><br>
                                <small class="text-muted">Alamat: PERUM RAHMAT BASUKI JEMBER</small><br>
                                <small class="text-muted">No RM: 35090100001</small><br>
                                <small class="text-muted">No KTP: 8237649238429672</small>
                            </td>

                            <td>Klinik Umum</td>
                            <td>UMUM / SWADAYA</td>

                            <td>
                                <span class="badge bg-danger mb-1">Belum Dilayani</span><br>
                                <span class="badge bg-secondary">SatuSehat</span>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-success btn-sm w-100 mb-1"><i class="fa fa-play"></i> Proses</button>
                                <button class="btn btn-warning btn-sm w-100 mb-1"><i class="fa fa-volume-up"></i> Panggil</button>
                                <button class="btn btn-warning btn-sm w-100 mb-1"><i class="fa fa-volume-up"></i> Panggil (Direct)</button>
                                <button class="btn btn-danger btn-sm w-100"><i class="fa fa-trash"></i> Hapus</button>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr>
                            <td>02-1</td>
                            <td>
                                <strong>TEGAR</strong><br>
                                <small class="text-muted">Alamat: JEMBER</small><br>
                                <small class="text-muted">No RM: 350901000487</small><br>
                                <small class="text-muted">No KTP: -</small>
                            </td>

                            <td>Klinik Gigi</td>
                            <td>UMUM / SWADAYA</td>

                            <td>
                                <span class="badge bg-danger mb-1">Belum Dilayani</span><br>
                                <span class="badge bg-secondary">SatuSehat</span>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-success btn-sm w-100 mb-1"><i class="fa fa-play"></i> Proses</button>
                                <button class="btn btn-warning btn-sm w-100 mb-1"><i class="fa fa-volume-up"></i> Panggil</button>
                                <button class="btn btn-warning btn-sm w-100 mb-1"><i class="fa fa-volume-up"></i> Panggil (Direct)</button>
                                <button class="btn btn-danger btn-sm w-100"><i class="fa fa-trash"></i> Hapus</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

</body>
</html>
