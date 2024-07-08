<?= $this->extend('animesLayout/pageLayout') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section mb-5">
    <h1><i class="fas fa-angle-double-right"></i> ANIMES</h1>
    <p>Genre : <strong><?= $genre['genre']; ?></strong></p>
    <br>
    <div class="img-box">
    <?php if (empty($animes)): ?>
        <p>Anime Dengan Genre : <strong><?= $genre['genre']; ?></strong> Tidak ditemukan</p>
    <?php else: ?>
        <?php foreach ($animes as $anime) : ?>
            <a href="<?= url_to('animeDetail', $anime['slug']); ?>" data-judul="<?= strtolower($anime['Judul']) ?>" class="animeCard">
                <img src="<?= base_url('assets/images/' . $anime['Poster']); ?>" alt="">
                <p><?= $anime['Judul'] ?></p>
            </a>
        <?php endforeach; ?>
        <!-- Tampilkan pagination jika ada anime yang ditemukan -->
    </div>
    <?= $pager->makeLinks($page, $perPage, $totalAnimes, 'anime_pagination') ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>