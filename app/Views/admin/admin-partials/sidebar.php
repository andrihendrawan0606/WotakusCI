<style>
    /* Reset Sidebar SB Admin 2 */
.sidebar-modern {
    position: fixed !important;
    top: 0;
    left: 0;
    bottom: 0;
    z-index: 1050; /* Pastikan di atas elemen lain */
    height: 100vh;
    width: 14rem !important; /* Standar lebar sidebar SB Admin 2 */
    overflow-y: auto; /* Supaya menu bisa di-scroll sendiri jika terlalu panjang */
    background-color: #11111d !important;
    transition: all 0.3s;
}

/* Mengatur Scrollbar didalam Sidebar agar tipis dan modern */
.sidebar-modern::-webkit-scrollbar {
    width: 3px;
}
.sidebar-modern::-webkit-scrollbar-thumb {
    background: rgba(172, 17, 233, 0.3);
    border-radius: 10px;
}


/* PENTING: Memberi ruang pada konten utama agar tidak tertutup sidebar */
#content-wrapper {
    margin-left: 14rem; /* Harus sama dengan lebar sidebar */
    width: calc(100% - 14rem);
    transition: all 0.3s;
}

/* Logika saat sidebar di-minimize (toggled) */
.sidebar.toggled {
    width: 6.5rem !important;
}

.sidebar.toggled + #content-wrapper {
    margin-left: 6.5rem;
    width: calc(100% - 6.5rem);
}

.sidebar-modern, #content-wrapper {
    transition: all 0.3s ease-in-out !important;
}

/* =========================================
   LOGIKA SIDEBAR DESKTOP (COLLAPSED)
   ========================================= */
@media (min-width: 768px) {
    /* 1. Ukuran sidebar mengecil jadi 5rem */
    body.sidebar-collapsed .sidebar-modern {
        width: 5rem !important;
    }

    /* 2. Konten utama melebar menutupi ruang kosong */
    body.sidebar-collapsed #content-wrapper {
        margin-left: 5rem !important;
        width: calc(100% - 5rem) !important;
    }

    /* 3. Sembunyikan Teks, Label, dan Teks Logo */
    body.sidebar-collapsed .sidebar-modern .nav-item .nav-link span,
    body.sidebar-collapsed .sidebar-modern .sidebar-heading,
    body.sidebar-collapsed .sidebar-modern .sidebar-brand-text {
        display: none !important;
    }

    /* 4. Pusatkan posisi Icon agar rapi */
    body.sidebar-collapsed .sidebar-modern .nav-item .nav-link {
        justify-content: center;
        padding: 15px 0 !important;
    }

    body.sidebar-collapsed .sidebar-modern .nav-item .nav-link i {
        margin-right: 0 !important;
        font-size: 1.3rem !important;
    }

    body.sidebar-collapsed .sidebar-modern .sidebar-brand {
        padding: 15px 0;
    }
}

/* Perbaikan untuk tampilan mobile */
@media (max-width: 768px) {
    .sidebar-modern {
        position: fixed !important;
        height: 100vh !important;
        width: 14rem !important; /* Tetap pertahankan lebar aslinya */
        left: -14rem; /* Sembunyikan sidebar di luar layar sebelah kiri */
        transition: left 0.3s ease-in-out; /* Animasi transisi yang smooth */
        z-index: 1050;
    }
    #content-wrapper {
        margin-left: 0 !important;
        width: 100% !important;
    }
    .sidebar-modern.show {
        left: 0; /* Tarik sidebar ke dalam layar */
    }
}

.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040; /* Di bawah sidebar (1050), di atas konten */
    display: none;
    transition: opacity 0.3s;
}
.sidebar-overlay.show {
    display: block;
}

.sidebar-brand-wrapper {
    padding: 20px 0;
    margin-bottom: 10px;
}

.sidebar-modern .sidebar-brand {
    height: auto !important;
    text-transform: none !important;
}

.sidebar-brand-text {
    font-size: 1.1rem !important;
    font-weight: 800 !important;
    letter-spacing: 1px;
    color: #fff !important;
}

.sidebar-brand-text span {
    color: #ac11e9; /* Aksen Ungu */
    font-size: 0.7rem;
    display: block;
    margin-top: -5px;
    opacity: 0.8;
}

/* Heading / Label Group */
.sidebar-modern .sidebar-heading {
    font-size: 0.65rem !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 1.5px !important;
    color: #4e4e6a !important;
    margin-top: 20px;
    margin-bottom: 10px;
    margin-left: 9px;
}

/* Nav Item Styling */
.sidebar-modern .nav-item {
    margin: 0 12px 5px 12px;
}

.sidebar-modern .nav-item .nav-link {
    padding: 12px 15px !important;
    border-radius: 12px;
    display: flex;
    align-items: center;
    transition: all 0.2s;
    color: #a0a0a0 !important;
}

.sidebar-modern .nav-item .nav-link i {
    font-size: 1.1rem !important;
    margin-right: 12px !important;
    width: 20px;
    text-align: center;
}

/* Hover State */
.sidebar-modern .nav-item .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.03);
    color: #fff !important;
}

/* Active State - Yang membuat modern */
.sidebar-modern .nav-item.active .nav-link {
    background-color: rgba(172, 17, 233, 0.1) !important; /* Soft Purple BG */
    color: #ac11e9 !important;
    font-weight: 700;
}

.sidebar-modern .nav-item.active .nav-link i {
    color: #ac11e9 !important;
    filter: drop-shadow(0 0 5px rgba(172, 17, 233, 0.5));
}

/* Indikator Garis di samping */
.sidebar-modern .nav-item.active::before {
    content: "";
    position: absolute;
    left: -12px;
    top: 10%;
    height: 80%;
    width: 4px;
    background: #ac11e9;
    border-radius: 0 5px 5px 0;
    box-shadow: 2px 0 10px rgba(172, 17, 233, 0.6);
}

/* Toggler Button */
#sidebarToggle {
    background-color: rgba(255,255,255,0.05) !important;
}
#sidebarToggle:hover {
    background-color: rgba(255,255,255,0.1) !important;
}
</style>
<div id="wrapper">
<ul class="navbar-nav sidebar-modern accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <div class="sidebar-brand-wrapper">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= url_to('dashboard') ?>">
            <div class="sidebar-brand-icon">
                <img src="<?= base_url('img/Wotakus.png') ?>" width="40" alt=""> <!-- Gunakan logo kecil jika ada -->
            </div>
            <div class="sidebar-brand-text mx-3">WOTAKUS <span>ADMIN</span></div>
        </a>
    </div>

    <!-- Divider -->
    <div class="sidebar-heading">Menu Utama</div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= (current_url() == url_to('dashboard')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= url_to('dashboard') ?>">
            <i class="fas fa-fw fa-th-large"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <div class="sidebar-heading">Konten Anime</div>

    <!-- Nav Item - Genre -->
    <li class="nav-item <?= (current_url() == url_to('genreList')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= url_to('genreList') ?>">
            <i class="fas fa-fw fa-tags"></i>
            <span>Manajemen Genre</span>
        </a>
    </li>

    <!-- Nav Item - Jadwal Rilis -->
    <li class="nav-item <?= (current_url() == url_to('JadwalRilis')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= url_to('JadwalRilis') ?>">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Jadwal Rilis</span>
        </a>
    </li>

    <!-- Nav Item - News -->
    <li class="nav-item <?= (current_url() == url_to('NewsList')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= url_to('NewsList') ?>">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Berita / News</span>
        </a>
    </li>

        <!-- Nav Item - News -->
    <li class="nav-item <?= (current_url() == url_to('Studios')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= url_to('Studios') ?>">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Manage Studios</span>
        </a>
    </li>

    <!-- Divider -->
    <div class="sidebar-heading">Sistem</div>

    <!-- Nav Item - Logs -->
    <li class="nav-item <?= (current_url() == url_to('Logs')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= url_to('Logs') ?>">
            <i class="fas fa-fw fa-history"></i>
            <span>Activity Logs</span>
        </a>
    </li>

    <!-- Nav Item - Users -->
    <li class="nav-item <?= (current_url() == url_to('manageUsers')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= url_to('manageUsers') ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Pengguna</span>
        </a>
    </li>

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline mt-4">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- 1. DEKLARASI ELEMEN ---
        const sidebar = document.querySelector('.sidebar-modern');
        const overlay = document.getElementById('sidebarOverlay');
        
        // Tombol Mobile (biasanya bawaan template)
        const btnMobile = document.getElementById('sidebarToggleTop') || document.getElementById('hamburgerBtn'); 
        
        // Tombol Desktop (yang baru kita buat di Langkah 1)
        const btnDesktop = document.getElementById('sidebarToggleDesktop'); 


        // --- 2. LOGIKA UNTUK MOBILE (Buka/Tutup Penuh) ---
        if(btnMobile && sidebar) {
            btnMobile.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation(); 
                sidebar.classList.toggle('show');
                if(overlay) overlay.classList.toggle('show');
            };
        }

        // --- 3. LOGIKA UNTUK DESKTOP (Mengecil/Membesar) ---
        if(btnDesktop) {
            btnDesktop.onclick = function(e) {
                e.preventDefault();
                // Kita tambahkan class 'sidebar-collapsed' ke tag <body>
                document.body.classList.toggle('sidebar-collapsed');
            };
        }

        // --- 4. TUTUP SIDEBAR MOBILE JIKA BACKGROUND GELAP DIKLIK ---
        if(overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
    });
</script>