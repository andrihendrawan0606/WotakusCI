<?= $this->extend('animesLayout/pageLayout') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
.section-history {
    padding: 0 40px;
    padding-top: 70px;
}

.history-header {
    margin-bottom: 30px;
}

.history-header h1 {
    font-size: 1.5rem;
    font-weight: 800;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

/* Grid System */
.history-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
    gap: 20px;
}

/* Card Styling */
.history-card {
    display: flex;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(10px);
}

.history-card:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.08);
    border-color: var(--primary-color);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
}

/* Image Wrapper */
.history-img-wrapper {
    position: relative;
    width: 140px;
    height: 180px;
    flex-shrink: 0;
    overflow: hidden;
}

.history-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.history-card:hover .history-img {
    transform: scale(1.1);
}

.img-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: 0.3s;
    font-size: 2rem;
    color: #fff;
}

.history-card:hover .img-overlay {
    opacity: 1;
}

/* Content Area */
.history-info {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-width: 0; 
}

.anime-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 10px;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #ccc;
    font-size: 0.85rem;
}

.detail-item i {
    color: var(--primary-color);
    width: 15px;
}

.time-ago {
    color: #888;
}

/* Action Buttons */
.history-actions {
    margin-top: 15px;
}

.btn-history-play {
    display: inline-block;
    padding: 8px 20px;
    background: linear-gradient(45deg, #ff3300, #ff6600);
    color: #fff !important;
    border-radius: 50px;
    text-decoration: none !important;
    font-weight: 700;
    font-size: 0.85rem;
    box-shadow: 0 4px 15px rgba(255, 51, 0, 0.3);
    transition: 0.3s;
}

.btn-history-view {
    display: inline-block;
    padding: 8px 20px;
    background: rgba(255,255,255,0.1);
    color: #fff !important;
    border-radius: 50px;
    text-decoration: none !important;
    font-weight: 700;
    font-size: 0.85rem;
    transition: 0.3s;
}

.btn-history-play:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(255, 51, 0, 0.5);
}

.btn-history-view:hover {
    background: rgba(255,255,255,0.2);
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 100px 0;
    color: #666;
}

/* Responsive Mobile */
@media (max-width: 768px) {
    .section-history { padding: 0 15px; }
    .history-grid { grid-template-columns: 1fr; }
    .history-card { height: auto; }
}

@media (max-width: 480px) {
    .history-card { flex-direction: column; }
    .history-img-wrapper { width: 100%; height: 200px; }
    .history-info { text-align: center; }
    .detail-item { justify-content: center; }
}
</style>

<div class="section-history mb-5">
    <div class="history-header">
        <h1><i class="fas fa-history text-primary"></i> HISTORY ANIMES VIEWED</h1>
        <p class="text-muted">Lanjutkan petualangan anime Anda yang tertunda</p>
    </div>

    <div class="history-grid">
        <?php if (empty($recentAnime)): ?>
            <div class="empty-state">
                <i class="fas fa-ghost fa-4x mb-3"></i>
                <p>Belum ada riwayat tontonan. Mari mulai menonton!</p>
                <a href="<?= url_to('animes-home') ?>" class="btn-modern mt-3">Jelajahi Anime</a>
            </div>
        <?php else: ?>
            <?php foreach ($recentAnime as $anime): ?>
                <div class="history-card">
                    <?php 
                        $posterPath = $anime['Poster'];
                        $imgSrc = (filter_var($posterPath, FILTER_VALIDATE_URL)) ? $posterPath : base_url('assets/images/' . $posterPath);
                    ?>
                    
                    <div class="history-img-wrapper">
                        <img src="<?= esc($imgSrc); ?>" alt="<?= esc($anime['Judul']); ?>" class="history-img">
                        <div class="img-overlay">
                            <i class="fas fa-play-circle"></i>
                        </div>
                    </div>

                    <div class="history-info">
                        <h2 class="anime-title text-truncate" title="<?= esc($anime['Judul']); ?>"><?= esc($anime['Judul']); ?></h2>
                        <div class="watch-details">
                            <?php if (isset($anime['episode_id']) && !is_null($anime['episode_id'])): ?>
                                <div class="detail-item">
                                    <i class="fas fa-layer-group"></i>
                                    <span>Terakhir Episode : <b><?= esc($anime['episode_number']); ?> | <?= esc($anime['episode_title']); ?></b></span>
                                </div>
                                <div class="detail-item mt-1">
                                    <i class="far fa-clock"></i>
                                    <span class="time-ago"><?= timeAgo($anime['updated_at']); ?></span>
                                </div>
                            <?php else: ?>
                                <p class="text-muted small italic">Belum ada episode yang ditonton.</p>
                            <?php endif; ?>
                        </div>

                        <div class="history-actions">
                            <?php if (isset($anime['episode_id']) && !is_null($anime['episode_id'])): ?>
                                <a href="/anime/<?= esc($anime['slug']); ?>/<?= esc($anime['episode_slug']); ?>" class="btn-history-play">
                                    <i class="fas fa-play"></i> Tonton Kembali
                                </a>
                            <?php else: ?>
                                <a href="<?= url_to('animeDetail', $anime['slug']); ?>" class="btn-history-view">
                                    <i class="fas fa-info-circle"></i> Lihat Anime
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

