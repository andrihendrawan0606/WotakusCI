<?= $this->extend('animesLayout/pageLayout') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="section mb-5">
    <h1><i class="fad fa-chevron-double-right"></i>  ANIMES</h1>

    <div class="img-box">
        <?php foreach ($animes as $anime) : ?>
        <a href="<?= url_to('animeDetail', $anime['slug']) ?>" data-judul="<?= strtolower($anime['Judul']) ?>" class="animeCard">
            <img src="<?= base_url('assets/images/' . $anime['Poster']); ?>" alt="">
            <p><?= $anime['Judul'] ?></p>
        </a>
    <?php endforeach ?>
    </div>
    <?= $pager->links('animes', 'anime_pagination'); ?>
</div>

<?= $this->endSection() ?>