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


.stat-card {
    border-radius: 20px;
    border: none;
    color: white;
    overflow: hidden;
    position: relative;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}

.stat-card:hover { transform: translateY(-5px); }

.bg-gradient-primary { background: linear-gradient(45deg, #4e73df, #224abe); }
.bg-gradient-success { background: linear-gradient(45deg, #1cc88a, #13855c); }
.bg-gradient-warning { background: linear-gradient(45deg, #f6c23e, #dda20a); }
.bg-gradient-info { background: linear-gradient(45deg, #36b9cc, #258391); }

.stat-body {
    padding: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 2;
}

.stat-info h6 {
    font-size: 0.7rem;
    font-weight: 800;
    margin-bottom: 5px;
    opacity: 0.8;
    letter-spacing: 1px;
}

.stat-info h2 { font-weight: 800; margin: 0; font-size: 1.8rem; }
.stat-subtext { font-size: 0.75rem; opacity: 0.7; }

.stat-icon-bg {
    font-size: 3rem;
    opacity: 0.2;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
}

.stat-footer {
    background: rgba(0,0,0,0.1);
    padding: 10px 25px;
}

.stat-footer a {
    color: white;
    font-size: 0.75rem;
    text-decoration: none;
    font-weight: 600;
}


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
    <div class="sync-group-modern">
        <div class="select-wrapper">
            <select id="fetchSource" class="custom-select-modern">
                <option value="seasons/now">Anime Musim Ini (On-Going)</option>
                <option value="top/anime">Top Populer (All Time)</option>
                <option value="seasons/upcoming">Upcoming (Akan Datang)</option>
            </select>
            <i class="fas fa-chevron-down select-icon"></i>
        </div>
        <button onclick="updateAnimeData()" class="btn-modern-sync">
            <i class="fas fa-sync-alt"></i>
            <span>Sync</span>
        </button>
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
        <!-- Total Anime -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-gradient-primary">
                <div class="stat-body">
                    <div class="stat-info">
                        <h6>TOTAL ANIME</h6>
                        <h2><?= esc($totalAnime) ?></h2>
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

        <!-- Total Episode -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-gradient-success">
                <div class="stat-body">
                    <div class="stat-info">
                        <h6>TOTAL EPISODE</h6>
                        <h2><?= esc($totalEpisode) ?></h2>
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

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-gradient-warning">
                <div class="stat-body">
                    <div class="stat-info">
                        <h6>ONGOING</h6>
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

        <!-- Widget di Dashboard Admin -->
<div class="stat-card bg-gradient-info">
    <div class="stat-body">
        <div class="stat-info">
            <h6>USER ONLINE</h6>
            <h2>14</h2> <!-- Hasil Count User yang last_activity < 5 menit -->
            <span class="stat-subtext">Sedang aktif saat ini</span>
        </div>
        <div class="stat-icon-bg">
            <i class="fas fa-users"></i>
        </div>
    </div>
</div>

        <!-- Tambahan: Total Genre -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-gradient-info">
                <div class="stat-body">
                    <div class="stat-info">
                        <h6>GENRE</h6>
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
let pageTrackers = {
    'seasons-now': 1,
    'top-anime': 1,
    'seasons-upcoming': 1
};

function updateAnimeData() {
    const rawSource = document.getElementById('fetchSource').value;
    const source = rawSource.replace('/', '-');
    const page = pageTrackers[source] || 1;

    Swal.fire({
        title: 'Checking Database...',
        text: `Memeriksa koleksi ${rawSource} Halaman ${page}`,
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();

            fetch(`<?= base_url("dashboard/fetchAnimeData") ?>/${source}/${page}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.fetched > 0) {
                            // ADA DATA BARU
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Update',
                                text: `${data.fetched} anime baru dari ${rawSource} berhasil ditambahkan!`,
                            }).then(() => location.reload());
                        } 
                        else if (data.fetched === 0 && data.has_next) {
                            // DATA DI HALAMAN INI SUDAH ADA, TAPI MASIH ADA HALAMAN LAIN
                            Swal.fire({
                                title: 'Data Sudah Ada',
                                text: `Seluruh anime di halaman ${page} sudah ada di database. Ingin mencari di halaman ${page + 1}?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Cari Lagi',
                                cancelButtonText: 'Cukup'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    pageTrackers[source]++;
                                    updateAnimeData();
                                }
                            });
                        } 
                        else {
                            // TIDAK ADA DATA BARU DAN SUDAH HALAMAN TERAKHIR
                            Swal.fire({
                                icon: 'success',
                                title: 'Sudah Lengkap!',
                                text: `Semua anime On-Going di kategori ${rawSource} sudah sinkron dengan database Anda.`,
                                confirmButtonColor: '#ac11e9'
                            });
                        }
                    } else {
                        Swal.fire('Gagal', data.message, 'error');
                    }
                });
        }
    });
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