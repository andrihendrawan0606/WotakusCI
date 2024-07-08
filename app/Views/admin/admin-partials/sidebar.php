<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= url_to('dashboard') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Wotakus - Admin</div>
    </a>
    <!-- Divider -->
    <!-- <hr class="sidebar-divider my-0"> -->
    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= (current_url() == url_to('dashboard')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= url_to('dashboard') ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->
    <!-- Nav Item - Tables -->
    <li class="nav-item <?= (current_url() == url_to('genreList')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= url_to('genreList') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>Genre</span></a>
    </li>

        <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->
    <!-- Nav Item - Tables -->
    <li class="nav-item <?= (current_url() == url_to('NewsList')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= url_to('NewsList') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>News</span></a>
    </li>

    <hr class="sidebar-divider">
    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="#">
        <i class="fas fa-fw fa-table"></i>
        <span>Users</span></a>
    </li>
    <!-- Divider -->
    <!-- <hr class="sidebar-divider d-none d-md-block"> -->
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>