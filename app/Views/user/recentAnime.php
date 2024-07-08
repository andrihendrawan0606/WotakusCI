<?= $this->extend('animesLayout/pageLayout') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section mb-5">
        <h1><i class="fas fa-angle-double-right"></i> RECENT ANIMES VIEWED</h1>
        <div class="img-box">
        <?php if (empty($recentAnime)): ?>
            <p>No recent anime viewed.</p>
        <?php else: ?>
            <?php foreach ($recentAnime as $anime) : ?>
                <a href="<?= url_to('animeDetail', $anime['slug']); ?>">
                    <img src="<?= base_url('assets/images/' . $anime['Poster']); ?>" alt="">
                    <p><?= $anime['Judul'] ?></p>
                </a>
            <?php endforeach ?>
        <?php endif; ?>
        </div>
        
    </div>
	
<?= $this->endSection() ?>