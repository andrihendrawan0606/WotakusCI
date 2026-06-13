<?= $this->extend('animesLayout/pageLayout') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<style>
    
</style>

<?= $this->section('content') ?>

<div class="section mb-5">
    <div class="section-title-container mb-4">
        <h1><i class="fad fa-chevron-double-right"></i> ANIMES</h1>
        <p class="text-muted">Genre : <span class="badge-genre-title"><?= $genre['genre']; ?></span></p>
    </div>

    <?php if (empty($animes)): ?>
        <div class="text-center py-5">
            <i class="fas fa-search-minus fa-4x text-muted mb-3"></i>
            <p class="h5 text-muted">Anime dengan genre <strong><?= $genre['genre']; ?></strong> tidak ditemukan.</p>
            <a href="<?= url_to('animes-home') ?>" class="btn btn-primary rounded-pill mt-3">Kembali ke Beranda</a>
        </div>
    <?php else: ?>
        <div class="img-box">
            <?php foreach ($animes as $anime) : ?>
                <a href="<?= url_to('animeDetail', $anime['slug']) ?>" class="animeCard">
                    <div class="poster-wrapper">
                        <?php if (isset($anime['status']) && $anime['status'] === 'Completed') : ?>
                            <div class="completed-label">Completed</div>
                        <?php endif; ?>

                        <?php 
                        $posterPath = $anime['Poster'];
                        $imgSrc = (filter_var($posterPath, FILTER_VALIDATE_URL)) ? $posterPath : base_url('assets/images/' . $posterPath);
                        ?>
                        
                        <img src="<?= $imgSrc; ?>" alt="Poster <?= $anime['Judul'] ?>" class="poster">
                        
                        <!-- Overlay & Type -->
                        <div class="card-overlay">
                            <div class="play-icon"><i class="fas fa-play"></i></div>
                        </div>
                    </div>
                    <div class="anime-info">
                        <p class="anime-title"><?= $anime['Judul'] ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper mt-5">
            <?= $pager->makeLinks($page, $perPage, $totalAnimes, 'anime_pagination') ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>