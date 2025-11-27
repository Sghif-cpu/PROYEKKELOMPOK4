<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rekam Medis Elektronik</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        /* Tata letak agar isi dashboard tidak tertutup sidebar */
        .main-content {
            margin-left: 260px;
            padding: 24px;
            transition: margin-left 0.3s;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .sidebar.collapsed ~ .main-content {
            margin-left: 70px;
        }
        @media (max-width: 900px) {
            .main-content {
                margin-left: 70px !important;
            }
        }
        .chart-grid {
            display: flex;
            gap: 24px;
            margin-bottom: 24px;
        }
        .chart-card {
            flex: 1;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 18px;
            min-width: 0;
            min-height: 320px;
            display: flex;
            flex-direction: column;
            border: 1px solid #e5e7eb;
        }
        .chart-placeholder {
            flex: 1;
            min-height: 220px;
        }
        .table-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            margin-bottom: 24px;
            padding: 18px;
            border: 1px solid #e5e7eb;
        }
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        .table-controls {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .table th, .table td {
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            text-align: left;
            font-size: 14px;
        }
        .no-data {
            text-align: center;
            color: #888;
            padding: 20px !important;
        }
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
        }
        .action-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background: #185a9d;
            color: #fff;
        }
        .btn-secondary {
            background: #43cea2;
            color: #fff;
        }
        .btn-warning {
            background: #fbbf24;
            color: #222;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            background: #fff;
            padding: 16px 24px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }
        .top-bar-left h1 {
            font-size: 1.8rem;
            margin: 0;
            color: #2d3748;
        }
        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .icon-btn {
            background: none;
            border: none;
            color: #185a9d;
            font-size: 20px;
            position: relative;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.3s;
        }
        .icon-btn:hover {
            background-color: #f7fafc;
        }
        .icon-btn .badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background: #f87171;
            color: #fff;
            border-radius: 50%;
            font-size: 11px;
            padding: 2px 6px;
        }
        .logout-btn {
            background: #f87171;
            border: none;
            color: #fff;
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            margin-left: 10px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background: #ef4444;
            color: #fff;
        }
        .date-filter {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        .search-box {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 4px 8px;
        }
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border-left: 4px solid #185a9d;
        }
        .stat-card.success {
            border-left-color: #43cea2;
        }
        .stat-card.warning {
            border-left-color: #fbbf24;
        }
        .stat-card.info {
            border-left-color: #60a5fa;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #2d3748;
            margin: 8px 0;
        }
        .stat-label {
            color: #718096;
            font-size: 0.9rem;
        }
        .welcome-text {
            color: #718096;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="top-bar-left">
                    <h1>Beranda</h1>
                    <p class="welcome-text">Selamat datang, {{ Auth::user()->name }}!</p>
                </div>
                <div class="top-bar-right">
                    <button class="icon-btn">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                    <button class="icon-btn">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                    <button class="icon-btn">
                        <i class="fas fa-qrcode"></i>
                    </button>
                    <button class="icon-btn">
                        <i class="fas fa-comments"></i>
                    </button>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Pasien</div>
                    <div class="stat-number">{{ $stats['total_pasien'] ?? 0 }}</div>
                    <small>Terdaftar dalam sistem</small>
                </div>
                <div class="stat-card success">
                    <div class="stat-label">Pasien Hari Ini</div>
                    <div class="stat-number">{{ $stats['pasien_hari_ini'] ?? 0 }}</div>
                    <small>Registrasi hari ini</small>
                </div>
                <div class="stat-card warning">
                    <div class="stat-label">Total Pengguna</div>
                    <div class="stat-number">{{ $stats['total_users'] ?? 0 }}</div>
                    <small>User aktif</small>
                </div>
                <div class="stat-card info">
                    <div class="stat-label">Kunjungan Bulan Ini</div>
                    <div class="stat-number">{{ $stats['kunjungan_bulan_ini'] ?? 0 }}</div>
                    <small>Total kunjungan</small>
                </div>
            </div>

            <!-- Charts -->
            <div class="chart-grid">
                <div class="chart-card">
                    <h3>Grafik Kunjungan</h3>
                    <div class="chart-placeholder">
                        <canvas id="chartKunjungan"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <h3>Grafik Pendapatan</h3>
                    <div class="chart-placeholder">
                        <canvas id="chartPendapatan"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-grid">
                <div class="chart-card">
                    <h3>Grafik Pasien Berdasarkan Jenis Pembayaran</h3>
                    <div class="chart-placeholder">
                        <canvas id="chartPasien"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <h3>Grafik Kunjungan Jenis Pembayaran</h3>
                    <div class="chart-placeholder">
                        <canvas id="chartPembayaran"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Patients Table -->
            <div class="table-card">
                <div class="table-header">
                    <h3>Pasien Terbaru</h3>
                    <div class="table-controls">
                        <select class="form-select form-select-sm">
                            <option>10 entries</option>
                        </select>
                        <input type="text" class="form-control form-control-sm search-box" placeholder="Search...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>Jenis Bayar</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_pasien as $index => $pasien)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pasien->no_rm }}</td>
                                <td>{{ $pasien->nama }}</td>
                                <td>{{ $pasien->jenis_kelamin }}</td>
                                <td>{{ $pasien->usia }} tahun</td>
                                <td>{{ $pasien->jenis_bayar }}</td>
                                <td>{{ $pasien->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('pasien.show', $pasien->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="no-data">Belum ada data pasien</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <div>Showing {{ $recent_pasien->count() }} of {{ $stats['total_pasien'] ?? 0 }} entries</div>
                    <div>
                        <a href="{{ route('pasien.index') }}" class="btn btn-sm btn-primary">Lihat Semua Pasien</a>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('pasien.create') }}" class="action-btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Pasien Baru
                </a>
                <a href="{{ route('pasien.index') }}" class="action-btn btn-secondary">
                    <i class="fas fa-list"></i>
                    Daftar Pasien
                </a>
                <a href="{{ route('laboratorium.index') }}" class="action-btn btn-warning">
                    <i class="fas fa-flask"></i>
                    Laboratorium
                </a>
                <a href="{{ route('kasir.index') }}" class="action-btn btn-primary">
                    <i class="fas fa-cash-register"></i>
                    Kasir
                </a>
                <button class="action-btn btn-secondary">
                    <i class="fas fa-phone"></i>
                    Log Panggilan
                </button>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        }

        // Close sidebar on mobile when clicking menu item
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    document.getElementById('sidebar').classList.add('collapsed');
                }
            });
        });

        // Chart.js Configuration
        const chartColors = {
            orange: '#fb923c',
            green: '#34d399',
            blue: '#60a5fa',
            cyan: '#22d3ee',
            pink: '#f472b6',
            purple: '#a78bfa',
            red: '#f87171',
            yellow: '#fbbf24'
        };

        // Chart 1: Grafik Kunjungan (Bar Chart)
        const ctxKunjungan = document.getElementById('chartKunjungan').getContext('2d');
        const chartKunjungan = new Chart(ctxKunjungan, {
            type: 'bar',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                datasets: [
                    {
                        label: 'Kunjungan Sakit',
                        data: [12, 15, 8, 10, 13, 5],
                        backgroundColor: chartColors.orange,
                        borderRadius: 6
                    },
                    {
                        label: 'Kunjungan Sehat',
                        data: [3, 4, 2, 5, 3, 1],
                        backgroundColor: chartColors.green,
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5]
                        }
                    }
                }
            }
        });

        // Chart 2: Grafik Pendapatan (Line Chart)
        const ctxPendapatan = document.getElementById('chartPendapatan').getContext('2d');
        const chartPendapatan = new Chart(ctxPendapatan, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [
                    {
                        label: 'Pendapatan (Juta)',
                        data: [15, 18, 22, 20],
                        borderColor: chartColors.blue,
                        backgroundColor: chartColors.blue + '33',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5]
                        }
                    }
                }
            }
        });

        // Chart 3: Grafik Pasien Berdasarkan Jenis Pembayaran (Bar Chart)
        const ctxPasien = document.getElementById('chartPasien').getContext('2d');
        const chartPasien = new Chart(ctxPasien, {
            type: 'bar',
            data: {
                labels: ['Jenis Pembayaran'],
                datasets: [
                    {
                        label: 'UMUM / SWASDAYA',
                        data: [{{ $stats['total_pasien'] ?? 0 }}],
                        backgroundColor: chartColors.blue,
                        borderRadius: 6
                    },
                    {
                        label: 'BPJS PBI',
                        data: [{{ $stats['bpjs_pbi'] ?? 0 }}],
                        backgroundColor: chartColors.red,
                        borderRadius: 6
                    },
                    {
                        label: 'BPJS NON PBI',
                        data: [{{ $stats['bpjs_non_pbi'] ?? 0 }}],
                        backgroundColor: chartColors.yellow,
                        borderRadius: 6
                    },
                    {
                        label: 'JAMKESDA',
                        data: [{{ $stats['jamkesda'] ?? 0 }}],
                        backgroundColor: chartColors.purple,
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 10,
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5]
                        }
                    }
                }
            }
        });

        // Chart 4: Grafik Kunjungan Jenis Pembayaran (Line Chart)
        const ctxPembayaran = document.getElementById('chartPembayaran').getContext('2d');
        const chartPembayaran = new Chart(ctxPembayaran, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [
                    {
                        label: 'UMUM / SWASDAYA',
                        data: [8, 10, 12, 9],
                        borderColor: chartColors.blue,
                        backgroundColor: chartColors.blue + '33',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'BPJS',
                        data: [15, 18, 20, 17],
                        borderColor: chartColors.red,
                        backgroundColor: chartColors.red + '33',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'JAMKESDA',
                        data: [5, 7, 6, 8],
                        borderColor: chartColors.green,
                        backgroundColor: chartColors.green + '33',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5]
                        }
                    }
                }
            }
        });
    </script>
    <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const logoutForm = document.querySelector('form[action="{{ route('logout') }}"]');
    const logoutButton = logoutForm.querySelector('button[type="submit"]');

    logoutButton.addEventListener('click', function (e) {
        e.preventDefault(); // cegah submit langsung

        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Apakah Anda yakin ingin keluar dari aplikasi?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                logoutForm.submit();
            }
        });
    });
});
</script>

</body>
</html>