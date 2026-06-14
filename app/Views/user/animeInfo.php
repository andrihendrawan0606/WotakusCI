<?= $this->extend('user/pageLayoutInfo') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
.badge-new-episode {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(45deg, #ff00ea, #ac11e9); /* Warna neon purple/pink */
    color: white;
    padding: 3px 10px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 900;
    letter-spacing: 1px;
    z-index: 5;
    box-shadow: 0 0 15px rgba(172, 17, 233, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: pulseNew 2s infinite; /* Animasi berkedip pelan */
}

/* Animasi sederhana agar mata user langsung melirik ke episode baru */
@keyframes pulseNew {
    0% { transform: scale(1); box-shadow: 0 0 10px rgba(172, 17, 233, 0.5); }
    50% { transform: scale(1.05); box-shadow: 0 0 20px rgba(172, 17, 233, 0.8); }
    100% { transform: scale(1); box-shadow: 0 0 10px rgba(172, 17, 233, 0.5); }
}

.container-fluid{
    padding: 0;
}

/* Mencegah gambar menjadi raksasa */
.img-box-recommendation {
    display: grid;
    /* Sesuaikan minmax dengan kebutuhan lebar poster (biasanya 160px - 200px) */
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 25px; /* Pastikan gap ini SAMA dengan gap di episode-modern-grid */
    width: 100%;
    justify-content: start;
    margin: 0; /* Hapus margin yang mungkin membuatnya menjorok */
    padding: 0;
}

/* Memastikan poster tetap proporsional (Tinggi x Lebar = 3:2) */
.img-box-recommendation .poster-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 2/3; 
    border-radius: 12px;
    overflow: hidden;
    background: #1a1a1a;
}

.img-box-recommendation .poster {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Agar gambar tidak gepeng */
    display: block;
}

/* Perbaikan margin section agar selaras dengan episode di atasnya */
.recommendation-section {
    width: 100%;
    margin-top: 50px;
    border-top: 1px solid rgba(255, 255, 255, 0.05); /* Garis pemisah opsional */
    padding-top: 40px;
    padding: 0;
}

/* Header Section yang lebih bersih */
.section-title-container h3 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 5px;
    text-transform: uppercase;
}

@media (max-width: 768px) {
    .img-box-recommendation {
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 15px;
    }
}

</style>

<!--    ANIME INFO    -->
<div class="anime-detail-wrapper">
    <div class="hero-detail-section">
        <div class="row align-items-start">
            
            <!-- Sisi Kiri: Poster -->
            <div class="col-lg-4 col-md-5 mb-4">
                <div class="poster-container-premium shadow-lg">
                    <?php 
                        $posterPath = $anime['Poster'];
                        $imgSrc = (filter_var($posterPath, FILTER_VALIDATE_URL)) ? $posterPath : base_url('assets/images/' . $posterPath);
                    ?>
                    <img src="<?= $imgSrc ?>" alt="<?= $anime['Judul'] ?>" class="main-poster-img">
                    
                    <a href="#" class="trailer-play-overlay">
                        <div class="play-btn-neon"><i class="fas fa-play"></i></div>
                        <span>Lihat Trailer</span>
                    </a>
                </div>
            </div>

            <!-- Sisi Kanan: Judul & Deskripsi -->
            <div class="col-lg-8 col-md-7">
                <div class="main-info-content">
                    
                    <!-- AREA JUDUL & FAVORIT -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        <h1 class="anime-main-title m-0"><?= $anime['Judul'] ?></h1>
                        
                        <?php if(session()->get('isLoggedIn')): ?>
                            <?php 
                                $favModel = new \App\Models\UserFavoriteModel();
                                $isFav = $favModel->where(['user_id' => session()->get('id'), 'anime_id' => $anime['anime_id']])->first();
                            ?>
                            <button id="btn-favorite" 
                                    class="btn-fav-modern <?= $isFav ? 'active' : '' ?>" 
                                    onclick="toggleFavorite(<?= $anime['anime_id'] ?>)">
                                <i class="<?= $isFav ? 'fas' : 'far' ?> fa-heart"></i>
                                <span class="fav-text"><?= $isFav ? 'Favorited' : 'Add Favorite' ?></span>
                            </button>
                        <?php endif; ?>
                    </div>
        
                <div class="genre-pills mb-3">
                    <?php if (isset($anime['genre_list'])): ?>
                        <?php foreach ($anime['genre_list'] as $genre) : ?>
                            <a href="<?= url_to('animesbyGenre', $genre['slug_genre']); ?>" class="pill">
                                <?= esc($genre['genre']) ?>
                            </a>
                        <?php endforeach ?>
                    <?php endif; ?>
                    <span class="pill-type"><?= $anime['tipeAnime'] ?></span>
                </div>

                <div class="synopsis-box mb-4">
                    <h6 class="text-uppercase ls-1 text-primary-neon">Sinopsis</h6>
                    <p id="animeDesc" class="text-description">
                        <?= $anime['Desc'] ?>
                    </p>
                </div>

        <!-- ========================================== -->
        <!-- POSISI BARU: INPUT RATING USER -->
        <!-- ========================================== -->
        <?php if (session()->get('isLoggedIn')) : ?>
        <div class="user-rating-bar mb-4">
            <div class="d-flex align-items-center">
                <div class="rate-now">
                    <span class="small text-muted d-block mb-1 font-weight-bold">Beri Skor:</span>
                    <div class="stars-input">
                        <?php for ($i = 10; $i >= 1; $i--): ?>
                            <input type="radio" name="star_rating" value="<?= $i ?>" id="star<?= $i ?>" <?= ($my_rating == $i) ? 'checked' : '' ?>>
                            <label for="star<?= $i ?>"><i class="fas fa-star"></i></label>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="divider-vertical mx-4"></div>
                <div class="rate-status">
                    <span id="ratingMsg" class="badge-status-rate">
                        <?= ($my_rating > 0) ? 'Skor Anda: ' . $my_rating : 'Belum dinilai' ?>
                    </span>
                        <!-- TOMBOL BATAL: Muncul hanya jika sudah ada rating -->
                    <button id="btnCancelRating" 
                            onclick="deleteRating()" 
                            class="btn-cancel-rate ml-2" 
                            style="<?= ($my_rating > 0) ? 'display: flex;' : 'display: none;' ?>" 
                            title="Hapus Penilaian">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php else : ?>
        <!-- OPSIONAL: Berikan pesan kecil atau biarkan kosong agar bersih -->
        <!-- <p class="small text-muted mb-4">
            <i class="fas fa-info-circle"></i> <a href="<?= url_to('login') ?>" class="text-primary-neon">Login</a>
        </p> -->
    <?php endif; ?>
        <!-- ========================================== -->

        <!-- Bento Info Grid -->
        <div class="info-bento-grid">
            <!-- Isi bento grid tetap sama seperti kode Anda sebelumnya -->
            <div class="bento-item">
                <i class="fas fa-film"></i>
                <div><small>Episodes</small><span><?= $anime['Eps'] ?? '??' ?> Eps</span></div>
            </div>
            <div class="bento-item">
                <i class="fas fa-clock"></i>
                <div><small>Durasi</small><span><?= $anime['Durasi'] ?? '??' ?> Min</span></div>
            </div>
            <div class="bento-item">
                <i class="fas fa-calendar-alt"></i>
                <div><small>Rilis</small><span><?= format_indo_date($anime['Rilis']); ?></span></div>
            </div>
            <div class="bento-item">
                <i class="fas fa-hourglass-half"></i>
                <div><small>Status</small><span><?= $anime['status'] ?></span></div>
            </div>
            <div class="bento-item">
                <i class="fas fa-building"></i>
                <div>
                    <small>Studio</small>
                    <span><?= esc($anime['all_studios'] ?? 'Unknown') ?></span>
                </div>
            </div>

            <div class="bento-item">
                <i class="fas fa-globe-americas" style="color: #00d2ff;"></i>
                <div>
                    <small>MAL Score</small>
                    <span><?= ($anime['mal_score'] > 0) ? $anime['mal_score'] : 'N/A' ?></span>
                </div>
            </div>
            <div class="bento-item">
                <!-- Gunakan warna kuning emas yang lebih cerah -->
                <i class="fas fa-star" style="color: #ffcc00; filter: drop-shadow(0 0 8px rgba(255, 204, 0, 0.5));"></i>
                <div class="bento-content">
                    <small>Rating User</small>
                    <span class="main-value">
                        <?= ($rating_user > 0) ? number_format($rating_user, 1) : '0.0' ?> <span class="max-val">/ 10.0</span>
                    </span>
                    
                    <!-- Pindah posisi user di sini dengan styling baru -->
                    <?php if ($total_voters > 0) : ?>
                        <div class="voter-count">
                            <i class="fas fa-users"></i> <?= number_format($total_voters, 0, ',', '.') ?> total suara
                        </div>
                    <?php else : ?>
                        <div class="voter-count">Belum ada suara</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>

    <!-- Bagian 2: Metadata Tambahan (Judul Lain & Seri) -->
    <div class="metadata-section mt-5">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="meta-card">
                    <h6><i class="fas fa-language"></i> Judul Lainnya</h6>
                    <p><?= $anime['JudulLainnya'] ?? 'Tidak ada data.' ?></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="meta-card">
                    <h6><i class="fas fa-link"></i> Seri Terkait</h6>
                    <div class="related-list">
                        <?php if (!empty($relatedAnime)) : ?>
                            <?php foreach ($relatedAnime as $related) : ?>
                                <a href="<?= route_to('animeDetail', $related['slug'])?>" class="related-link">
                                    <i class="fas fa-external-link-alt"></i> <?= $related['Judul']; ?>
                                </a>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <span class="text-muted small">Belum ada seri lainnya.</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Bagian 3: Episode List -->
<div class="episode-section-modern mt-5">

    <!-- 1. KONTEN BAYANGAN (SKELETON) UNTUK SEARCH -->

    <!-- Header dengan Kontrol Search & Sort -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h2 class="section-heading m-0"><i class="fas fa-layer-group text-primary-neon"></i> Daftar Episode</h2>
        
        
        <div class="ep-controls-wrapper d-flex align-items-center gap-3">
            <!-- Kotak Pencarian -->
            <div class="ep-search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="epSearchInput" placeholder="Cari episode..." autocomplete="off">
            </div>

            <!-- Tombol Urutan -->
            <div class="ep-sort-pills">
                <button class="sort-pill active" id="sortNewest" title="Urutkan Terbaru">
                    <i class="fas fa-sort-numeric-down-alt"></i>
                </button>
                <button class="sort-pill" id="sortOldest" title="Urutkan Terlama">
                    <i class="fas fa-sort-numeric-up"></i>
                </button>
            </div>
        </div>
    <div id="epSearchSkeleton" class="episode-modern-grid mt-4" style="display: none;">
        <?php for($i=0; $i<6; $i++): ?>
            <div class="skeleton-card-ep">
                <div class="skeleton-img"></div>
                <div class="skeleton-text-row"></div>
            </div>
        <?php endfor; ?>
    </div>
    </div>

    <!-- Grid Episode -->
    
    <div class="episode-modern-grid mt-4" id="episodeContainer">
        <?php if (!empty($episode)) : ?>
            <?php foreach ($episode as $animeEpisode) : ?>
                <!-- BUNGKUS DALAM DIV AGAR MUDAH DI-SORT & SEARCH -->
                <div class="episode-item" 
                     data-number="<?= $animeEpisode['episode_number'] ?>" 
                     data-title="<?= strtolower($animeEpisode['judul']) ?>">
                    
                    <a href="<?= session()->get('isLoggedIn') ? url_to('showPreviewVideo', $anime['slug'], $animeEpisode['slug-episode']) : 'javascript:void(0);'; ?>" 
                        class="episode-card-modern" 
                        onclick="<?= !session()->get('isLoggedIn') ? 'showLoginAlert(); return false;' : ''; ?>">
                        
                        <div class="ep-img-box" style="background-image: url(<?= base_url('assets/imgPreview/' . $animeEpisode['GambarPreview']); ?>);">
                            <?php if (isNew($animeEpisode['created_at'])) : ?>
                                <div class="badge-new-episode"><span>NEW</span></div>
                            <?php endif; ?>
                            <div class="ep-play-icon"><i class="fas fa-play"></i></div>
                        </div>

                        <div class="ep-text">
                            <span class="ep-label">Episode <?= $animeEpisode['episode_number'] ?></span>
                            <span class="ep-views"><i class="fas fa-eye"></i> <?= formatViews($animeEpisode['view_count']) ?></span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-muted italic w-100 text-center py-5">Belum ada episode yang tersedia.</p>
        <?php endif; ?>
    </div>

    <div id="epPagination" class="ep-pagination-wrapper mt-5">
        <!-- Tombol akan diisi otomatis oleh JavaScript -->
    </div>

    <!-- Tampilan jika hasil pencarian kosong -->
    <div id="epNotFound" class="text-center py-5" style="display: none;">
        <i class="fas fa-search fa-3x text-muted mb-3"></i>
        <p class="text-muted">Episode tidak ditemukan...</p>
    </div>
</div>

<!-- SECTION: REKOMENDASI ANIME (AI POWERED) -->
<section class="recommendation-section">
<div class="container-fluid mb-5 pb-5">
    <div class="section-title-container mb-4">
        <h2 class="section-heading m-0">
            <i class="fas fa-project-diagram text-primary-neon mr-2" style="color: #00d2ff; filter: drop-shadow(0 0 5px rgba(0,210,255,0.5));"></i> 
            MUNGKIN ANDA SUKA
        </h2>
        <p class="text-muted small mt-1">Rekomendasi cerdas berdasarkan kemiripan judul, genre, dan studio.</p>
    </div>

    <!-- PENTING: Gunakan class img-box-recommendation -->
    <div class="img-box-recommendation"> 
        <?php if (!empty($recommendedAnime)) : ?>
            <?php foreach ($recommendedAnime as $recommend) : ?>
                <?php 
                    // -------------------------------------------------------------
                    // 1. LOGIKA WARNA BADGE CERDAS
                    // -------------------------------------------------------------
                    $badgeText = strtoupper($recommend['ai_badge'] ?? 'SIMILAR');
                    $badgeBg = '#2dce89'; // Default Hijau (Untuk Match biasa)
                    $badgeColor = '#000';
                    $badgeIcon = 'fa-percentage';

                    if (strpos($badgeText, 'SEQUEL') !== false || strpos($badgeText, 'NEXT') !== false) {
                        $badgeBg = '#f5365c'; // Merah/Pink Neon (Wajib Nonton Berikutnya)
                        $badgeColor = '#fff';
                        $badgeIcon = 'fa-forward';
                    } elseif (strpos($badgeText, 'PREQUEL') !== false || strpos($badgeText, 'PREVIOUS') !== false) {
                        $badgeBg = '#fb6340'; // Orange (Cerita masa lalu)
                        $badgeColor = '#fff';
                        $badgeIcon = 'fa-backward';
                    } elseif (strpos($badgeText, 'MOVIE') !== false || strpos($badgeText, 'OVA') !== false || strpos($badgeText, 'FRANCHISE') !== false) {
                        $badgeBg = '#8965e0'; // Ungu (Format Khusus / Side Story)
                        $badgeColor = '#fff';
                        $badgeIcon = 'fa-film';
                    }
                    
                    // -------------------------------------------------------------
                    // 2. LOGIKA HIGHLIGHT KATA KUNCI (TEXT REASON)
                    // -------------------------------------------------------------
                    $reasonHtml = $recommend['ai_reason'] ?? '';
                    // Daftar kata yang ingin di-highlight warna Biru Neon
                    $keywordsToHighlight = [
                        'kelanjutan', 'Sekuel', 'Musim Lanjutan', 
                        'Musim Sebelumnya', 'Film layar lebar', 
                        'Episode Spesial', 'Franchise', 'Genre, Studio, dan Tema'
                    ];
                    
                    foreach ($keywordsToHighlight as $word) {
                        // Replace kata dengan span berwarna cyan
                        $reasonHtml = str_ireplace(
                            $word, 
                            '<span style="color: #00d2ff; font-weight: 600; letter-spacing: 0.2px;">' . $word . '</span>', 
                            $reasonHtml
                        );
                    }
                ?>

                <a href="<?= url_to('animeDetail', $recommend['slug']); ?>" class="animeCard group">
                    <div class="poster-wrapper shadow-sm relative">
                        <?php 
                            $imgSrc = (filter_var($recommend['Poster'], FILTER_VALIDATE_URL)) ? $recommend['Poster'] : base_url('assets/images/' . $recommend['Poster']);
                        ?>
                        <img src="<?= $imgSrc ?>" alt="<?= esc($recommend['Judul']) ?>" class="poster transition-transform duration-500 group-hover:scale-110">
                        
                        <!-- BADGE DARI PYTHON (Dengan Warna Dinamis) -->
                        <div class="absolute top-2 right-2 z-20">
                            <span class="badge shadow px-2 py-1 text-[9px] font-bold" style="background-color: <?= $badgeBg ?>; color: <?= $badgeColor ?>; border-radius: 4px; letter-spacing: 0.5px;">
                                <i class="fas <?= $badgeIcon ?> mr-1"></i> <?= $badgeText ?>
                            </span>
                        </div>

                        <div class="card-overlay">
                            <div class="animeType"><?= $recommend['tipeAnime'] ?? 'TV' ?></div>
                            <div class="play-icon"><i class="fas fa-play"></i></div>
                        </div>
                    </div>
                    
                    <div class="anime-info mt-2">
                        <p class="anime-title font-bold text-[13px] leading-tight line-clamp-2" style="color: #fff;">
                            <?= esc($recommend['Judul']) ?>
                        </p>
                        
                        <!-- ALASAN REKOMENDASI (Dengan Highlight Kata Kunci) -->
                        <?php if(!empty($reasonHtml)): ?>
                            <p class="text-muted mt-1" style="font-size: 10px; line-height: 1.4; color: #8a93a0;">
                                <?= $reasonHtml ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach ?>
        <?php else : ?>
            <div class="col-12 text-center py-5 w-100">
                <i class="fas fa-magic fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                <p class="text-muted">Tidak ada rekomendasi yang mirip untuk saat ini.</p>
            </div>
        <?php endif ?>
    </div>
</div>
</section>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showLoginAlert() {
        const redirectUrl = encodeURIComponent(window.location.href);
        const loginUrl = `<?= url_to('login'); ?>?redirect=${redirectUrl}`;

        Swal.fire({
            title: 'Oops! Login Dulu Yuk',
            text: 'Silakan login terlebih dahulu untuk menikmati akses penuh menonton episode ini.',
            icon: 'info',
            iconColor: '#ac11e9',
            background: '#1a1a1a', 
            color: '#ffffff',    
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-sign-in-alt"></i> Login Sekarang',
            cancelButtonText: 'Nanti Saja',
            confirmButtonColor: '#ac11e9',
            cancelButtonColor: '#333333',
            customClass: {
                popup: 'anime-swal-popup',
                confirmButton: 'anime-swal-confirm',
                cancelButton: 'anime-swal-cancel',
                title: 'anime-swal-title'
            },
            buttonsStyling: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut animate__faster'
            },
            backdrop: `rgba(0,0,10,0.8) blur(10px)` 
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = loginUrl;
            }
        });
    }
        function toggleFavorite(animeId) {
        <?php if(!session()->get('isLoggedIn')): ?>
            showLoginAlert(); // Gunakan fungsi login alert yang sudah kita buat
            return;
        <?php endif; ?>

        const btn = document.getElementById('btn-favorite');
        const icon = btn.querySelector('i');
        const text = btn.querySelector('.fav-text');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('<?= base_url('api/toggleFavorite') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ anime_id: animeId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'added') {
                btn.classList.add('active');
                icon.classList.replace('far', 'fas');
                text.innerText = 'Favorited';
            } else {
                btn.classList.remove('active');
                icon.classList.replace('fas', 'far');
                text.innerText = 'Add to Favorite';
            }
        });
    }
    document.addEventListener("DOMContentLoaded", function() {
        var descElement = document.getElementById("animeDesc");
        if (!descElement) return; // Keamanan jika elemen tidak ditemukan

        var fullText = descElement.innerText;
        var words = fullText.split(" ");
        var wordLimit = 40;

        // Simpan teks pendek di luar agar bisa diakses fungsi toggle
        var shortText = words.slice(0, wordLimit).join(" ");

        if (words.length > wordLimit) {
            // Tambahkan 'event' ke dalam parameter toggleReadMore
            descElement.innerHTML = shortText + '... <a href="#" id="readMoreBtn" onclick="toggleReadMore(event)">Baca selengkapnya</a>';
        }

        window.toggleReadMore = function(e) {
            // KUNCI UTAMA: Mencegah browser melompat ke atas halaman
            if (e) e.preventDefault();

            // Gunakan pengecekan ID atau konten untuk menentukan status
            var btn = document.getElementById("readMoreBtn");
            
            if (btn.innerText === "Baca selengkapnya") {
                descElement.innerHTML = fullText + ' <a href="#" id="readMoreBtn" onclick="toggleReadMore(event)">Tampilkan lebih sedikit</a>';
            } else {
                descElement.innerHTML = shortText + '... <a href="#" id="readMoreBtn" onclick="toggleReadMore(event)">Baca selengkapnya</a>';
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
    const epSearch = document.getElementById('epSearchInput');
    const container = document.getElementById('episodeContainer');
    const skeleton = document.getElementById('epSearchSkeleton');
    const paginationBox = document.getElementById('epPagination');
    const noResult = document.getElementById('epNotFound');
    const btnNewest = document.getElementById('sortNewest');
    const btnOldest = document.getElementById('sortOldest');
    
    // --- KONFIGURASI AWAL ---
    const itemsPerPage = 12;
    let currentPage = 1;
    let searchTimeout;
    // Ambil semua item asli dari DOM saat pertama kali load
    let items = Array.from(document.querySelectorAll('.episode-item'));

    // --- FUNGSI UTAMA DISPLAY ---
    function updateDisplay(withSkeleton = true) {
        if (withSkeleton) {
            container.style.display = 'none';
            skeleton.style.display = 'grid';
            paginationBox.style.opacity = '0.3';
            paginationBox.style.pointerEvents = 'none';
        }

        // Filter item berdasarkan hasil search (data-search-match)
        const visibleItems = items.filter(item => item.getAttribute('data-search-match') !== 'false');
        const totalPages = Math.ceil(visibleItems.length / itemsPerPage);

        setTimeout(() => {
            if (withSkeleton) {
                skeleton.style.display = 'none';
                container.style.display = 'grid';
                paginationBox.style.opacity = '1';
                paginationBox.style.pointerEvents = 'auto';
            }

            // Sembunyikan semua item di DOM fisik
            items.forEach(item => {
                item.style.display = 'none';
                item.classList.remove('fade-in-smooth');
            });

            // Ambil potongan (slice) berdasarkan halaman aktif dari hasil yang sudah ter-SORT
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const currentItems = visibleItems.slice(start, end);

            // Munculkan item yang masuk dalam potongan halaman
            currentItems.forEach(item => {
                item.style.display = 'block';
                if (withSkeleton) item.classList.add('fade-in-smooth');
            });

            renderPagination(totalPages);
            if (visibleItems.length === 0 && epSearch.value.trim() !== "") {
            noResult.style.display = 'block';
            } else {
                noResult.style.display = 'none';
            }
        }, withSkeleton ? 400 : 0);
    }

    // --- FUNGSI SORTING GLOBAL ---
    function performSort(isAscending) {
        // Toggle class active pada tombol
        btnOldest.classList.toggle('active', isAscending);
        btnNewest.classList.toggle('active', !isAscending);

        // 1. Sortir array 'items' secara global
        items.sort((a, b) => {
            const valA = parseInt(a.getAttribute('data-number'));
            const valB = parseInt(b.getAttribute('data-number'));
            return isAscending ? valA - valB : valB - valA;
        });

        // 2. PENTING: Susun ulang urutan elemen di dalam HTML (DOM)
        // Agar saat kita melakukan slice(), urutannya sudah benar secara fisik
        items.forEach(el => container.appendChild(el));

        // 3. Reset ke halaman 1 setiap kali urutan berubah
        currentPage = 1;
        updateDisplay(true);
    }

    // --- RENDER TOMBOL PAGINASI ---
    function renderPagination(totalPages) {
        paginationBox.innerHTML = '';
        if (totalPages <= 1) return;

        // --- KONFIGURASI JENDELA DINAMIS ---
        let maxVisible = 4; // Jumlah angka yang ingin ditampilkan sekaligus
        let startPage, endPage;

        if (totalPages <= maxVisible) {
            // Jika total halaman lebih sedikit dari limit, tampilkan semua
            startPage = 1;
            endPage = totalPages;
        } else {
            // Logika Jendela Geser
            let half = Math.floor(maxVisible / 2);
            if (currentPage <= half) {
                // Jika di awal-awal halaman
                startPage = 1;
                endPage = maxVisible;
            } else if (currentPage + half >= totalPages) {
                // Jika sudah mendekati akhir halaman
                startPage = totalPages - maxVisible + 1;
                endPage = totalPages;
            } else {
                // Jika berada di tengah-tengah
                startPage = currentPage - half;
                endPage = currentPage + (maxVisible - half - 1);
            }
        }

        // Fungsi Helper membuat tombol (Pill)
        const createPill = (content, target, isDisabled, isActive = false) => {
            const pill = document.createElement('div');
            // Deteksi apakah ini angka atau arrow berdasarkan isi content
            const isArrow = (typeof content === 'string' && content.includes('fas'));
            pill.className = isArrow ? 'page-nav-pill' : `page-pill ${isActive ? 'active' : ''}`;

            if (isDisabled) {
                pill.style.opacity = '0.2';
                pill.style.pointerEvents = 'none';
            }

            pill.innerHTML = content;
            pill.onclick = (e) => {
                e.preventDefault();
                if (target !== currentPage) {
                    currentPage = target;
                    updateDisplay(true); // Panggil fungsi update dengan skeleton
                    
                    // Scroll kembali ke section episode secara presisi
                    const section = document.querySelector('.episode-section-modern');
                    window.scrollTo({
                        top: section.getBoundingClientRect().top + window.pageYOffset - 100,
                        behavior: 'smooth'
                    });
                }
            };
            return pill;
        };

        // 1. TOMBOL MUNDUR (PREVIOUS)
        paginationBox.appendChild(createPill('<i class="fas fa-chevron-left"></i>', currentPage - 1, currentPage === 1));

        // 2. LOOPING ANGKA DINAMIS (Jendela Geser)
        for (let i = startPage; i <= endPage; i++) {
            paginationBox.appendChild(createPill(i, i, false, i === currentPage));
        }

        // 3. TOMBOL MAJU (NEXT)
        paginationBox.appendChild(createPill('<i class="fas fa-chevron-right"></i>', currentPage + 1, currentPage === totalPages));
    }

    // --- LOGIKA PENCARIAN ---
    epSearch.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        clearTimeout(searchTimeout);
        
        container.style.display = 'none';
        skeleton.style.display = 'grid';
        paginationBox.style.opacity = '0';

        searchTimeout = setTimeout(() => {
            const isNumber = !isNaN(query) && query !== "";

            items.forEach(item => {
                const title = item.getAttribute('data-title');
                const num = item.getAttribute('data-number');
                // Gunakan Logika "Exact Match" untuk angka yang kita buat tadi
                let isMatch = (query === "") ? true : (isNumber ? (num === query) : title.includes(query));
                item.setAttribute('data-search-match', isMatch);
            });

            currentPage = 1;
            paginationBox.style.opacity = '1';
            updateDisplay(true);
        }, 500);
    });

    // Event Listener Sort
    btnNewest.addEventListener('click', () => performSort(false));
    btnOldest.addEventListener('click', () => performSort(true));

    // Jalankan pertama kali (Default: Terbaru/Desc)
    performSort(false); 
});

document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.stars-input input');

    // --- 1. LOGIKA SIMPAN / UPDATE RATING ---
    if (stars.length > 0) {
        stars.forEach(star => {
            star.addEventListener('change', function() {
                const ratingValue = this.value;
                const animeId = "<?= $anime['anime_id'] ?>";

                // Cek Login
                <?php if (!session()->get('isLoggedIn')): ?>
                    showLoginAlert();
                    this.checked = false;
                    return;
                <?php endif; ?>

                // Ambil CSRF Token
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '<?= csrf_hash() ?>';

                fetch('<?= base_url('api/saveRating') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        anime_id: animeId,
                        rating: ratingValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Update teks info
                        const msgElement = document.getElementById('ratingMsg');
                        if(msgElement) msgElement.innerText = 'Skor Anda: ' + ratingValue;
                        
                        // Munculkan tombol batal
                        const btnCancel = document.getElementById('btnCancelRating');
                        if(btnCancel) btnCancel.style.display = 'flex';
                        
                        // Update Rata-rata di Bento Grid
                        const bentoRating = document.querySelector('.info-bento-grid .fa-star').parentElement.querySelector('span');
                        if(bentoRating) bentoRating.innerText = data.new_avg + ' / 10.0';

                        // Toast Sukses
                        Swal.fire({
                            html: `<div class="custom-notif-wrapper">
                                    <div class="notif-icon"><i class="fas fa-star"></i></div>
                                    <div class="notif-text">
                                        <strong>Rating Berhasil!</strong>
                                        <span>Skor ${ratingValue}/10 telah disimpan</span>
                                    </div>
                                   </div>`,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            background: 'transparent',
                            customClass: { popup: 'anime-toast-popup', timerProgressBar: 'anime-toast-progress' }
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    }
});

// --- 2. LOGIKA HAPUS / CANCEL RATING (Harus di luar DOMContentLoaded agar terbaca onclick) ---
function deleteRating() {
    const animeId = "<?= $anime['anime_id'] ?>";
    
    // Ambil CSRF Token
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '<?= csrf_hash() ?>';

    // Langsung kirim perintah hapus ke server
    fetch('<?= base_url('api/deleteRating') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ anime_id: animeId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // 1. Reset Bintang di UI (Matikan semua pilihan)
            document.querySelectorAll('.stars-input input').forEach(radio => radio.checked = false);
            
            // 2. Update Teks dan Sembunyikan tombol batal
            document.getElementById('ratingMsg').innerText = 'Belum dinilai';
            document.getElementById('btnCancelRating').style.display = 'none';

            // 3. Update Rata-rata di Bento Grid secara instan
            const bentoRating = document.querySelector('.info-bento-grid .fa-star').parentElement.querySelector('span');
            if(bentoRating) bentoRating.innerText = (data.new_avg > 0 ? data.new_avg : 'N/A') + ' / 10.0';

            // 4. (Opsional) Berikan notifikasi kecil di pojok bahwa data sudah dihapus
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                background: '#1a1a1a',
                color: '#fff'
            });
            Toast.fire({
                icon: 'success',
                title: 'Penilaian dihapus'
            });
        }
    })
    .catch(error => console.error('Error:', error));
}function deleteRating() {
    const animeId = "<?= $anime['anime_id'] ?>";
    
    // Ambil CSRF Token
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '<?= csrf_hash() ?>';

    // Langsung kirim perintah hapus ke server
    fetch('<?= base_url('api/deleteRating') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ anime_id: animeId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // 1. Reset Bintang di UI (Matikan semua pilihan)
            document.querySelectorAll('.stars-input input').forEach(radio => radio.checked = false);
            
            // 2. Update Teks dan Sembunyikan tombol batal
            document.getElementById('ratingMsg').innerText = 'Belum dinilai';
            document.getElementById('btnCancelRating').style.display = 'none';

            // 3. Update Rata-rata di Bento Grid secara instan
            const bentoRating = document.querySelector('.info-bento-grid .fa-star').parentElement.querySelector('span');
            if(bentoRating) bentoRating.innerText = (data.new_avg > 0 ? data.new_avg : 'N/A') + ' / 10.0';

            // 4. (Opsional) Berikan notifikasi kecil di pojok bahwa data sudah dihapus
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                background: '#1a1a1a',
                color: '#fff'
            });
            Toast.fire({
                icon: 'success',
                title: 'Penilaian dihapus'
            });
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

<?= $this->endSection() ?>