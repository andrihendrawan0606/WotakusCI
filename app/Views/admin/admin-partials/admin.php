<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<style>
    /* Style Pesan di dalam dropdown */
.search-msg {
    padding: 20px;
    text-align: center;
    color: #888;
    font-size: 13px;
}

/* Item List Hasil Pencarian */
.search-result-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 15px;
    border-bottom: 1px solid #f1f3f9;
    transition: 0.2s;
}

.search-result-item:hover {
    background-color: #f8fbff;
}

.search-result-item:last-child {
    border-bottom: none;
}

.result-main {
    display: flex;
    align-items: center;
    gap: 15px;
    flex: 1;
}

.result-thumb {
    width: 40px;
    height: 55px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.result-details {
    display: flex;
    flex-direction: column;
}

.result-title {
    font-size: 14px;
    font-weight: 700;
    color: #32325d;
    line-height: 1.2;
}

.result-sub {
    font-size: 11px;
    color: #8898aa;
    margin-top: 3px;
}

/* Action Buttons di dalam list */
.result-actions {
    display: flex;
    gap: 8px;
}

.action-link {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-size: 12px;
    border: none;
    background: #f1f3f9;
    color: #525f7f;
    transition: 0.2s;
    text-decoration: none !important;
    cursor: pointer;
}

.action-link.view:hover { background: #e8f2ff; color: #4e73df; }
.action-link.edit:hover { background: #fff4e5; color: #f6c23e; }
.action-link.delete:hover { background: #ffebeb; color: #e74a3b; }
/* Container Utama Action Bar */
.action-bar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

/* Tombol Modern */
.btn-modern {
    padding: 10px 20px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    text-decoration: none !important;
}

.btn-primary-modern {
    background: #4e73df;
    color: white !important;
}

.btn-success-modern {
    background: #1cc88a;
    color: white !important;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important;
    filter: brightness(1.1);
}

/* Search Box Modern */
.search-modern-wrapper {
    position: relative;
    width: 400px; /* Lebar pencarian */
    max-width: 100%;
}

.search-input-group {
    background: #ffffff;
    border: 1px solid #e3e6f0;
    border-radius: 15px;
    padding: 5px 15px;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.search-input-group:focus-within {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1) !important;
}

.search-icon-dashboard {
    color: #b7b9cc;
    font-size: 16px;
    margin-right: 12px;
}

#searchInput {
    border: none;
    outline: none;
    width: 100%;
    padding: 8px 0;
    font-size: 14px;
    color: #4e5e7a;
    background: transparent;
}

/* Dropdown Hasil Pencarian agar tidak menggeser konten */
.search-results-dropdown-modern {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    z-index: 1000;
    border-radius: 12px;
    margin-top: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #f1f3f9;
}

/* Responsif untuk Mobile */
@media (max-width: 768px) {
    .action-bar-container {
        flex-direction: column;
        align-items: stretch;
    }
    .search-modern-wrapper {
        width: 100%;
    }
    .action-buttons-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .btn-modern {
        width: 100%;
        justify-content: center;
    }
    .ml-2 { margin-left: 0 !important; }
}


.stat-card-modern {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04); /* Bayangan super tipis, BUKAN neon */
    display: flex;
    flex-direction: column;
    overflow: hidden;
    color: #ffffff;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
}

.stat-card-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.stat-card-modern .stat-body {
    padding: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex: 1;
}

/* Typography Super Rapi */
.stat-info {
    z-index: 2;
}

.stat-info h6 {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 8px;
    color: rgba(255, 255, 255, 0.8); /* Teks sedikit transparan agar elegan */
}

.stat-info h2 {
    font-size: 2.25rem;
    font-weight: 800;
    margin-bottom: 4px;
    line-height: 1;
    letter-spacing: -1px;
}

.stat-info .stat-subtext {
    font-size: 0.85rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.9);
}

.stat-icon-bg {
    font-size: 3.5rem;
    color: rgba(255, 255, 255, 0.15); /* Icon transparan di background */
    z-index: 1;
}

.stat-footer {
    background: rgba(0, 0, 0, 0.12); /* Footer gelap transparan alami */
    padding: 12px 24px;
}

.stat-footer a {
    color: #ffffff;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    align-items: center;
    opacity: 0.9;
    transition: opacity 0.2s ease;
}

.stat-footer a:hover {
    opacity: 1;
}

/* Warna Flat Matte (Bukan Gradient Neon) */
.matte-primary { background: #334155; } /* Slate Navy */
.matte-success { background: #0f766e; } /* Emerald Dark */
.matte-warning { background: #b45309; } /* Amber Dark/Rust */
.matte-info    { background: #0369a1; } /* Ocean Blue */
.matte-purple  { background: #6d28d9; } /* Deep Purple */


/* button tambah dan fetch */

.action-bar-modern {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

/* Tombol Biru Tambah Manual */
.btn-modern-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
    color: white !important;
    padding: 12px 24px;
    border-radius: 15px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none !important;
    box-shadow: 0 4px 15px rgba(94, 114, 228, 0.3);
    transition: all 0.3s ease;
    border: none;
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 20px rgba(94, 114, 228, 0.4);
    filter: brightness(1.1);
}

/* Grup Sync (Gabungan Select & Button) */
.sync-group-modern {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid #e3e6f0;
    overflow: hidden; /* Memastikan kelengkungan pojok rapi */
}

/* Wrapper Select */
.select-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.custom-select-modern {
    appearance: none; /* Hilangkan panah bawaan browser */
    -webkit-appearance: none;
    background: transparent;
    border: none;
    padding: 12px 40px 12px 20px;
    font-size: 14px;
    font-weight: 600;
    color: #4e5e7a;
    cursor: pointer;
    outline: none;
    min-width: 250px;
}

.select-icon {
    position: absolute;
    right: 15px;
    color: #b7b9cc;
    pointer-events: none;
    font-size: 12px;
}

/* Tombol Sync Green */
.btn-modern-sync {
    background: #2dce89;
    color: white;
    border: none;
    padding: 12px 25px;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    border-left: 1px solid #e3e6f0;
}

.btn-modern-sync:hover {
    background: #24a46d;
    padding-left: 30px; /* Efek geser sedikit saat hover */
}

/* Style untuk Card Chart Modern */
.chart-card-modern {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    background: rgba(0, 0, 0, 0.2);
}

.text-primary-neon {
    color: #ac11e9 !important; /* Warna Ungu Khas Wotakus */
}

.chart-body {
    padding: 20px;
}

.chart-area {
    position: relative;
    height: 350px;
    width: 100%;
}


.sync-card-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.sync-card {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    background: #ffffff;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.sync-card:hover {
    border-color: #cbd5e1;
    background: #f8fafc;
}

.sync-card.active {
    border-color: #3b82f6; /* Warna garis biru elegan */
    background: #eff6ff;
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1);
}

.sync-card .card-icon {
    font-size: 1.5rem;
    margin-right: 15px;
    width: 30px;
    text-align: center;
}

.sync-card .card-text strong {
    display: block;
    font-size: 0.95rem;
    color: #1e293b;
    margin-bottom: 2px;
}

.sync-card .card-text span {
    display: block;
    font-size: 0.75rem;
    color: #64748b;
}

/* Custom Scrollbar untuk Terminal */
#syncTerminal::-webkit-scrollbar {
    width: 8px;
}
#syncTerminal::-webkit-scrollbar-track {
    background: #1e1e1e;
}
#syncTerminal::-webkit-scrollbar-thumb {
    background: #555;
    border-radius: 4px;
}
#syncTerminal::-webkit-scrollbar-thumb:hover {
    background: #777;
}


/* Responsif Mobile */
@media (max-width: 600px) {
    .action-bar-modern { flex-direction: column; align-items: stretch; }
    .sync-group-modern { flex-direction: column; }
    .btn-modern-sync { width: 100%; border-left: none; border-top: 1px solid #e3e6f0; justify-content: center; }
    .custom-select-modern { min-width: auto; width: 100%; }
}
</style>

    <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Dashboard Anime</h1>
        </div>
        <div class="action-bar-container mb-4">

        <div class="action-bar-modern mb-4">
    <!-- Tombol Tambah Manual -->
    <a href="<?= url_to('tampilTambah'); ?>" class="btn-modern-primary">
        <i class="fas fa-plus-circle"></i>
        <span>Tambah Manual</span>
    </a>

    <!-- Grup Sinkronisasi (Select + Button) -->
    <!-- <div class="sync-group-modern">
        <div class="select-wrapper">
            <select id="fetchSource" class="custom-select-modern" onchange="toggleManualInput()">
                <optgroup label="Cari Anime Baru">
                    <option value="seasons/now">Anime Musim Ini (On-Going)</option>
                    <option value="top/anime">Top Populer (All Time)</option>
                    <option value="seasons/upcoming">Upcoming (Akan Datang)</option>
                </optgroup>
                
                <optgroup label="Maintenance Data">
                    <option value="update-episodes"> Update Episode Mingguan</option>
                    <option value="manual-id"> Tarik Manual (MAL ID)</option>
                </optgroup>
            </select>
            <i class="fas fa-chevron-down select-icon"></i>
        </div>
        

        <input type="number" id="manualMalId" placeholder="Masukkan MAL ID..." class="custom-input-modern" style="display:none; width:150px; margin-left:10px; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
        
        <button id="btnSync" 
                data-scan="<?= base_url('dashboard/scanPage') ?>" 
                data-process="<?= base_url('dashboard/processSingle') ?>" 
                data-publish="<?= base_url('dashboard/publishBatch') ?>"
                data-scanongoing="<?= base_url('dashboard/scanOngoing') ?>"
                data-updateeps="<?= base_url('dashboard/updateEpisodeSingle') ?>"
                class="btn-modern-sync">
            <i class="fas fa-sync-alt"></i>
            <span>Sync</span>
        </button>
    </div> -->

    <!-- Tombol Trigger Modal -->
<button type="button" class="btn btn-success shadow-sm" data-toggle="modal" data-target="#modalSyncCenter" style="border-radius: 8px; font-weight: 600; padding: 10px 20px;">
    <i class="fas fa-satellite-dish mr-2"></i> Pusat Sinkronisasi API
</button>
</div>
<!-- MODAL COMMAND CENTER JIKAN API -->
<div class="modal fade" id="modalSyncCenter" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            
            <!-- Header Modal -->
            <div class="modal-header bg-dark text-white" style="border-bottom: none; padding: 20px 25px;">
                <h5 class="modal-title font-weight-bold" style="letter-spacing: 1px;">
                    <i class="fas fa-terminal text-success mr-2"></i> JIKAN API COMMAND CENTER
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8; text-shadow: none;">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>
            </div>

            <div class="modal-body bg-light" style="padding: 25px;">
                <div class="row">
                    <!-- KOLOM KIRI: PENGATURAN -->
                    <div class="col-lg-5 pr-lg-4">
                        <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.8rem; letter-spacing: 1px;">1. Pilih Mode Tarikan</h6>
                        
                        <!-- Pilihan Cards -->
                        <div class="sync-card-group mb-4">
                            <!-- Card 1: On-Going -->
                            <div class="sync-card active" data-mode="explore" data-source="seasons-now" onclick="selectSyncCard(this)">
                                <i class="fas fa-broadcast-tower card-icon text-primary"></i>
                                <div class="card-text">
                                    <strong>Anime Musim Ini</strong>
                                    <span>Tarik data On-Going terbaru</span>
                                </div>
                            </div>
                            <!-- Card 2: Top Anime -->
                            <div class="sync-card" data-mode="explore" data-source="top-anime" onclick="selectSyncCard(this)">
                                <i class="fas fa-trophy card-icon text-warning"></i>
                                <div class="card-text">
                                    <strong>Top Populer</strong>
                                    <span>Tarik anime legendaris (All Time)</span>
                                </div>
                            </div>
                            <!-- Card 3: Upcoming -->
                            <div class="sync-card" data-mode="explore" data-source="seasons-upcoming" onclick="selectSyncCard(this)">
                                <i class="fas fa-calendar-alt card-icon text-info"></i>
                                <div class="card-text">
                                    <strong>Upcoming Anime</strong>
                                    <span>Persiapan judul anime masa depan</span>
                                </div>
                            </div>
                            <!-- Card 4: Maintenance Episode -->
                            <div class="sync-card" data-mode="maintenance" data-source="update-episodes" onclick="selectSyncCard(this)">
                                <i class="fas fa-sync card-icon text-success"></i>
                                <div class="card-text">
                                    <strong>Update Episode Mingguan</strong>
                                    <span>Cek episode baru otomatis</span>
                                </div>
                            </div>
                            <!-- Card 5: Manual ID -->
                            <div class="sync-card" data-mode="manual" data-source="manual-id" onclick="selectSyncCard(this)">
                                <i class="fas fa-crosshairs card-icon text-danger"></i>
                                <div class="card-text">
                                    <strong>Tarik Manual Spesifik</strong>
                                    <span>Input via MyAnimeList ID</span>
                                </div>
                            </div>
                        </div>

                        <!-- Parameter Box (Dinamis) -->
                        <div id="parameterBox" class="bg-white p-3 rounded shadow-sm border mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.8rem;">2. Parameter Tambahan</h6>
                            
                            <!-- Muncul jika mode Explore -->
                            <div id="paramExplore">
                                <label class="font-weight-bold text-dark" style="font-size: 0.9rem;">Mulai dari Halaman API ke-Berapa?</label>
                                <input type="number" id="inputStartPage" class="form-control" value="1" min="1" style="background:#f8f9fe; border-radius:8px;">
                                <small class="text-muted mt-1 d-block">Ubah jika Anda tahu halaman awal sudah penuh di DB.</small>
                            </div>

                            <!-- Muncul jika mode Manual -->
                            <div id="paramManual" style="display: none;">
                                <label class="font-weight-bold text-dark" style="font-size: 0.9rem;">Masukkan MAL ID</label>
                                <input type="number" id="inputMalId" class="form-control" placeholder="Contoh: 5114" style="background:#f8f9fe; border-radius:8px;">
                            </div>

                            <!-- Muncul jika mode Maintenance -->
                            <div id="paramMaintenance" style="display: none;">
                                <div class="alert alert-success m-0 p-2" style="font-size: 0.85rem;">
                                    <i class="fas fa-info-circle mr-1"></i> Sistem akan me-scan seluruh anime yang berstatus <b>On-Going</b> di database Anda secara otomatis.
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Eksekusi -->
                        <!-- Simpan semua URL Route PHP di tombol ini -->
                        <button type="button" id="btnExecuteSync" class="btn btn-dark btn-block shadow" style="border-radius: 8px; font-weight: bold; padding: 12px;"
                            data-checkdup="<?= base_url('dashboard/checkDuplicateBatch') ?>"
                            data-process="<?= base_url('dashboard/processSingle') ?>" 
                            data-publish="<?= base_url('dashboard/publishBatch') ?>"
                            data-scanongoing="<?= base_url('dashboard/scanOngoing') ?>"
                            data-updateeps="<?= base_url('dashboard/updateEpisodeSingle') ?>">
                            <i class="fas fa-play mr-2"></i> MULAI PROSES SINKRONISASI
                        </button>
                    </div>

                    <!-- KOLOM KANAN: TERMINAL LOG -->
                    <div class="col-lg-7 mt-4 mt-lg-0 d-flex flex-column">
                        <div class="bg-dark rounded-top px-3 py-2 d-flex justify-content-between align-items-center">
                            <span class="text-white font-weight-bold" style="font-size: 0.8rem; letter-spacing: 1px;">SYSTEM LOG / TERMINAL</span>
                            <div class="d-flex gap-2">
                                <span style="width: 12px; height: 12px; background: #ff5f56; border-radius: 50%; display: inline-block;"></span>
                                <span style="width: 12px; height: 12px; background: #ffbd2e; border-radius: 50%; display: inline-block; margin: 0 4px;"></span>
                                <span style="width: 12px; height: 12px; background: #27c93f; border-radius: 50%; display: inline-block;"></span>
                            </div>
                        </div>
                        <div id="syncTerminal" class="bg-dark text-white p-3 rounded-bottom flex-grow-1" style="height: 450px; overflow-y: auto; font-family: 'Courier New', Courier, monospace; font-size: 0.85rem; line-height: 1.6; border: 1px solid #444;">
                            <div class="text-muted">Jikan API Engine v4.0 Ready. Menunggu perintah...</div>
                            <div class="text-muted">---------------------------------------------------</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



            <!-- Group Pencarian -->
            <div class="search-modern-wrapper">
                <div class="search-input-group shadow-sm">
                    <i class="fas fa-search search-icon-dashboard"></i>
                    <input type="text" id="searchInput" placeholder="Cari koleksi anime..." oninput="searchFunction(this.value)">
                </div>
                <!-- Hasil pencarian melayang (dropdown style) -->
                <div id="searchResults" class="search-results-dropdown-modern"></div>
            </div>
        </div>


        
        <div class="row mb-4">
    <!-- 1. Total Anime -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="stat-card-modern matte-primary">
            <div class="stat-body">
                <div class="stat-info">
                    <h6>TOTAL ANIME</h6>
                    <h2><?= esc($totalAnime ?? 0) ?></h2>
                    <span class="stat-subtext">Judul Terdaftar</span>
                </div>
                <div class="stat-icon-bg">
                    <i class="fas fa-tv"></i>
                </div>
            </div>
            <div class="stat-footer">
                <a href="#">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 2. Total Episode -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="stat-card-modern matte-success">
            <div class="stat-body">
                <div class="stat-info">
                    <h6>TOTAL EPISODE</h6>
                    <h2><?= esc($totalEpisode ?? 0) ?></h2>
                    <span class="stat-subtext">File Terunggah</span>
                </div>
                <div class="stat-icon-bg">
                    <i class="fas fa-play-circle"></i>
                </div>
            </div>
            <div class="stat-footer">
                <a href="#">Kelola Episode <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 3. Ongoing -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="stat-card-modern matte-warning">
            <div class="stat-body">
                <div class="stat-info">
                    <h6>ON-GOING</h6>
                    <h2>12</h2>
                    <span class="stat-subtext">Anime Sedang Tayang</span>
                </div>
                <div class="stat-icon-bg">
                    <i class="fas fa-sync-alt"></i>
                </div>
            </div>
            <div class="stat-footer">
                <a href="#">Cek Jadwal <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 4. User Online (Sudah diperbaiki wrapper col-nya) -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="stat-card-modern matte-info">
            <div class="stat-body">
                <div class="stat-info">
                    <h6>USER ONLINE</h6>
                    <h2>11</h2> 
                    <span class="stat-subtext">Sedang aktif saat ini</span>
                </div>
                <div class="stat-icon-bg">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-footer">
                <a href="#">Cek Aktivitas <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 5. Total Genre -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <!-- Menggunakan warna ungu agar tidak kembar dengan User Online -->
        <div class="stat-card-modern matte-purple">
            <div class="stat-body">
                <div class="stat-info">
                    <h6>TOTAL GENRE</h6>
                    <h2>24</h2> 
                    <span class="stat-subtext">Kategori Anime</span>
                </div>
                <div class="stat-icon-bg">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
            <div class="stat-footer">
                <a href="#">Kelola Genre <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

    <div style="width: 100%; margin-top: 20px;">
        <iframe src="https://cloud.umami.is/share/JkjhiT5TMsk0HCZq" width="100%" height="800px" frameborder="0" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);"></iframe>
    </div>
    <!-- ========================================= -->
        <!-- CHART STATISTIK SECTION -->
        <!-- ========================================= -->
        <div class="row mb-5 mt-2">
            <div class="col-12">
                <div class="chart-card-modern">
                    <div class="chart-header">
                        <div>
                            <h6 class="m-0 font-weight-bold text-primary-neon">
                                <i class="fas fa-chart-line mr-2"></i>Statistik Perkembangan Web
                            </h6>
                            <small class="text-muted">Data pengunjung dan anime ditambahkan dalam 7 hari terakhir</small>
                        </div>
                        <!-- Filter Dropdown (Visual Only) -->
                        <div class="chart-filter">
                            <select id="chartFilter" class="custom-select-modern" style="padding: 5px 10px; font-size: 12px;">
                                <option value="7_days">7 Hari Terakhir</option>
                                <option value="this_month">Bulan Ini</option>
                                <option value="this_year">Tahun Ini</option>
                            </select>
                        </div>
                    </div>
                    <div class="chart-body">
                        <div class="chart-area">
                            <canvas id="statistikChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========================================= -->

        <!-- ========================================= -->
        <!-- ROW BARU: TOP ANIME & PLACEHOLDER GENRE   -->
        <!-- ========================================= -->
        <div class="row mb-5">
            
            <!-- Kolom Kiri: TOP 5 ANIME CHART (Lebar 8 kolom) -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="chart-card-modern h-100">
                    <div class="chart-header">
                        <div>
                            <h6 class="m-0 font-weight-bold" style="color: #0a84ff;">
                                <i class="fas fa-trophy mr-2" style="color: #ffcc00;"></i> Top 5 Anime Paling Banyak Ditonton
                            </h6>
                            <small class="text-muted">Berdasarkan total akumulasi views semua episode</small>
                        </div>
                    </div>
                    <div class="chart-body">
                        <div class="chart-area" style="height: 300px;">
                            <canvas id="topAnimeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: PLACEHOLDER UNTUK NEXT CHART (Lebar 4 kolom) -->
            <!-- Kolom Kanan: STATISTIK GENRE (Lebar 4 kolom) -->
            <div class="col-lg-4">
                            <div class="chart-card-modern h-100">
                                <div class="chart-header">
                                    <div>
                                        <h6 class="m-0 font-weight-bold" style="color: #ff2e63;">
                                            <i class="fas fa-tags mr-2" style="color: #ff2e63;"></i> Top 5 Kategori Genre
                                        </h6>
                                        <small class="text-muted">Distribusi anime terbanyak</small>
                                    </div>
                                </div>
                                <div class="chart-body d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <!-- Container khusus agar Donut Chart tidak terlalu besar -->
                                    <div style="position: relative; height: 250px; width: 100%;">
                                        <canvas id="genreChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

        </div>
        <!-- ========================================= -->

        <!-- ========================================= -->
        <!-- ROW 3: STATISTIK KONTEN & MEMBER          -->
        <!-- ========================================= -->
        <div class="row mb-5">
            <!-- Pie Chart: Status Anime -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="chart-card-modern h-100">
                    <div class="chart-header">
                        <h6 class="m-0 font-weight-bold" style="color: #2dce89;">
                            <i class="fas fa-play-circle mr-2"></i> Rasio Status Koleksi Anime
                        </h6>
                    </div>
                    <div class="chart-body d-flex align-items-center justify-content-center" style="height: 250px;">
                        <canvas id="statusAnimeChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pie Chart: Tipe Member -->
            <div class="col-lg-6">
                <div class="chart-card-modern h-100">
                    <div class="chart-header">
                        <h6 class="m-0 font-weight-bold" style="color: #ffcc00;">
                            <i class="fas fa-crown mr-2"></i> Rasio Tipe Member (Monetisasi)
                        </h6>
                    </div>
                    <div class="chart-body d-flex align-items-center justify-content-center" style="height: 250px;">
                        <canvas id="userLevelChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


    <div class="container-p">
    <?php foreach ($animes as $anime) : ?>
    <div class="card-p" data-judul="<?= strtolower($anime['Judul']) ?>">
        <!-- Overlay Action Buttons (Top Right) -->
        <div class="card-actions">
            <button class="action-btn delete-btn fas fa-trash" title="Delete"></button>
            <button class="action-btn edit-btn fas fa-edit" title="Edit"></button>
            <button class="action-btn heart-btn fas fa-heart" title="Favorite"></button>
        </div>

        <div class="poster-wrapper">
            <?php
            $imgUrl = $anime['Poster'];
            $imgSrc = (filter_var($imgUrl, FILTER_VALIDATE_URL)) ? $imgUrl : base_url('assets/images/' . $anime['Poster']);
            ?>
            <img src="<?= $imgSrc ?>" alt="<?= $anime['Judul'] ?>" class="poster-img">
            <div class="status-badge <?= (strtolower($anime['statusTayang']) == 'draft') ? 'status-draft' : 'status-published' ?>">
            <?= $anime['statusTayang'] ?>
        </div>
        </div>

        <div class="card-info">
            <h3 class="main-title"><?= $anime['Judul'] ?></h3>
            <p class="sub-title"><?= $anime['JudulLainnya'] ?></p>
            
            <div class="button-group">
                <a href="<?= url_to('viewDetail', $anime['slug']); ?>" class="btn-modern btn-view">
                    <span>Lihat Detail</span>
                </a>
                <div class="secondary-actions">
                     <a href="<?= url_to('edit', $anime['slug']); ?>" class="icon-link edit"><i class="fas fa-pen"></i></a>
                     <button class="icon-link delete delete-anime" data-title="<?= $anime['Judul']; ?>" data-slug="<?= $anime['slug']; ?>"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

        <?= $pager->links('animes', 'anime_pagination') ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<script>
 const base_url = "<?= base_url() ?>";

 document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    let lastSearchResultsHTML = '';

    // Fungsi Pencarian
    const searchFunction = (query) => {
        // Tampilkan feedback loading sederhana
        searchResults.innerHTML = '<div class="search-msg"><i class="fas fa-spinner fa-spin mr-2"></i>Mencari anime...</div>';
        searchResults.style.display = 'block';

        fetch(`/dashboard/searchAnime?q=${query}`)
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    searchResults.innerHTML = '<div class="search-msg">Tidak ada anime yang ditemukan</div>';
                    lastSearchResultsHTML = searchResults.innerHTML;
                    return;
                }

                // Render hasil pencarian dengan format list yang rapi
                let html = '';
                data.forEach(anime => {
                    let posterPath = anime.Poster;
                    if (!/^https?:\/\//i.test(posterPath)) {
                        posterPath = `<?= base_url('assets/images/') ?>/${posterPath}`;
                    }

                    html += `
                    <div class="search-result-item">
                        <div class="result-main">
                            <img src="${posterPath}" alt="${anime.Judul}" class="result-thumb">
                            <div class="result-details">
                                <span class="result-title">${anime.Judul}</span>
                                <small class="result-sub">${anime.tipeAnime || 'Anime'} • ${anime.statusTayang || 'N/A'}</small>
                            </div>
                        </div>
                        <div class="result-actions">
                            <a href="/dashboard/detail/${anime.slug}" class="action-link view" title="Lihat"><i class="fas fa-eye"></i></a>
                            <a href="/dashboard/edit/${anime.slug}" class="action-link edit" title="Edit"><i class="fas fa-edit"></i></a>
                            <button onclick="deleteAnime('${anime.slug}', '${anime.Judul.replace(/'/g, "\\'")}')" class="action-link delete" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>`;
                });

                searchResults.innerHTML = html;
                lastSearchResultsHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                searchResults.innerHTML = '<div class="search-msg text-danger">Terjadi kesalahan koneksi</div>';
            });
    };

    // Input Event
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim();
        if (query.length >= 2) {
            searchFunction(query);
        } else {
            searchResults.style.display = 'none';
            searchResults.innerHTML = '';
            lastSearchResultsHTML = '';
        }
    });

    // Focus Event
    searchInput.addEventListener('focus', () => {
        if (lastSearchResultsHTML) {
            searchResults.style.display = 'block';
        }
    });

    // Close dropdown saat klik di luar
    document.addEventListener('click', (e) => {
        if (!searchResults.contains(e.target) && e.target !== searchInput) {
            searchResults.style.display = 'none';
        }
    });
});

    function editAnime(slug) {
        window.location.href = `/dashboard/edit/${slug}`;
    }

    function viewAnime(slug) {
        window.location.href = `/dashboard/detail/${slug}`;
    }

    function deleteAnime(slug, title) {
        const deleteUrl = "<?= url_to('delete', ''); ?>/" + slug;

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success swal2-confirm-margin",
                cancelButton: "btn btn-danger swal2-cancel-margin"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "Apakah Anda yakin?",
            html: "Data Judul Anime <strong>\"" + title + "\"</strong> ini tidak akan bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Tidak, batalkan!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(deleteUrl, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' 
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            swalWithBootstrapButtons.fire({
                                title: "Dihapus!",
                                html: "Anime dengan Judul <strong>\"" + title + "\"</strong> berhasil dihapus.",
                                icon: "success"
                            }).then(() => {
                                location.reload(); // Reload halaman setelah berhasil
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "Gagal!",
                                text: "Terjadi kesalahan saat menghapus anime: " + data.message,
                                icon: "error"
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting anime:', error);
                        swalWithBootstrapButtons.fire({
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat menghapus anime.",
                            icon: "error"
                        });
                    });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Dibatalkan",
                    html: "Data Anime <strong>\"" + title + "\"</strong> tidak jadi dihapus :)",
                    icon: "error"
                });
            }
        });
    }

    $(document).ready(function() {
        // Flashdata handling with SweetAlert2 toast
        <?php if (session()->getFlashdata('pesan')) : ?>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            Toast.fire({
                icon: 'success',
                title: '<?= session()->getFlashdata('pesan'); ?>'
            });
        <?php endif; ?>
    });

// Transisi Flash alert
setTimeout(function() {
        var alert = document.getElementById('flash-alert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease-out"; 
            alert.style.opacity = 0; 

            // Hapus elemen setelah transisi selesai
            setTimeout(function() {
                alert.remove();
            }, 500); 
        }
    }, 3000); // 3000 milidetik = 3 detik

    $(document).ready(function() {
    $(document).on('click', '.delete-anime', function(e) {
        e.preventDefault();
        const slug = $(this).data('slug');
        const title = $(this).data('title');
        const deleteUrl = "<?= url_to('delete', ''); ?>/" + slug;

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success swal2-confirm-margin",
                cancelButton: "btn btn-danger swal2-cancel-margin"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "Apakah Anda yakin?",
            html: "Data Judul Anime <strong>\"" + title + "\"</strong>.  ini tidak akan bisa dikembalikan !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Tidak, batalkan!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    method: 'POST',
                    data: {<?= csrf_token() ?>: '<?= csrf_hash() ?>'},
                    success: function(response) {
                        swalWithBootstrapButtons.fire({
                            title: "Dihapus!",
                            html: "Anime dengan Judul <strong>\"" + title + "\"</strong>  berhasil dihapus.",
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        swalWithBootstrapButtons.fire({
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat menghapus anime.",
                            icon: "error"
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Dibatalkan",
                    html: "Data Anime <strong>\"" + title + "\"</strong>. Tidak jadi dihapus :)",
                    icon: "error"
                });
            }
        });
    });
});
let currentSyncMode = 'explore';
let currentSyncSource = 'seasons-now';
let isSyncRunning = false;

// 1. FUNGSI UNTUK MENGGANTI KOTAK PILIHAN MODE
function selectSyncCard(element) {
    if(isSyncRunning) return; // Cegah ubah mode saat proses berjalan

    // Hapus kelas active dari semua card, pasang di yang diklik
    document.querySelectorAll('.sync-card').forEach(card => card.classList.remove('active'));
    element.classList.add('active');

    currentSyncMode = element.getAttribute('data-mode');
    currentSyncSource = element.getAttribute('data-source');

    // Sembunyikan semua parameter, lalu tampilkan yang sesuai
    document.getElementById('paramExplore').style.display = 'none';
    document.getElementById('paramManual').style.display = 'none';
    document.getElementById('paramMaintenance').style.display = 'none';

    if(currentSyncMode === 'explore') document.getElementById('paramExplore').style.display = 'block';
    if(currentSyncMode === 'manual') document.getElementById('paramManual').style.display = 'block';
    if(currentSyncMode === 'maintenance') document.getElementById('paramMaintenance').style.display = 'block';
}

// 2. FUNGSI PENCATAT TERMINAL
function logTerminal(message, type = 'info') {
    const term = document.getElementById('syncTerminal');
    const time = new Date().toLocaleTimeString('id-ID', { hour12: false });
    
    let color = '#e2e8f0'; // info (putih keabuan)
    if (type === 'success') color = '#4ade80'; // hijau
    if (type === 'warning') color = '#fbbf24'; // kuning
    if (type === 'error') color = '#f87171'; // merah
    if (type === 'process') color = '#60a5fa'; // biru
    if (type === 'system') color = '#a78bfa'; // ungu

    term.innerHTML += `<div style="color:${color}; margin-bottom:4px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 4px;">
                        <span style="color:#64748b;">[${time}]</span> ${message}
                       </div>`;
    
    // Auto-scroll ke bawah
    term.scrollTop = term.scrollHeight;
}

// 3. EVENT LISTENER SAAT TOMBOL "MULAI PROSES" DIKLIK
document.getElementById('btnExecuteSync').addEventListener('click', async function() {
    if(isSyncRunning) {
        Swal.fire('Proses Sedang Berjalan', 'Harap tunggu hingga proses di terminal selesai.', 'warning');
        return;
    }

    const urls = {
        scan: this.getAttribute('data-scan'),
        process: this.getAttribute('data-process'),
        publish: this.getAttribute('data-publish'),
        scanOngoing: this.getAttribute('data-scanongoing'),
        updateEps: this.getAttribute('data-updateeps')
    };

    // Bersihkan Terminal untuk tugas baru
    document.getElementById('syncTerminal').innerHTML = '';
    
    isSyncRunning = true;
    this.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> SEDANG MEMPROSES...';
    this.classList.replace('btn-dark', 'btn-secondary');
    
    // Nonaktifkan tombol close agar tidak di-close tidak sengaja
    const closeBtn = document.querySelector('#modalSyncCenter .close');
    closeBtn.style.display = 'none';

    // Mulai Eksekusi!
    await runEngine(urls, currentSyncMode, currentSyncSource);

    // Reset tombol setelah selesai
    isSyncRunning = false;
    this.innerHTML = '<i class="fas fa-play mr-2"></i> MULAI PROSES SINKRONISASI';
    this.classList.replace('btn-secondary', 'btn-dark');
    closeBtn.style.display = 'block';
});

// 4. MESIN UTAMA (Modifikasi dari kode lamamu)
aasync function fetchJikanDirect(url, retries = 3) { 
    for (let i = 0; i < retries; i++) {
        try {
            // 🔥 PERBAIKAN MUTLAK: CACHE BUSTER 🔥
            // Menambahkan timestamp unik di akhir URL agar browser mengira ini request baru
            // Contoh: ?page=15 berubah menjadi ?page=15&_t=17040201923
            const separator = url.includes('?') ? '&' : '?';
            const bypassCacheUrl = `${url}${separator}_t=${new Date().getTime()}`;

            // Tambahkan parameter { cache: 'no-store' } agar browser tidak berani menyimpan error
            const res = await fetch(bypassCacheUrl, { cache: 'no-store' });
            
            if (res.status === 200) {
                return await res.json();
            }
            
            if (res.status === 429 || res.status >= 500) {
                // KEMBALI KE 2 DETIK (Sesuai dengan penemuanmu bahwa Jikan pulih dengan cepat)
                logTerminal(`Jikan cegukan (Status ${res.status}). Mengulang dalam 2 detik...`, 'warning');
                await new Promise(r => setTimeout(r, 2000));
                continue;
            }
            
            return null; // Jika 404 (Halaman memang kosong)
        } catch (e) {
            logTerminal(`Jaringan terputus. Mengulang dalam 2 detik...`, 'error');
            await new Promise(r => setTimeout(r, 2000));
        }
    }
    return null;
}

// MESIN UTAMA BARU (CLIENT-SIDE SCRAPER)
async function runEngine(urls, mode, source, forceStartPage = null) {
    let queue = [];
    let startPage = forceStartPage || (document.getElementById('inputStartPage') ? parseInt(document.getElementById('inputStartPage').value) : 1);

    // ==========================================
    // TAHAP 1: BROWSER LANGSUNG MENEMBAK JIKAN API
    // ==========================================
    if (mode === 'manual') {
        const malId = document.getElementById('inputMalId').value;
        if (!malId) return logTerminal('ERROR: MAL ID kosong!', 'error');
        
        logTerminal(`Menarik data MAL ID: ${malId} langsung dari Jikan...`, 'process');
        const data = await fetchJikanDirect(`https://api.jikan.moe/v4/anime/${malId}`);
        if (data && data.data) queue = [data.data];
    } 
    else if (mode === 'maintenance') {
        // Maintenance tetep pakai PHP lokal untuk cari anime on-going
        logTerminal(`Mencari anime On-Going di database lokal...`, 'system');
        const res = await fetch(urls.scanOngoing);
        const data = await res.json();
        if (data.status === 'success') queue = data.queue;
    }
    else {
        // MODE EXPLORE: SMART CRAWLER BROWSER-SIDE
        let currentPage = startPage;
        let maxCrawlDepth = 5; 
        let isFound = false;

        while (!isFound && maxCrawlDepth > 0) {
            logTerminal(`Browser menyedot data Jikan API Halaman ${currentPage}...`, 'process');
            
            // BROWSER LANGSUNG KE JIKAN (VPS-mu aman dari pemblokiran)
            const data = await fetchJikanDirect(`https://api.jikan.moe/v4/${source}?page=${currentPage}`);
            
            if (data && data.data && data.data.length > 0) {
                // Kumpulkan semua ID dari Halaman ini
                const allIds = data.data.map(anime => anime.mal_id);
                
                // Tanya ke PHP (Database lokal): "Adakah ID ini yang belum tersimpan?"
                logTerminal(`Memeriksa ${allIds.length} anime ke database lokal...`, 'system');
                const checkRes = await fetch(urls.checkdup, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids: allIds })
                });
                const checkData = await checkRes.json();
                
                if (checkData.new_ids && checkData.new_ids.length > 0) {
                    // Filter hanya anime yang ID-nya benar-benar baru
                    queue = data.data.filter(anime => checkData.new_ids.includes(anime.mal_id));
                    isFound = true;
                    logTerminal(`Berhasil! Menemukan ${queue.length} anime baru di Halaman ${currentPage}.`, 'success');
                    document.getElementById('inputStartPage').value = currentPage;
                } else {
                    if (data.pagination.has_next_page) {
                        logTerminal(`Halaman ${currentPage} sudah lengkap di Database. Lanjut mencari...`, 'warning');
                        currentPage++;
                        maxCrawlDepth--;
                        await new Promise(r => setTimeout(r, 1000)); 
                    } else {
                        logTerminal(`Seluruh halaman sudah ditarik habis!`, 'success');
                        return;
                    }
                }
            } else {
                logTerminal('Data halaman kosong atau terjadi Error API Jikan.', 'error');
                return;
            }
        }

        if (!isFound) {
            Swal.fire({
                title: 'Database Lengkap!',
                text: `Sistem memindai sampai Halaman ${currentPage - 1}. Semuanya sudah ada di DB. Lanjut cari?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjut',
                cancelButtonText: 'Berhenti'
            }).then((res) => {
                if (res.isConfirmed) runEngine(urls, mode, source, currentPage);
            });
            return;
        }
    }

    if (queue.length === 0) return logTerminal('Tidak ada antrean untuk diproses.', 'warning');

    // ==========================================
    // TAHAP 2: EKSEKUSI PENYIMPANAN KE PHP
    // ==========================================
    let successCount = 0;
    let totalNewEps = 0;
    let newlyFetchedIds = [];

    logTerminal('---------------------------------------------------', 'info');
    logTerminal('MEMULAI PENYIMPANAN KE DATABASE...', 'system');

    for (let i = 0; i < queue.length; i++) {
        let item = queue[i];
        logTerminal(`[${i+1}/${queue.length}] Menyimpan: <b>${item.title || item.Judul}</b>...`, 'process');

        let formData = new FormData();
        formData.append('mal_id', item.mal_id);
        
        if (mode === 'maintenance') {
            formData.append('internal_id', item.internal_id);
        } else {
            // BAWA SEMUA JSON HASIL SEDOTAN BROWSER KE PHP (PHP TIDAK PERLU REQUEST LAGI)
            formData.append('anime_data', JSON.stringify(item));
        }

        try {
            const targetUrl = (mode === 'maintenance') ? urls.updateEps : urls.process;
            const req = await fetch(targetUrl, { method: 'POST', body: formData });
            const res = await req.json();

            if (res.status === 'success') {
                successCount++;
                if (mode !== 'maintenance' && res.anime_id) {
                    newlyFetchedIds.push(res.anime_id);
                    logTerminal(`&nbsp;&nbsp;↳ SUKSES: Data tersimpan.`, 'success');
                } else if (mode === 'maintenance') {
                    let newEps = parseInt(res.new_eps) || parseInt(res.eps_count) || parseInt(res.newEpsCount) || 0;
                    totalNewEps += newEps;
                    logTerminal(`&nbsp;&nbsp;↳ SUKSES: ${newEps} Episode masuk.`, 'success');
                }
            } else {
                logTerminal(`&nbsp;&nbsp;↳ DITOLAK: ${res.message}`, 'error');
            }
        } catch (e) { 
            logTerminal(`&nbsp;&nbsp;↳ GAGAL: Terjadi masalah lokal.`, 'error');
        }
        await new Promise(r => setTimeout(r, 1000));
    }

    // TAHAP 3: (Biarkan Pop Up SweetAlert persis seperti kode sebelumnya)
    if (mode === 'maintenance') {
        Swal.fire('Update Selesai', `Diperiksa: ${queue.length} anime. Masuk ${totalNewEps} Eps Baru.`, 'success');
    } else if (newlyFetchedIds.length > 0) {
        Swal.fire({
            title: 'Eksekusi Selesai!',
            text: `${successCount} Anime baru ada di Draft. Publish sekarang?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Publish',
            cancelButtonText: 'Draft'
        }).then(async (result) => {
            if (result.isConfirmed) {
                await fetch(urls.publish, { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({ ids: newlyFetchedIds }) });
                Swal.fire('Berhasil!', 'Anime diterbitkan.', 'success').then(() => location.reload());
            } else {
                Swal.fire('Tersimpan!', 'Silakan cek menu Draft.', 'info').then(() => location.reload());
            }
        });
    }
}

function toggleManualInput() {
    const val = document.getElementById('fetchSource').value;
    const inputId = document.getElementById('manualMalId');
    if (val === 'manual-id') {
        inputId.style.display = 'inline-block';
    } else {
        inputId.style.display = 'none';
        inputId.value = ''; // Reset isian
    }
}

// Jadikan variabel chart global agar bisa diupdate
var myStatChart; 

document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("statistikChart");
    if (ctx) {
        ctx = ctx.getContext('2d');

        var gradientPurple = ctx.createLinearGradient(0, 0, 0, 400);
        gradientPurple.addColorStop(0, 'rgba(172, 17, 233, 0.5)'); 
        gradientPurple.addColorStop(1, 'rgba(172, 17, 233, 0.0)'); 

        var gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
        gradientBlue.addColorStop(0, 'rgba(10, 132, 255, 0.5)');
        gradientBlue.addColorStop(1, 'rgba(10, 132, 255, 0.0)');

        // ==========================================
        // CHART 2: TOP 5 ANIME (BAR CHART HORIZONTAL)
        // ==========================================
        var ctxTop = document.getElementById("topAnimeChart");
        if (ctxTop) {
            ctxTop = ctxTop.getContext('2d');

            // Membuat Gradien Horizontal (Kiri Biru ke Kanan Ungu)
            var gradientBar = ctxTop.createLinearGradient(0, 0, 500, 0); 
            gradientBar.addColorStop(0, 'rgba(10, 132, 255, 0.8)'); // Biru
            gradientBar.addColorStop(1, 'rgba(172, 17, 233, 0.9)'); // Ungu Neon

            window.myTopChart = new Chart(ctxTop, {
                type: 'bar', // Tipe Bar
                data: {
                    // Data dari PHP
                    labels: <?= $topAnimeLabels ?>,
                    datasets: [{
                        label: 'Total Views',
                        data: <?= $topAnimeViews ?>,
                        backgroundColor: gradientBar,
                        borderRadius: 6, // Membuat ujung bar melengkung/modern
                        borderSkipped: false,
                        barThickness: 20 // Ketebalan batang
                    }]
                },
                options: {
                    indexAxis: 'y', // MENGUBAH BAR MENJADI HORIZONTAL
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }, // Sembunyikan tulisan 'Total Views' di atas karena sudah jelas
                        tooltip: {
                            backgroundColor: 'rgba(20, 20, 30, 0.9)',
                            titleColor: '#fff',
                            bodyColor: '#ccc',
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.x + ' Views';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { 
                                color: 'rgba(255, 255, 255, 0.05)',
                                drawBorder: false
                            },
                            ticks: { color: '#888' }
                        },
                        y: {
                            grid: { display: false }, // Hilangkan garis background agar bersih
                            ticks: { 
                                color: '#ddd', 
                                font: { weight: 'bold', family: 'Poppins' } 
                            }
                        }
                    }
                }
            });
        }

        myStatChart = new Chart(ctx, {
            type: 'line', 
            data: {
                labels: <?= $chartLabels ?>, // Data awal dari Controller utama
                datasets: [
                    {
                        label: "Aktivitas / Trafik (User Recent)",
                        tension: 0.4, 
                        backgroundColor: gradientPurple,
                        borderColor: "#ac11e9",
                        pointRadius: 4,
                        pointBackgroundColor: "#ac11e9",
                        pointBorderColor: "#fff",
                        fill: true,
                        data: <?= $dataPengunjung ?>, 
                    },
                    {
                        label: "Anime Ditambahkan",
                        tension: 0.4,
                        backgroundColor: gradientBlue,
                        borderColor: "#0a84ff",
                        pointRadius: 4,
                        pointBackgroundColor: "#0a84ff",
                        pointBorderColor: "#fff",
                        fill: true,
                        data: <?= $dataAnime ?>, 
                    }
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });

// ==========================================
        // FUNGSI KETIKA DROPDOWN FILTER DIPILIH
        // ==========================================
        document.getElementById('chartFilter').addEventListener('change', function() {
            var selectedFilter = this.value; 

            // Panggil API
            fetch(`<?= base_url('dashboard/admin/chartData') ?>?filter=` + selectedFilter)
                .then(response => response.json())
                .then(data => {
                    
                    // 1. UPDATE CHART PERKEMBANGAN WEB (LINE CHART)
                    if(typeof myStatChart !== 'undefined') {
                        myStatChart.data.labels = data.labels;
                        myStatChart.data.datasets[0].data = data.pengunjung;
                        myStatChart.data.datasets[1].data = data.anime;
                        myStatChart.update();
                    }

                    // 2. UPDATE CHART TOP 5 ANIME (BAR CHART)
                    // Pastikan var chart top anime Anda bisa diakses secara global (var myTopChart;)
                    if(typeof myTopChart !== 'undefined') {
                        myTopChart.data.labels = data.top_labels;
                        myTopChart.data.datasets[0].data = data.top_views;
                        myTopChart.update();
                    }

                })
                .catch(error => console.error('Error fetching chart data:', error));
        });

                // CHART 3: STATISTIK GENRE (DOUGHNUT CHART)
        // ==========================================
        var ctxGenre = document.getElementById("genreChart");
        if (ctxGenre) {
            ctxGenre = ctxGenre.getContext('2d');

            // Kita buat 5 warna bergradasi untuk masing-masing potongan donat
            // Warna disesuaikan dengan tema neon Anda (Ungu, Pink, Biru, Hijau, Kuning)
            var donutColors = [
                'rgba(172, 17, 233, 0.8)', // Ungu Neon
                'rgba(255, 46, 99, 0.8)',  // Pink Neon
                'rgba(10, 132, 255, 0.8)', // Biru
                'rgba(45, 206, 137, 0.8)', // Hijau (Mint)
                'rgba(255, 204, 0, 0.8)'   // Kuning
            ];
            
            var donutBorders = [
                '#ac11e9', '#ff2e63', '#0a84ff', '#2dce89', '#ffcc00'
            ];

            window.myGenreChart = new Chart(ctxGenre, {
                type: 'doughnut',
                data: {
                    // Data diambil dari PHP
                    labels: <?= $genreLabels ?>,
                    datasets: [{
                        data: <?= $genreCounts ?>,
                        backgroundColor: donutColors,
                        hoverBackgroundColor: donutBorders, // Warna jadi pekat saat dihover
                        hoverBorderColor: "rgba(255,255,255,0.5)",
                        borderWidth: 1,
                        borderColor: 'rgba(20, 20, 30, 1)' // Border hitam agar potongan terlihat terpisah
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%', // Ketebalan donat (semakin besar angkanya, cincin makin tipis)
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right', // Posisi keterangan warna (kiri/kanan/bawah/atas)
                            labels: {
                                color: '#ccc',
                                font: { family: 'Poppins', size: 11 },
                                boxWidth: 12,
                                padding: 15
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(20, 20, 30, 0.9)',
                            titleColor: '#fff',
                            bodyColor: '#ccc',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    if (label) { label += ': '; }
                                    label += context.parsed + ' Anime';
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }
    }
    // ==========================================
        // CHART 4: STATUS ANIME (PIE CHART)
        // ==========================================
        var ctxStatus = document.getElementById("statusAnimeChart");
        if (ctxStatus) {
            new Chart(ctxStatus.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Completed (Tamat)', 'On-Going (Berjalan)'],
                    datasets: [{
                        data: <?= $animeStatusData ?>,
                        backgroundColor: ['rgba(45, 206, 137, 0.8)', 'rgba(10, 132, 255, 0.8)'], // Hijau & Biru
                        hoverOffset: 10,
                        borderWidth: 2,
                        borderColor: '#fff' // Ganti ke #1a1a2e jika pakai tema gelap
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        // ==========================================
        // CHART 5: TIPE MEMBER (PIE/DOUGHNUT CHART)
        // ==========================================
        var ctxLevel = document.getElementById("userLevelChart");
        if (ctxLevel) {
            new Chart(ctxLevel.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Member Basic (Gratis)', 'Member Pro (Berbayar)'],
                    datasets: [{
                        data: <?= $userLevelData ?>,
                        backgroundColor: ['rgba(136, 136, 136, 0.6)', 'rgba(255, 204, 0, 0.9)'], // Abu-abu & Emas
                        hoverOffset: 10,
                        borderWidth: 2,
                        borderColor: '#fff' 
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '60%',
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }
});
</script>
	<?= $this->endSection() ?>