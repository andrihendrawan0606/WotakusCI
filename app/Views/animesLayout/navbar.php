<script>
    const BASE_URL = "<?= base_url() ?>";
</script>
<style>
/* Badge Khusus Admin */
.level-tag.admin-badge {
    background: linear-gradient(45deg, #ac11e9, #ff00ea);
    box-shadow: 0 0 10px rgba(172, 17, 233, 0.5);
    font-weight: 900;
}

/* Link Admin di dalam Dropdown */
.admin-link {
    color: #ac11e9 !important;
    font-weight: 700 !important;
    background: rgba(172, 17, 233, 0.05);
}

.admin-link:hover {
    background: rgba(172, 17, 233, 0.1) !important;
}

.admin-link i {
    color: #ac11e9 !important;
}

/* Garis pembatas dropdown */
.dropdown-divider {
    height: 1px;
    background: rgba(255, 255, 255, 0.05);
    margin: 5px 0;
}
.btn-login-modern {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(172, 17, 233, 0.4); /* Border Ungu Neon Transparan */
    color: #fff !important;
    padding: 8px 25px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none !important;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    backdrop-filter: blur(5px);
}

.btn-login-modern i {
    font-size: 14px;
    color: #ac11e9; /* Ikon Ungu */
    transition: 0.3s;
}

/* Hover Effect */
.btn-login-modern:hover {
    background: #ac11e9;
    border-color: #ac11e9;
    box-shadow: 0 0 20px rgba(172, 17, 233, 0.4);
    transform: translateY(-2px);
}

.btn-login-modern:hover i {
    color: #fff;
}

/* Responsif Mobile: Di layar kecil tombol bisa lebih ringkas */
@media (max-width: 768px) {
    .btn-login-modern span {
        display: none; /* Sembunyikan teks, sisakan ikon saja di HP */
    }
    .btn-login-modern {
        padding: 10px;
    }
}
.profile-pill {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #fff;
    padding: 5px 15px 5px 5px; /* Padding kiri dikurangi agar foto mepet kiri */
    border-radius: 50px;
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: 0.3s;
}

/* Ukuran Foto Profil di Navbar */
.nav-user-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(172, 17, 233, 0.5); /* Border ungu neon tipis */
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
}

/* Wadah Teks Nama & Level */
.user-meta-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    line-height: 1.1;
    margin: 0 12px;
}

.user-name {
    font-size: 13px;
    font-weight: 700;
    max-width: 120px; /* Batasi panjang nama agar tidak merusak navbar */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.level-tag {
    font-size: 8px !important;
    padding: 1px 6px !important;
    margin-top: 2px;
    border-radius: 3px !important;
}

/* Efek Hover Pill */
.profile-pill:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: #ac11e9;
}
/* --- BASE & DESKTOP STYLING --- */
.main-header {
    background: #11111d;
    position: sticky;
    top: 0;
    z-index: 1000;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 25px;
    height: 75px;
    max-width: 1440px;
    margin: 0 auto;
}

.logo-section img {
    height: 45px;
    width: auto;
}

.nav-section {
    flex: 1;
    display: flex;
    justify-content: center;
}

.nav-menu {
    display: flex;
    gap: 20px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-menu a {
    color: #a0a0a0;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: 0.3s;
}

.nav-menu li.active a {
    color: #ac11e9 !important;
}

.action-section {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* Search Bar Desktop */
.search-wrapper {
    position: relative;
    z-index: 1001;
}

.search-bar {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 50px;
    padding: 5px 15px;
    width: 250px;
}

.search-bar input {
    background: transparent;
    border: none;
    color: white;
    padding: 5px 10px;
    width: 100%;
    outline: none;
}

.search-results-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #1a1a2e;
    border-radius: 12px;
    margin-top: 10px;
    z-index: 9999; /* Sangat Penting */
    max-height: 400px;
    overflow-y: auto;
}

/* --- MOBILE STYLING (DIBAWAH 768px) --- */
@media (max-width: 768px) {
    .nav-section { display: none !important; } /* Sembunyikan menu tengah di HP */

    .header-container { padding: 0 15px; height: 65px; }

    /* Paksa tombol mobile tampil */
    .mobile-action-btn {
        display: flex !important;
        background: rgba(255,255,255,0.08);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        
    }

    /* Overlay Search Mobile */
    .search-wrapper {
        display: none; /* Sembunyi default di HP */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 70px;
        background: #11111d;
        padding: 10px 15px;
        z-index: 10000;
        align-items: center;
    }

    .search-wrapper.active {
        display: flex !important;
    }

    .search-bar {
        width: 100%;
        background: #1a1a2e;
        border-color: #ac11e9;
    }

    /* Profil & Notif di HP */
    .user-meta-info { display: none; }
    .profile-pill { padding: 0; border: 2px solid #ac11e9; }
    .nav-user-avatar { width: 32px; height: 32px; border: none; }

    /* Menu Dropdown Hamburger */
    .mobile-nav-dropdown {
        /* Gunakan flex agar isi tertumpuk rapi */
        display: flex !important; 
        flex-direction: column;
        
        /* Posisi & Ukuran */
        position: absolute;
        top: 75px; 
        left: 15px;
        right: 15px; /* Dibuat sedikit menggantung agar terlihat seperti card */
        width: calc(100% - 30px);
        
        /* Styling Visual (Modern Look) */
        background: rgba(22, 22, 37, 0.95); /* Semi transparan */
        backdrop-filter: blur(10px); /* Efek blur kaca */
        border: 1px solid rgba(172, 17, 233, 0.2);
        border-radius: 18px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
        z-index: 9999;
        padding: 10px 0;

        /* LOGIKA ANIMASI (Kunci Kelancaran) */
        opacity: 0;
        visibility: hidden;
        transform: translateY(-20px) scale(0.95); /* Muncul dari atas & sedikit kecil */
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); /* Animasi kenyal */
        pointer-events: none; /* Cegah klik saat sembunyi */
    }
    .mobile-nav-dropdown.active { display: flex; }
    .mobile-nav-dropdown a {
        padding: 16px 25px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: 0.3s;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    }
        /* Munculkan Secara Paksa jika ada class .is-open */
    .mobile-nav-dropdown.is-open {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1); /* Kembali ke posisi normal */
        pointer-events: auto;
    }
        /* Efek saat link di klik/hover */
        .mobile-nav-dropdown a:active, 
    .mobile-nav-dropdown a:hover {
        background: rgba(172, 17, 233, 0.1);
        color: #ac11e9;
        padding-left: 35px; /* Sedikit geser ke kanan saat ditekan */
    }

    .mobile-nav-dropdown a i {
        color: #ac11e9;
        font-size: 18px;
        width: 25px;
        text-align: center;
        filter: drop-shadow(0 0 5px rgba(172, 17, 233, 0.4));
    }

    /* Menghilangkan border di item terakhir */
    .mobile-nav-dropdown a:last-child {
        border-bottom: none;
    }
}

/* Helper Class */
.d-md-none { display: block; }
@media (min-width: 769px) {
    .d-md-none { display: none !important; }
}
</style>
<header class="main-header">
    <div class="header-container">
        
        <!-- 1. LOGO -->
        <div class="logo-section">
            <a href="<?= url_to('animes-home') ?>">
                <img src="<?= base_url('img/Wotakus.png') ?>" alt="Wotakus" />
            </a>
        </div>

        <!-- 2. MENU NAVIGASI (DESKTOP) -->
        <nav class="nav-section d-none d-md-block">
            <ul class="nav-menu">
                <li class="<?= (current_url() == url_to('recent-anime')) ? 'active' : '' ?>"><a href="<?= url_to('recent-anime'); ?>">History</a></li>
                <li class="<?= (current_url() == url_to('animes-home')) ? 'active' : '' ?>"><a href="<?= url_to('animes-home'); ?>">Animes</a></li>
                <li class="<?= (current_url() == url_to('jadwal-rilis')) ? 'active' : '' ?>"><a href="<?= url_to('jadwal-rilis'); ?>">Jadwal</a></li>
                <li class="<?= (current_url() == url_to('genres')) ? 'active' : '' ?>"><a href="<?= url_to('genres'); ?>">Explore</a></li>
                <li class="<?= (current_url() == url_to('news')) ? 'active' : '' ?>"><a href="<?= url_to('news'); ?>">News</a></li>
            </ul>
        </nav>

        <!-- 3. ACTION SECTION -->
        <div class="action-section">
            
            <!-- Ganti Tombol Cari Mobile (Baris 33) -->
            <button class="mobile-action-btn d-md-none" onclick="toggleSearchMobile(event)">
                <i class="fas fa-search"></i>
            </button>

            <!-- Search Bar -->
            <div class="search-wrapper" id="searchWrapper">
                <div class="search-bar">
                    <i class="fas fa-search search-icon d-none d-md-block text-muted mr-2"></i>
                    <input type="text" id="mysearch" placeholder="Cari anime..." autocomplete="off">
                    <!-- Ganti Tombol Close Search (Baris 40) -->
                    <button class="d-md-none bg-transparent border-0 text-danger font-weight-bold px-2" onclick="toggleSearchMobile(event)">×</button>
                </div>
                <div id="search-results" class="search-results-dropdown"></div>
            </div>

            <?php if (session()->get('isLoggedIn')): ?>
                <!-- Notifikasi -->
                <div class="notification-wrapper">
                    <div class="notification-bell" onclick="toggleNotifications(event)">
                        <i class="fas fa-bell"></i>
                        <span class="badge-count">6</span>
                    </div>
                    
                    <!-- Dropdown Notifikasi (Tersembunyi secara default) -->
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notif-header">Notifikasi Terbaru</div>
                        <div class="notif-list">
                            <div class="notif-item">
                                <div class="notif-icon-circle">
                                    <i class="fas fa-play"></i>
                                </div>
                                <div class="notif-content">
                                    <p>Episode baru <b>Demon Slayer</b> telah rilis!</p>
                                    <small>1 jam yang lalu</small>
                                </div>
                            </div>
                            <!-- Bisa ditambah loop data di sini -->
                        </div>
                        <div class="notif-footer">
                            <a href="#">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <!-- Profile -->
                <div class="user-profile">
                    <button class="profile-pill" onclick="toggleProfileDropdown(event)">
                        <?php 
                            $profileImg = session()->get('ProfileImg'); 
                            $imgSrc = (filter_var($profileImg, FILTER_VALIDATE_URL)) ? $profileImg : base_url('assets/images/' . $profileImg);
                        ?>
                        <img src="<?= $imgSrc ?>" alt="Avatar" class="nav-user-avatar">
                        <div class="user-meta-info d-none d-md-flex">
                            <span class="user-name"><?= session()->get('nama'); ?></span>
                            <span class="level-tag <?= (session()->get('role') === 'admin') ? 'admin-badge' : '' ?>">
                                <?= (session()->get('role') === 'admin') ? 'ADMIN' : (session()->get('level') ?? 'BASIC') ?>
                            </span>
                        </div>
                        <i class="fas fa-chevron-down d-none d-md-block ml-1" style="font-size: 10px;"></i>
                    </button>
    
    <div class="profile-dropdown-menu">
        <?php if (session()->get('role') === 'admin') : ?>
            <a href="<?= url_to('dashboard') ?>" class="admin-link">
                <i class="fas fa-user-shield"></i> Admin Panel
            </a>
            <div class="dropdown-divider"></div>
        <?php endif; ?>

        <a href="<?= url_to('profileUser') ?>"><i class="fas fa-user-circle"></i> Akun Saya</a>
        <a href="<?= url_to('myFavorites') ?>"><i class="fas fa-heart"></i> Favorit</a>
        <a href="<?= url_to('logout'); ?>" class="logout"><i class="logoutUser fas fa-sign-out-alt"></i> Keluar</a>
    </div>
    </div>
            <?php else: ?>
                <a href="<?= url_to('login') ?>" class="btn-login-modern">
                    <i class="fas fa-sign-in-alt"></i> <span>Masuk</span>
                </a>
            <?php endif; ?>
            <!-- Hamburger (Mobile Only) -->
                <!-- Ganti Tombol Hamburger Mobile (Baris 108) -->
                <button class="mobile-action-btn hamburger-btn d-md-none" style="color: #ac11e9;" onclick="toggleMobileMenu(event)">
                    <i class="fas fa-bars"></i>
                </button>
        </div>
    </div>

    <!-- Mobile Navigation Dropdown -->
    <div class="mobile-nav-dropdown d-md-none" id="mobileNav">
        <a href="<?= url_to('recent-anime'); ?>"><i class="fas fa-history"></i> History</a>
        <a href="<?= url_to('animes-home'); ?>"><i class="fas fa-play"></i> Animes</a>
        <a href="<?= url_to('jadwal-rilis'); ?>"><i class="fas fa-calendar-alt"></i> Jadwal</a>
        <a href="<?= url_to('genres'); ?>"><i class="fas fa-compass"></i> Explore</a>
        <a href="<?= url_to('news'); ?>"><i class="fas fa-newspaper"></i> News</a>
    </div>
</header>

<script>
// Penanganan Dasar
const getEl = (id) => document.getElementById(id);

// Kita daftarkan fungsi ke objek 'window' agar pasti terbaca oleh HTML onclick
window.toggleSearchMobile = function(e) {
    if (e) e.stopPropagation();
    const searchWrap = getEl('searchWrapper');
    if (searchWrap) {
        searchWrap.classList.toggle('active');
        if (searchWrap.classList.contains('active')) {
            setTimeout(() => {
                const input = getEl('mysearch');
                if (input) input.focus();
            }, 200);
        }
    }
};

window.toggleMobileMenu = function(e) {
    if (e) e.stopPropagation(); // Shield: Stop error dari script baris 7
    
    console.log("Hamburger Toggled"); 
    const mobileNav = document.getElementById('mobileNav');
    
    if (mobileNav) {
        // Ganti 'active' dengan 'is-open' agar tidak bentrok CSS
        mobileNav.classList.toggle('is-open');
        
        // Tutup notif jika terbuka
        const notif = document.getElementById('notificationDropdown');
        if (notif) notif.style.display = 'none';
    }
};

window.toggleNotifications = function(e) {
    if (e) e.stopPropagation();
    const dropdown = getEl('notificationDropdown');
    if (dropdown) {
        const isVisible = dropdown.style.display === 'block';
        dropdown.style.display = isVisible ? 'none' : 'block';
        if (getEl('mobileNav')) getEl('mobileNav').classList.remove('active');
    }
};

window.toggleProfileDropdown = function(e) {
    if (e) e.stopPropagation();
    const dropdown = document.querySelector('.profile-dropdown-menu');
    if (dropdown) {
        const isVisible = dropdown.style.display === 'block';
        dropdown.style.display = isVisible ? 'none' : 'block';
    }
};

// --- 2. LOGIKA SEARCH ANIME (Gabungan Script Anda) ---

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = getEl('mysearch');
    const resultsDropdown = getEl('search-results');
    const clearBtn = getEl('clear-btn');

    // Cek dulu apakah elemen ada (mencegah error null)
    if (searchInput && resultsDropdown) {
        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim();

            if (clearBtn) clearBtn.style.display = query.length > 0 ? 'block' : 'none';

            if (query.length > 2) {
                resultsDropdown.style.display = 'block';
                resultsDropdown.innerHTML = '<div style="padding:20px; text-align:center; color:#888;">Mencari...</div>';

                fetch(`${BASE_URL}/animes-home/searchAnimePage?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsDropdown.innerHTML = ''; 
                        if (data.length > 0) {
                            data.forEach(anime => {
                                const imgSrc = anime.Poster.startsWith('http') 
                                    ? anime.Poster 
                                    : `${BASE_URL}/assets/images/${anime.Poster}`;
                                
                                const type = anime.typeAnime || 'Anime'; 
                                const status = anime.status || 'Unknown';

                                resultsDropdown.innerHTML += `
                                    <a href='${BASE_URL}/anime/${anime.slug}' class="result-item">
                                        <img src="${imgSrc}" alt="${anime.Judul}">
                                        <div class="result-info">
                                            <span class="res-title">${anime.Judul}</span>
                                            <span class="res-meta">${type} • ${status}</span>
                                        </div>
                                    </a>`;
                            });
                        } else {
                            resultsDropdown.innerHTML = '<div style="padding:20px; text-align:center; color:#888;">Gak ada hasil, nih...</div>';
                        }
                    })
                    .catch(err => console.error('Search Error:', err));
            } else {
                resultsDropdown.style.display = 'none';
            }
        });
    }
});

function clearSearch() {
    const input = getEl('mysearch');
    if (input) {
        input.value = '';
        if (getEl('clear-btn')) getEl('clear-btn').style.display = 'none';
        if (getEl('search-results')) getEl('search-results').style.display = 'none';
        input.focus();
    }
}

// Update logika klik di luar untuk menutup menu
document.addEventListener('click', function(e) {
    try {
        const mobileNav = document.getElementById('mobileNav');
        
        // Jika menu sedang terbuka (.is-open)
        if (mobileNav && mobileNav.classList.contains('is-open')) {
            // Jika klik bukan di dalam menu dan bukan di tombol hamburger
            if (!mobileNav.contains(e.target) && !e.target.closest('.hamburger-btn')) {
                mobileNav.classList.remove('is-open');
            }
        }
        
        // Logika penutupan notif & profil tetap sama...
        const notifDropdown = document.getElementById('notificationDropdown');
        if (notifDropdown && notifDropdown.style.display === 'block') {
            if (!e.target.closest('.notification-bell')) notifDropdown.style.display = 'none';
        }
        
        const profileMenu = document.querySelector('.profile-dropdown-menu');
        if (profileMenu && profileMenu.style.display === 'block') {
            if (!e.target.closest('.user-profile')) profileMenu.style.display = 'none';
        }
    } catch (err) {
        // Abaikan error script admin
    }
});
// Menutup menu otomatis saat link diklik (opsional)
document.querySelectorAll('.mobile-nav-dropdown a').forEach(link => {
    link.addEventListener('click', () => {
        getEl('mobileNav').classList.remove('is-open');
    });
});
</script>