<?= $this->extend('animesLayout/pageLayout') ?>

<?= $this->section('content') ?>
<div class="section mb-5">
    <h1><i class="fas fa-angle-double-right"></i> ANIMES</h1>
    <h1>Genre : <?= $genre['genre']; ?></h1>
    <div class="img-box">
    <?php if (empty($animes)): ?>
        <p>Anime Dengan Genre : <strong><?= $genre['genre']; ?></strong> Tidak ditemukan</p>
    <?php else: ?>
        <?php foreach ($animes as $anime) : ?>
        <?php 
        $slug = url_title($anime['Judul'], '-', true); 
        ?>
        <a href="<?= url_to('animeDetail', $anime['id'], $slug); ?>" data-judul="<?= strtolower($anime['Judul']) ?>" class="animeCard">
            <img src="<?= base_url('assets/images/' . $anime['Poster']); ?>" alt="">
            <p><?= $anime['Judul'] ?></p>
        </a>
    <?php endforeach ?>
    <?php endif; ?>
    </div>

</div>

<?= $this->endSection() ?>