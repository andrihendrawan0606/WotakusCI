<style>
    <style>
/* Base Topbar Modern */
.topbar-modern {
    height: 4.375rem;
    background: #ffffff;
    border-bottom: 1px solid #f1f3f9;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03) !important;
}

/* Button View Site */
.btn-view-site {
    background: #f8fbff;
    color: #5e72e4;
    border: 1px solid #e8f2ff;
    padding: 8px 18px;
    border-radius: 50px;
    text-decoration: none !important;
    font-size: 13px;
    font-weight: 700;
    transition: 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}
.btn-view-site:hover {
    background: #5e72e4;
    color: #fff;
    box-shadow: 0 4px 15px rgba(94, 114, 228, 0.2);
}

/* Profile Pill Wrapper */
.profile-pill-wrapper {
    background: #f8fbff;
    border: 1px solid #f1f3f9;
    padding: 5px 5px 5px 15px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    transition: 0.3s;
}
.profile-pill-wrapper:hover {
    background: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.user-text-info {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.user-name-top {
    font-size: 13px;
    font-weight: 800;
    color: #32325d;
}

.user-role-top {
    font-size: 10px;
    color: #ac11e9; /* Samakan dengan tema ungu sidebar */
    font-weight: 700;
    letter-spacing: 0.5px;
}

.img-profile-modern {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Dropdown Modern Style */
.dropdown-modern {
    border: none !important;
    border-radius: 20px !important;
    padding: 15px !important;
    min-width: 220px !important;
    margin-top: 15px !important;
}

.dropdown-modern .dropdown-header {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 800;
    color: #adb5bd;
    padding-bottom: 10px;
}

.dropdown-modern .dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 15px !important;
    border-radius: 12px;
    font-size: 13.5px;
    color: #525f7f;
    font-weight: 600;
    margin-bottom: 2px;
}

.dropdown-modern .dropdown-item:hover {
    background-color: #f8fbff;
    color: #ac11e9;
}

/* Icon Circle inside dropdown */
.icon-circle {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}
.bg-soft-purple { background: rgba(172, 17, 233, 0.1); color: #ac11e9; }
.bg-soft-blue { background: rgba(94, 114, 228, 0.1); color: #5e72e4; }
.bg-soft-danger { background: rgba(245, 54, 92, 0.1); color: #f5365c; }

.topbar-divider {
    border-right: 1px solid #f1f3f9;
    height: 2.5rem;
    margin: auto 1rem;
}
</style>
</style>

<nav class="navbar navbar-expand navbar-light bg-white topbar-modern mb-4 static-top">
    <!-- Sidebar Toggle (Mobile) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    
    <button id="sidebarToggleDesktop" class="btn btn-link d-none d-md-inline-block mr-3" style="color: #4e4e6a; font-size: 1.2rem;">
        <i class="fas fa-bars"></i>
    </button>

    <!-- TOMBOL: VIEW WEBSITE (Sleek Design) -->
    <div class="d-none d-sm-inline-block mr-auto ml-md-3">
        <a href="<?= url_to('animes-home') ?>" class="btn-view-site">
            <i class="fas fa-external-link-alt"></i>
            <span>Lihat Website</span>
        </a>
    </div>

    <!-- Topbar Navbar Area -->
    <ul class="navbar-nav ml-auto align-items-center">
        
        <!-- Icon Play untuk Mobile -->
        <li class="nav-item d-sm-none">
            <a class="nav-link" href="<?= url_to('animes-home') ?>">
                <i class="fas fa-play-circle text-primary" style="font-size: 1.2rem;"></i>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Profile Pill -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="profile-pill-wrapper">
                    <div class="user-text-info mr-3 d-none d-lg-block">
                        <span class="user-name-top"><?= session()->get('nama'); ?></span>
                        <span class="user-role-top"><?= strtoupper(session()->get('role')); ?></span>
                    </div>
                    <?php $profileImg = session()->get('ProfileImg'); ?>
                    <img class="img-profile-modern" src="<?= base_url('assets/images/') . $profileImg; ?>" alt="Profile">
                </div>
            </a>

            <!-- Dropdown Modern (Glassmorphism) -->
            <div class="dropdown-menu dropdown-menu-right shadow-lg dropdown-modern animated--fade-in" aria-labelledby="userDropdown">
                <div class="dropdown-header">Akses Cepat</div>
                <a class="dropdown-item" href="<?= url_to('animes-home') ?>">
                    <div class="icon-circle bg-soft-purple"><i class="fas fa-tv"></i></div>
                    Tonton Anime
                </a>
                <a class="dropdown-item" href="<?= url_to('profileAdmin') ?>">
                    <div class="icon-circle bg-soft-blue"><i class="fas fa-user"></i></div>
                    Profil Saya
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger font-weight-bold" href="<?= base_url('auth/logout'); ?>">
                    <div class="icon-circle bg-soft-danger"><i class="fas fa-sign-out-alt"></i></div>
                    Keluar / Logout
                </a>
            </div>
        </li>
    </ul>
</nav>