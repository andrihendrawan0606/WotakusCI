<?= $this->extend('animesLayout/pageLayout') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.tailwindcss.com"></script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<div id="progress-popup" style="display: none; text-align: center;">
    <h3>Mengambil Data Anime...</h3>
    <p id="estimated-time">Estimasi waktu: Sedang menghitung...</p>
    <p id="progress-text">0 dari 0 halaman telah selesai.</p>
    <progress id="progress-bar" value="0" max="100" style="width: 100%;"></progress>
</div>

<style>
.filter-header {
    display: flex;
    flex-direction: column; /* Membuat isi menumpuk ke bawah */
    align-items: flex-start; /* Tetap rata kiri */
    gap: 10px; /* Jarak antara tulisan dan tombol */
}

/* Container Tombol Switch */
.status-switch-wrapper {
    display: inline-flex; /* Agar lebar kotak mengikuti isi tombol saja */
    background: rgba(255, 255, 255, 0.05);
    padding: 4px;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Style Tombol */
.status-btn {
    border: none;
    background: transparent;
    color: #888;
    padding: 8px 25px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Tombol Aktif (Neon Purple) */
.status-btn.active {
    background: #ac11e9; /* Warna Ungu Sesuai Tema */
    color: white;
    box-shadow: 0 4px 15px rgba(172, 17, 233, 0.4);
}

.status-btn:hover:not(.active) {
    color: #fff;
    background: rgba(255, 255, 255, 0.05);
}

/* Animasi Content */
.status-content {
    animation: fadeIn 0.5s ease;
}
.skeleton-card {
    width: 100%;
    display: flex;
    flex-direction: column;
}

.skeleton-poster {
    width: 100%;
    aspect-ratio: 2/3;
    background: linear-gradient(90deg, #1a1a1a 25%, #252525 50%, #1a1a1a 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 12px;
    margin-bottom: 10px;
}

.skeleton-title {
    width: 80%;
    height: 15px;
    background: linear-gradient(90deg, #1a1a1a 25%, #252525 50%, #1a1a1a 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 4px;
}

/* Animasi Kilauan Bergerak */
@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

/* Memastikan transisi konten terasa smooth */
.status-content {
    transition: opacity 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 600px) {
    .filter-header { flex-direction: column; align-items: flex-start; }
    .status-switch-wrapper { width: 100%; }
    .status-btn { flex: 1; }
}




/* Container Setup */
.section h1 i.fa-chevron-double-right {
    color: #ac11e9; /* Warna ungu neon Anda */
    margin-right: 10px;
}

/* Ranking Badge Modern */
.rank-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 10;
    background: rgba(172, 17, 233, 0.9); /* Ungu pekat */
    color: white;
    padding: 5px 12px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    line-height: 1;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.rank-text {
    font-size: 8px;
    font-weight: 900;
    letter-spacing: 1px;
    margin-bottom: 2px;
    opacity: 0.8;
}

.rank-number {
    font-size: 1.2rem;
    font-weight: 900;
    font-family: 'Ubuntu', sans-serif;
}


.section-popular-wide {
    width: 100%;
    overflow: hidden;
    padding: 20px 0;
}

/* Swiper Slide Penyesuaian */
.popular-wide-swiper .swiper-slide {
    width: 85%; /* Membuat slide samping sedikit terlihat */
    max-width: 900px;
    transition: transform 0.3s ease;
}

/* Wide Card Meta Info */
.wide-meta {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}
/* Hover Effect pada Badge */
.wide-card:hover .rank-badge {
    transform: scale(1.1);
    background: #ac11e9;
    box-shadow: 0 0 20px rgba(172, 17, 233, 0.6);
    transition: 0.3s;
}

/* Memastikan Swiper Slide rata */
.popular-wide-swiper .swiper-slide {
    opacity: 0.3;
    transform: scale(0.92);
    transition: all 0.5s ease-in-out;
}

.popular-wide-swiper .swiper-slide-active {
    opacity: 1;
    transform: scale(1);
}

.meta-item {
    font-size: 12px;
    color: #fff;
    background: rgba(255, 255, 255, 0.1);
    padding: 4px 10px;
    border-radius: 6px;
    backdrop-filter: blur(5px);
    font-weight: 600;
}

.meta-item i {
    color: #ac11e9;
    margin-right: 5px;
}

/* Card Styling */
.wide-card {
    display: block;
    position: relative;
    width: 100%;
    height: 350px; /* Tinggi kartu landscape */
    border-radius: 30px;
    overflow: hidden;
    text-decoration: none !important;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 15px 35px rgba(0,0,0,0.5);
}

.wide-card-bg {
    position: absolute;
    inset: 0;
    /* Pastikan gambar mengisi seluruh area tanpa gepeng */
    background-size: cover; 
    
    /* PENTING: Karena poster asli berbentuk portrait, kita ambil sisi tengah-atasnya 
       agar wajah karakter biasanya tetap terlihat di mode landscape */
    background-position: center 20%; 
    
    background-repeat: no-repeat;
    transition: transform 0.6s ease;
    z-index: 1;
}

.wide-card:hover .wide-card-bg {
    transform: scale(1.08);
}

/* Pastikan Overlay cukup gelap di bagian teks agar poster yang terang tidak mengganggu */
.wide-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, 
        rgba(15, 15, 15, 0.95) 0%, 
        rgba(15, 15, 15, 0.6) 40%, 
        transparent 100%);
    z-index: 2;
    display: flex;
    align-items: center;
    padding: 0 50px;
}

/* Content Text */
.wide-content {
    max-width: 450px;
}

.wide-title {
    color: #fff;
    font-size: 2.2rem;
    font-weight: 900;
    margin-bottom: 15px;
    line-height: 1.1;
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
}

.wide-desc {
    color: rgba(255,255,255,0.7);
    font-size: 0.95rem;
    line-height: 1.5;
    margin-bottom: 20px;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Batasi 2 baris */
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Badges */
.wide-badges { display: flex; gap: 10px; }
.badge-pill {
    padding: 5px 15px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 800;
    color: #fff;
    text-transform: uppercase;
}
.bg-purple { background: #5e72e4; }
.bg-orange { background: #f5365c; }

/* ==========================================================
   PERBAIKAN TOP POPULAR MOBILE (2 COLUMN INVITING LOOK)
   ========================================================== */
   @media (max-width: 768px) {
    /* 1. Kurangi padding agar kartu lebih lebar */
    .section { padding: 0 10px !important; }
    
    .section h1 { 
        font-size: 1.2rem; 
        margin-bottom: 20px; 
        padding-left: 10px; 
    }

    /* 2. Sesuaikan Lebar Slide */
    .popular-wide-swiper .swiper-slide { 
        width: 88%; /* Menyisakan sedikit intipan slide berikutnya */
    }

    /* 3. Card Adjustments */
    .wide-card { 
        height: 300px; /* Tinggi ditambah sedikit agar info tidak sesak */
        border-radius: 24px; 
    }

    /* 4. PENTING: Ubah Gradasi jadi Vertikal */
    /* Karakter terlihat di atas, teks terbaca jelas di bawah */
    .wide-card-overlay { 
        padding: 20px; 
        align-items: flex-end; /* Dorong teks ke bawah */
        background: linear-gradient(to top, 
            rgba(15, 15, 15, 1) 0%, 
            rgba(15, 15, 15, 0.7) 40%, 
            transparent 100%);
    }

    .wide-content { max-width: 100%; text-align: left; }

    .wide-title { 
        font-size: 1.2rem; 
        margin-bottom: 10px; 
        letter-spacing: 0.2px;
    }

    /* 5. Rapikan Meta Info */
    .wide-meta { gap: 8px; }
    .meta-item { 
        font-size: 10px; 
        padding: 3px 8px; 
        background: rgba(172, 17, 233, 0.2);
        border: 1px solid rgba(172, 17, 233, 0.3);
    }

    /* 6. Perkecil Badge Ranking agar tidak 'offside' */
    .rank-badge {
        top: 15px;
        left: 15px;
        padding: 4px 10px;
        border-radius: 8px;
    }
    .rank-text { font-size: 7px; }
    .rank-number { font-size: 1rem; }
}
.section-personalized { padding: 0 40px; }

.ai-card {
    display: block;
    text-decoration: none !important;
    transition: 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.ai-poster-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 2/3; /* Memaksa kotak menjadi standar poster seragam */
    border-radius: 15px;
    overflow: hidden;
    background: #111;
    border: 1px solid rgba(255, 255, 255, 0.05);
    box-shadow: 0 10px 20px rgba(0,0,0,0.5);
}

.ai-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.5s ease;
}

.ai-card:hover { transform: translateY(-8px); }
.ai-card:hover .ai-img { transform: scale(1.08); filter: brightness(0.6); }

/* Badges (Tipe & Persentase) */
.ai-tags {
    position: absolute;
    top: 10px;
    left: 10px;
    right: 10px;
    display: flex;
    justify-content: space-between;
    z-index: 10;
}

.ai-type-tag {
    background: rgba(0,0,0,0.7);
    color: #fff;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 800;
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255,255,255,0.1);
}

.ai-match-tag {
    background: #2dce89; /* Warna hijau cerah khas Netflix Match Score */
    color: #000;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 900;
    box-shadow: 0 0 10px rgba(45, 206, 137, 0.4);
}

/* Play Icon Overlay */
.ai-play-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: 0.3s;
    z-index: 5;
}

.ai-play-overlay i {
    font-size: 3.5rem;
    color: #fff;
    filter: drop-shadow(0 0 15px rgba(0, 210, 255, 0.8)); /* Glow biru muda */
    transform: scale(0.5);
    transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.ai-card:hover .ai-play-overlay { opacity: 1; }
.ai-card:hover .ai-play-overlay i { transform: scale(1); }

/* Bagian Teks Bawah */
.ai-anime-title {
    color: #fff;
    font-size: 15px;
    font-weight: 800;
    line-height: 1.3;
}

.ai-reason-box {
    margin-top: 5px;
    padding: 6px 10px;
    background: rgba(0, 210, 255, 0.05); /* Background biru sangat tipis */
    border-left: 2px solid #00d2ff;
    border-radius: 0 6px 6px 0;
}

.reason-text {
    color: #a0a0a0;
    font-size: 11px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Batasi teks alasan agar tidak terlalu panjang */
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Navigasi Swiper AI */
.ai-nav-next, .ai-nav-prev {
    color: #00d2ff !important;
    transform: scale(0.6);
    opacity: 0;
    transition: 0.3s;
}
.personalized-swiper:hover .ai-nav-next, 
.personalized-swiper:hover .ai-nav-prev {
    opacity: 1;
}

@media (max-width: 768px) {
    .section-personalized { padding: 0 15px; }
}





</style>

<!-- Tombol -->
<!-- <button id="fetch-anime-button" class="btn btn-success">Fetch Anime Baru</button> -->

<?php 

$heroList = array_slice($heroList, 0, 5); 
?>

<div class="section-hero">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            <?php foreach ($heroList as $hero) : ?>
                <div class="swiper-slide">
                    <div class="hero-modern">
                        <div class="hero-overlay"></div>
                        
                        <?php 
                            $imgName = !empty($hero['BackgroundCover']) ? $hero['BackgroundCover'] : $hero['Poster'];
                            $imgSrc = (filter_var($imgName, FILTER_VALIDATE_URL)) ? $imgName : base_url('assets/images/' . $imgName);
                        ?>
                        
                        <div class="hero-bg" style="background-image: url('<?= $imgSrc ?>');"></div>

                        <div class="hero-content">
                            <span class="hero-badge">FEATURED ANIME</span>
                            <h1 class="hero-title"><?= esc($hero['Judul']) ?></h1>
                            
                            <p class="hero-meta">
                                <span><i class="fas fa-play-circle"></i> <?= esc($hero['tipeAnime']) ?></span>
                                <span>
                                    <i class="fas fa-star" style="color: #ffcc00;"></i> 
                                    <?php if ($hero['rating_user'] > 0) : ?>
                                        <?= number_format($hero['rating_user'], 1) ?> Rating
                                    <?php else : ?>
                                        <span style="font-weight: normal; color: #888;">Belum ada rating</span>
                                    <?php endif; ?>
                                </span>
                            </p>
                            
                            <div class="hero-desc">
                                <?= strip_tags($hero['Desc']) ?>
                            </div>
                            
                            <div class="hero-actions">
                                <a href="<?= url_to('animeDetail', $hero['slug']) ?>" class="btn-watch">
                                    <i class="fas fa-play"></i> Watch Now
                                </a>
                                <a href="<?= url_to('animeDetail', $hero['slug']) ?>" class="btn-details">
                                    <i class="fas fa-info-circle"></i> Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="swiper-pagination"></div>
    </div>
</div>

<!-- SECTION: PERSONALIZED DISCOVERY (EXPLAINABLE AI) -->
<?php if (session()->get('isLoggedIn') && !empty($personalizedAnimes)) : ?>
<div class="section-personalized mb-5 mt-5">
    <div class="section-title-container px-4 mb-4">
        <h1 class="m-0"><i class="fas fa-magic text-primary-neon"></i> KHUSUS UNTUKMU, <?= strtoupper(session()->get('nama')) ?></h1>
        <p class="text-muted small mt-1">Disusun oleh AI berdasarkan riwayat penilaian Anda.</p>
    </div>

    <!-- Gunakan Swiper agar tampilannya mewah (Anda bisa copy class popular-swiper) -->
<!-- SECTION: PERSONALIZED DISCOVERY (EXPLAINABLE AI) -->
<?php if (session()->get('isLoggedIn') && !empty($personalizedAnimes)) : ?>
<div class="section-personalized mb-5 mt-5">
    <div class="section-title-container mb-4">
        <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.8rem;">
            <i class="fas fa-magic mr-2" style="color: #00d2ff; filter: drop-shadow(0 0 8px rgba(0, 210, 255, 0.5));"></i> 
            Pilihan Untukmu, <?= strtoupper(session()->get('nama')) ?>
        </h1>
        <p class="text-muted small mt-1" style="font-size: 12px; letter-spacing: 0.5px;">
            Rekomendasi cerdas berdasarkan riwayat penilaian Anda.
        </p>
    </div>

    <div class="swiper personalized-swiper" style="padding-bottom: 30px;">
        <div class="swiper-wrapper">
            <?php foreach ($personalizedAnimes as $anime) : ?>
                <div class="swiper-slide">
                    <a href="<?= url_to('animeDetail', $anime['slug']) ?>" class="ai-card">
                        
                        <div class="ai-poster-wrapper">
                            <?php $imgSrc = (filter_var($anime['Poster'], FILTER_VALIDATE_URL)) ? $anime['Poster'] : base_url('assets/images/' . $anime['Poster']); ?>
                            <img src="<?= $imgSrc ?>" class="ai-img" alt="<?= esc($anime['Judul']) ?>">
                            
                                <!-- 1. INI UNTUK MENAMPILKAN PERSENTASE MATCH -->
                                <div class="badge-match" style="position: absolute; top: 10px; right: 10px; z-index: 2;">
                                    <span class="badge" style="background-color: #00e676; color: #000; font-weight: bold;">
                                        <?= isset($anime['match_percentage']) ? $anime['match_percentage'] : '85' ?>% Match
                                    </span>
                                </div>
                            
                            <!-- Play Icon Hover -->
                            <div class="ai-play-overlay">
                                <i class="fas fa-play-circle"></i>
                            </div>
                        </div>
                        
                        <!-- Informasi di bawah gambar -->
                        <div class="ai-info-container mt-3">
                            <h3 class="ai-anime-title text-truncate mb-1" title="<?= esc($anime['Judul']) ?>">
                                <?= esc($anime['Judul']) ?>
                            </h3>
                            
                            <!-- 2. INI UNTUK MENAMPILKAN ALASAN / REASON (Contoh: Karena Anda menyukai One Punch Man) -->
                            <div class="anime-reason px-2 pb-2">
                                <small class="text-muted" style="font-size: 10px;">
                                    <?= isset($anime['reason']) ? $anime['reason'] : 'Disarankan oleh sistem cerdas.' ?>
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Tambahkan navigasi jika ingin bisa digeser manual (opsional) -->
        <div class="swiper-button-next ai-nav-next"></div>
        <div class="swiper-button-prev ai-nav-prev"></div>
    </div>
</div>


<!-- SECTION: TOP POPULAR (ULTRA PREMIUM GLASS) -->
<div class="section mb-5">
    <!-- Judul disamakan dengan section ANIMES -->
    <h1><i class="fad fa-chevron-double-right"></i> TOP POPULAR</h1>

    <div class="swiper popular-wide-swiper">
        <div class="swiper-wrapper">
            <?php $rank = 1; foreach ($popularAnimes as $pop) : ?>
                <div class="swiper-slide">
                    <a href="<?= url_to('animeDetail', $pop['slug']) ?>" class="wide-card">
                        
                        <!-- Lencana Peringkat (Ranking Badge) -->
                        <div class="rank-badge">
                            <span class="rank-text">TOP</span>
                            <span class="rank-number"><?= $rank++ ?></span>
                        </div>

                        <!-- Background Image -->
                                            <?php 
                                // 1. Logika Fallback: Jika BackgroundCover kosong, gunakan Poster
                                $imageToUse = !empty($pop['BackgroundCover']) ? $pop['BackgroundCover'] : $pop['Poster'];
                                
                                // 2. Logika Path: Cek apakah URL external atau file lokal
                                if (filter_var($imageToUse, FILTER_VALIDATE_URL)) {
                                    $imgSrc = $imageToUse;
                                } else {
                                    $imgSrc = base_url('assets/images/' . $imageToUse);
                                }
                            ?>

                            <!-- Background Image dengan class khusus -->
                            <div class="wide-card-bg" style="background-image: url('<?= $imgSrc ?>');"></div>
                        
                        <!-- Overlay Info -->
                        <div class="wide-card-overlay">
                            <div class="wide-content">
                                <h2 class="wide-title"><?= esc($pop['Judul']) ?></h2>
                                <p class="wide-desc">
                                    <?= strip_tags($pop['Desc']) ?>
                                </p>
                                <div class="wide-meta">
                                    <span class="meta-item"><i class="fas fa-eye"></i> <?= number_format($pop['total_views'], 0, ',', '.') ?> Views</span>
                                    <span class="meta-item"><i class="fas fa-play-circle"></i> <?= $pop['tipeAnime'] ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

<div class="section mb-5">
    <h1><i class="fad fa-chevron-double-right"></i> ANIMES</h1>

    <div class="img-box"> 
        <div id="loading-search" style="display: none; text-align: center; grid-column: 1/-1;">
            <p>Loading...</p>
        </div>

        <?php foreach ($animes as $anime) : ?>
            <a href="<?= url_to('animeDetail', $anime['slug']) ?>" class="animeCard">
                <div class="poster-wrapper">
                    <?php if ($anime['status'] === 'Completed') : ?>
                        <div class="completed-label">Completed</div>
                    <?php endif; ?>

                    <?php 
                    $posterPath = $anime['Poster'];
                    $imgSrc = (filter_var($posterPath, FILTER_VALIDATE_URL)) ? $posterPath : base_url('assets/images/' . $posterPath);
                    ?>
                    <img src="<?= $imgSrc; ?>" alt="Poster <?= $anime['Judul'] ?>" class="poster">
                    
                    <div class="card-overlay">
                        <div class="animeType"><?= $anime['tipeAnime'] ?></div>
                    </div>
                </div>
                <div class="anime-info">
                    <p class="anime-title"><?= $anime['Judul'] ?></p>
                </div>
            </a>
        <?php endforeach; ?> <!-- End Loop -->
    </div> 

    <div class="pagination-wrapper mt-5">
        <?= $pager->links('animes', 'anime_pagination'); ?>
    </div>
</div>

<div class="section mb-5">
    <div class="filter-header mb-4">
        <h1 class="mb-3"><i class="fad fa-stars"></i> UPDATE STATUS</h1>
        <div class="status-switch-wrapper">
            <button class="status-btn active" onclick="switchStatus('ongoing', this)">On-Going</button>
            <button class="status-btn" onclick="switchStatus('completed', this)">Completed</button>
        </div>
    </div>

    <!-- 1. KONTEN BAYANGAN (SKELETON) -->
    <div id="skeleton-content" class="status-content" style="display: none;">
        <div class="img-box">
            <?php for($i=0; $i<6; $i++): ?>
                <div class="skeleton-card">
                    <div class="skeleton-poster"></div>
                    <div class="skeleton-title"></div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Container Ongoing -->
    <div id="ongoing-content" class="status-content" style="display: grid;">
        <div class="img-box">
            <?php foreach ($ongoing as $anime) : ?>
                <a href="<?= url_to('animeDetail', $anime['slug']) ?>" class="animeCard">
                    <div class="poster-wrapper">
                        <img src="<?= (filter_var($anime['Poster'], FILTER_VALIDATE_URL)) ? $anime['Poster'] : base_url('assets/images/' . $anime['Poster']); ?>" class="poster">
                        <div class="card-overlay">
                            <div class="animeType"><?= $anime['tipeAnime'] ?></div>
                        </div>
                    </div>
                    <div class="anime-info">
                        <p class="anime-title"><?= $anime['Judul'] ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Container Completed -->
    <div id="completed-content" class="status-content" style="display: none;">
        <div class="img-box">
            <?php foreach ($completed as $anime) : ?>
                <a href="<?= url_to('animeDetail', $anime['slug']) ?>" class="animeCard">
                    <div class="poster-wrapper">
                        <div class="completed-label">Completed</div>
                        <img src="<?= (filter_var($anime['Poster'], FILTER_VALIDATE_URL)) ? $anime['Poster'] : base_url('assets/images/' . $anime['Poster']); ?>" class="poster">
                        <div class="card-overlay">
                            <div class="animeType"><?= $anime['tipeAnime'] ?></div>
                        </div>
                    </div>
                    <div class="anime-info">
                        <p class="anime-title"><?= $anime['Judul'] ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="section-new-release mb-5">
    <div class="section-title-container">
        <h1><i class="fad fa-chevron-double-right"></i> NEW RELEASE EPISODES</h1>
    </div>

    <div class="episode-modern-grid">
        <?php foreach ($newEpisodes as $episode) : ?>
            <?php 
                $link = session()->get('isLoggedIn') 
                        ? url_to('showPreviewVideo', $episode['slug'], $episode['slug-episode']) 
                        : url_to('animeDetail', $episode['slug']);
            ?>
            
            <div class="episode-card-modern">
                <a href="<?= $link ?>" class="episode-anchor">
                    <div class="episode-image-box">
                        <img src="<?= base_url('assets/imgPreview/' . $episode['GambarPreview']) ?>" alt="<?= $episode['judul'] ?>" class="ep-img">
                        
                        <!-- Overlay Glassmorphism -->
                        <div class="ep-overlay">
                            <div class="ep-play-btn">
                                <i class="fas fa-play"></i>
                            </div>
                            <div class="ep-badge"><?= $episode['tipeAnime'] ?? 'TV' ?></div>
                        </div>

                        <!-- Info Floating di bawah gambar -->
                        <div class="ep-info-content">
                            <h2 class="ep-main-title"><?= esc($episode['Judul']) ?></h2>
                            <h3 class="ep-sub-title"><?= esc($episode['judul']) ?></h3>
                            <div class="ep-meta">
                                <span class="ep-time"><i class="far fa-clock"></i> <?= htmlspecialchars(timeAgo($episode['created_at'])) ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- <div>
    <input type="text" id="aiInput" placeholder="Ketik: Anime yang bikin nangis bombay...">
    <button onclick="cariPakaiAI()">Tanya Gemini</button>
</div> -->

<!-- Tempat Menampilkan Hasil -->
<div id="aiPesan"></div>
<div id="animeContainer"></div>

<script>
async function cariPakaiAI() {
    const inputUser = document.getElementById('aiInput').value;
    const pesanDiv = document.getElementById('aiPesan');
    const wadahAnime = document.getElementById('animeContainer');
    
    pesanDiv.innerHTML = "<i>AI sedang mikir... tunggu bentar ya!</i>";
    wadahAnime.innerHTML = "";

    try {
        // Tembak endpoint CodeIgniter 4
        const response = await fetch('/api/ai-search?query=' + encodeURIComponent(inputUser));
        const result = await response.json();

        // Tampilkan balasan ngobrol dari Gemini
        // 2. TAMBAHKAN BARIS INI UNTUK DEBUGGING:
        console.log("Data dari Server:", result);

        // Jika hasilnya ada di dalam result.pesan_ai
        if(result.pesan_ai) {
            pesanDiv.innerHTML = "<b>Wotakus AI:</b> " + result.pesan_ai;
        } else {
            // Jika undefined, tampilkan seluruh isi result agar kita tahu isinya
            pesanDiv.innerHTML = "<b>Wotakus AI:</b> " + JSON.stringify(result);
        }

        // Looping data anime yang dikembalikan (JjkModel)
        if(result.animes && result.animes.length > 0) {
            result.animes.forEach(anime => {
                // Tampilkan kartunya (Sesuaikan dengan class CSS Anda)
                wadahAnime.innerHTML += `
                    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
                        <img src="/assets/images/${anime.Poster}" width="100">
                        <h3>${anime.Judul}</h3>
                        <a href="/anime/${anime.slug}">Nonton Sekarang</a>
                    </div>
                `;
            });
        }
    } catch (error) {
        pesanDiv.innerHTML = "Waduh, koneksi ke otak AI terputus nih!";
    }
}

// 1. FUNGSI PINDAH TAB (PASTIKAN DIDEFINISIKAN PALING ATAS)
function switchStatus(status, btn) {
    // 1. Reset tombol
    document.querySelectorAll('.status-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const ongoing = document.getElementById('ongoing-content');
    const completed = document.getElementById('completed-content');
    const skeleton = document.getElementById('skeleton-content');

    // 2. Sembunyikan semua konten asli & Tampilkan Skeleton
    ongoing.style.display = 'none';
    completed.style.display = 'none';
    skeleton.style.display = 'grid';

    // 3. Gunakan timeout untuk mensimulasikan loading (0.6 detik)
    setTimeout(() => {
        // Sembunyikan skeleton
        skeleton.style.display = 'none';

        // Tampilkan konten yang dipilih
        if (status === 'ongoing') {
            ongoing.style.display = 'grid';
        } else {
            completed.style.display = 'grid';
        }
    }, 600); // 600 milidetik = 0.6 detik
}

// 2. INISIALISASI SWIPER (DIBETULKAN SINTAKS-NYA)
const swiper = new Swiper('.hero-swiper', {
    loop: true, 
    spaceBetween: 30, 
    effect: 'fade', 
    fadeEffect: {
        crossFade: true
    },
    autoplay: {
        delay: 5000, 
        disableOnInteraction: false, 
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true,
    },
    speed: 1000
});
if(document.getElementById('fetch-anime-button')) {
    document.getElementById('fetch-anime-button').addEventListener('click', () => {
        // Tampilkan SweetAlert2 "Mengambil Data..."
        Swal.fire({
            title: 'Mengambil Data Anime...',
            html: 'Mohon tunggu, sedang mengambil data anime...',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const timerInterval = setInterval(() => {
                    const elapsedTime = (new Date() - startTime) / 1000; 
                    const estimatedMinutes = Math.ceil(elapsedTime / 60);
                    Swal.getHtmlContainer().querySelector('strong').textContent = `Estimasi: sekitar ${estimatedMinutes} menit`; 
                }, 1000);

                fetch('Page/fetchAnimeData')
                    .then(response => response.json())
                    .then(data => {
                        clearInterval(timerInterval);
                        Swal.hideLoading();

                        // Debug: Log hasil data
                        console.log('Data Fetch Anime:', data);

                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: `${data.fetched} dari ${data.totalPages} anime berhasil diambil.` 
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat mengambil data.'
                            });

                            console.error('Error fetching anime data:', data.message);
                        }
                    })
                    .catch(error => {
                        clearInterval(timerInterval);
                        Swal.hideLoading();
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan koneksi.'
                        });

                        console.error('Error fetching anime data:', error);
                    });
            }
        });

        const startTime = new Date();
    });

}

const personalizedSwiper = new Swiper('.personalized-swiper', {
        slidesPerView: 2.2, // Tampilkan sedikit potongan di sisi layar HP
        spaceBetween: 20,
        navigation: {
            nextEl: '.ai-nav-next',
            prevEl: '.ai-nav-prev',
        },
        breakpoints: {
            640: { slidesPerView: 3.5, spaceBetween: 20 },
            1024: { slidesPerView: 4.5, spaceBetween: 25 },
            1440: { slidesPerView: 5.5, spaceBetween: 30 }
        }
    });

const popularWideSwiper = new Swiper('.popular-wide-swiper', {
        slidesPerView: 'auto', // PENTING: Untuk membiarkan CSS mengatur lebar
        centeredSlides: true,  // PENTING: Slide aktif berada di tengah
        spaceBetween: 20,      // Jarak antar slide
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        // Memberikan efek transisi sedikit mengecil pada slide yang tidak aktif
        on: {
            slideChangeTransitionStart: function () {
                $('.swiper-slide').css('opacity', '0.4');
                $('.swiper-slide-active').css('opacity', '1');
            },
        }
    });

    // Inisialisasi awal opacity
    document.querySelectorAll('.popular-wide-swiper .swiper-slide').forEach(s => s.style.opacity = '0.4');
    document.querySelector('.popular-wide-swiper .swiper-slide-active').style.opacity = '1';

</script>
  

<?= $this->endSection() ?>