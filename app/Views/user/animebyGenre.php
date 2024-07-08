<?= $this->extend('animesLayout/pageLayout') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
        <section id="genre-section">
            <h2>Genres</h2>
            <div class="genre-container">
            <?php foreach ($genres as $genre): ?>
                <a id="genre-link" href="<?= url_to('animesbyGenre', $genre['slug_genre']); ?>"><div class="genre-item"><?= $genre['genre']; ?></div></a>
                <?php endforeach; ?>
            </div>
        </section>
<?= $this->endSection() ?>
