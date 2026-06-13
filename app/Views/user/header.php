<!-- HEADER START -->
<script>
    const BASE_URL = "<?= base_url() ?>";
</script>
<meta name="csrf-token" content="<?= csrf_hash() ?>">

<header class="main-header">
    <div class="header-container">
        <!-- 1. Area Logo -->
        <div class="logo-section">
            <a href="<?= url_to('animes-home') ?>">
                <img src="<?= base_url('img/Wotakus.png') ?>" alt="Wotakus Logo" />
            </a>
        </div>

        <!-- Tombol Hamburger Mobile -->
        <div class="menu-mobile-toggle" onclick="toggleMenu()">☰</div>

        <!-- 2. Area Navigasi -->
        <nav class="nav-section" id="navSection">
            <ul class="nav-menu">
                <li class="<?= (current_url() == url_to('recent-anime')) ? 'active' : '' ?>"><a href="<?= url_to('recent-anime'); ?>">History</a></li>
                <li class="<?= (current_url() == url_to('animes-home')) ? 'active' : '' ?>"><a href="<?= url_to('animes-home'); ?>">Animes</a></li>
                <li class="<?= (current_url() == url_to('jadwal-rilis')) ? 'active' : '' ?>"><a href="<?= url_to('jadwal-rilis'); ?>">Jadwal</a></li>
                <li class="<?= (current_url() == url_to('genres')) ? 'active' : '' ?>"><a href="<?= url_to('genres'); ?>">Explore</a></li>
                <li class="<?= (current_url() == url_to('news')) ? 'active' : '' ?>"><a href="<?= url_to('news'); ?>">News</a></li>
            </ul>
        </nav>

        <!-- 3. Area Action (Search & User) -->
        <div class="action-section">
            <!-- Search Bar Modern -->
            <div class="search-wrapper">
                <div class="search-bar">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="mysearch" placeholder="Cari..." autocomplete="off">
                    <button id="clear-btn" class="clear-btn" onclick="clearSearch()">×</button>
                </div>
                <div id="search-results" class="search-results-dropdown"></div>
            </div>

            <?php if (session()->get('isLoggedIn')): ?>
                <!-- Notification -->
                <div class="notification-wrapper">
                    <div class="notification-bell" onclick="toggleNotifications(event)">
                        <i class="fas fa-bell"></i>
                        <span class="badge-count">6</span>
                    </div>
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notif-header">Notifikasi Terbaru</div>
                        <div class="notif-list">
                            <div class="notif-item">
                                <div class="notif-icon-circle"><i class="fas fa-play"></i></div>
                                <div class="notif-content">
                                    <p>Episode baru <b>One Piece</b> telah rilis!</p>
                                    <small>Baru saja</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="user-profile">
                    <button class="profile-pill">
                        <span class="user-name"><?= session()->get('nama'); ?></span>
                        <span class="level-tag"><?= session()->get('level') ?? 'BASIC'; ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="profile-dropdown-menu">
                        <a href="#"><i class="fas fa-user-circle"></i> Akun Saya</a>
                        <a href="<?= url_to('logout'); ?>" class="logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>