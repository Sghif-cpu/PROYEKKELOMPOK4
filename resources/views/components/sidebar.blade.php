<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar - Rumah Sakit</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f5f7fa;
}

/* ========== SIDEBAR ========== */
.sidebar {
    width: 260px;
    height: 100vh;
    background: linear-gradient(135deg, #43cea2, #185a9d);
    color: white;
    position: fixed;
    left: 0;
    top: 0;
    overflow-y: auto;
    transition: width 0.3s;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 10px rgba(0,0,0,0.07);
    z-index: 1100; /* Tambahkan z-index tinggi */
}

.sidebar.collapsed {
    width: 80px;
}

/* HEADER */
.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
    gap: 10px;
    position: relative;
    z-index: 1200; /* Pastikan header di atas konten lain */
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo {
    width: 45px;
    height: 45px;
    background: white;
    color: #185a9d;
    font-size: 20px;
    font-weight: bold;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar-title {
    font-size: 12px;
    line-height: 1.2;
    font-weight: bold;
}

.toggle-btn {
    background: rgba(0,0,0,0.08);
    border: none;
    color: white;
    font-size: 26px;
    cursor: pointer;
    margin-left: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000; /* lebih tinggi dari konten lain */
    position: relative;
    border-radius: 8px;
    padding: 6px 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.10);
}

.sidebar.collapsed .sidebar-title {
    display: none;
}

.sidebar.collapsed .toggle-btn {
    margin: 0 auto;
}

/* USER PROFILE */
.user-profile {
    display: flex;
    align-items: center;
    padding: 20px;
    gap: 12px;
    background: rgba(255,255,255,0.1);
    border-top: 1px solid rgba(255,255,255,0.15);
    border-bottom: 1px solid rgba(255,255,255,0.15);
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, #a7f3d0, #34d399);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #064e3b;
    font-weight: bold;
    font-size: 20px;
}

.user-info .user-name {
    font-size: 15px;
    font-weight: bold;
}

.user-info .user-role {
    font-size: 12px;
    opacity: 0.8;
}

.sidebar.collapsed .user-info {
    display: none;
}

.sidebar.collapsed .user-profile {
    justify-content: center;
}

/* MENU */
.menu {
    padding: 10px 0;
    display: flex;
    flex-direction: column;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    color: white;
    text-decoration: none;
    font-size: 15px;
    border-left: 4px solid transparent;
}

.menu-item i {
    width: 22px;
    text-align: center;
}

.menu-item:hover,
.menu-item.active {
    background: rgba(255,255,255,0.15);
    border-left: 4px solid white;
    border-radius: 6px;
}

/* COLLAPSE MENU */
.sidebar.collapsed .menu-item {
    justify-content: center;
    padding: 15px 0;
}

.sidebar.collapsed .menu-item span {
    display: none;
}

.sidebar.collapsed .menu-item i {
    font-size: 20px;
}

/* DROPDOWN */
.has-dropdown {
    position: relative;
}

.dropdown-icon {
    margin-left: auto;
    transition: 0.25s;
}

.dropdown-open .dropdown-icon {
    transform: rotate(180deg);
}

/* SUBMENU */
.submenu {
    display: none;
    background: rgba(255,255,255,0.12);
    margin: 5px 0 5px 20px;
    padding-left: 10px;
    border-left: 3px solid white;
}

.submenu-item {
    padding: 8px 5px;
    color: #eafff6;
    font-size: 14px;
    display: flex;
    align-items: center;
}

/* Hide submenu when collapsed */
.sidebar.collapsed .submenu {
    display: none !important;
}

.sidebar.collapsed .dropdown-icon {
    display: none;
}

/* MOBILE */
@media (max-width: 768px) {
    .sidebar {
        width: 80px;
    }
}
</style>
</head>

<body>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <div class="logo">V-K</div>
            <div class="sidebar-title">
                Rekam Medis<br>
                Elektronik<br>
                OPUS
            </div>
        </div>
        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="user-profile">
        <div class="user-avatar">A</div>
        <div class="user-info">
            <div class="user-name">Administrator</div>
            <div class="user-role">Super Administrator</div>
        </div>
    </div>

    <nav class="menu">
        <a href="{{ route('dashboard') }}" class="menu-item active">
            <i class="fas fa-home"></i> <span>Beranda</span>
        </a>
        <a href="#" class="menu-item has-dropdown" onclick="toggleDropdown(event, 'pendaftaranDropdown')">
            <i class="fas fa-user-plus"></i><span>Pendaftaran</span>
            <i class="fas fa-chevron-down dropdown-icon"></i>
        </a>
        <div class="submenu" id="pendaftaranDropdown">
            <a href="#" class="submenu-item">Pasien Lama</a>
            <a href="#" class="submenu-item">Pasien Baru</a>
            <a href="#" class="submenu-item">List Pendaftaran</a>
            <a href="#" class="submenu-item">Edit Pendaftaran</a>
            <a href="#" class="submenu-item">Antrian Online</a>
        </div>

        <a href="#" class="menu-item"><i class="fas fa-users"></i> <span>Pasien</span></a>
        <a href="#" class="menu-item"><i class="fas fa-clinic-medical"></i> <span>Poliklinik</span></a>
        <a href="#" class="menu-item"><i class="fas fa-pills"></i> <span>Farmasi</span></a>
        <a href="{{ route('kasir.index') }}" class="menu-item"><i class="fas fa-money-bill"></i> <span>Kasir</span></a>
        <a href="#" class="menu-item"><i class="fas fa-database"></i> <span>Master Data</span></a>
        <a href="#" class="menu-item"><i class="fas fa-file-alt"></i> <span>Laporan</span></a>
       <a href="{{ route('laboratorium.index') }}" class="menu-item">
            <i class="fas fa-flask"></i> <span>Laboratorium</span>
        </a>
    </nav>
</aside>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('collapsed');
}

function toggleDropdown(event, id) {
    event.preventDefault();
    const submenu = document.getElementById(id);
    const parent = event.currentTarget;

    submenu.style.display =
        submenu.style.display === "block" ? "none" : "block";

    parent.classList.toggle("dropdown-open");
}
</script>

</body>
</html>
