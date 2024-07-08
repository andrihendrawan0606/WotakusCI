<?= $this->extend('user/pageLayoutInfo') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!--    ANIME INFO    -->
<div class="container" id="body">
    <div class="img-depan">
        <?php if (isset($anime['Poster'])): ?>
            <img src="<?= base_url('assets/images/' . $anime['Poster']) ?>">
        <?php else: ?>
            <p>Poster tidak tersedia</p>
        <?php endif; ?>
        <a href="https://youtu.be/f7R6NA4Yo00?si=6RFLWw3p7xT3gE59" target="_blank">
            <h1>TRAILER</h1>
            <img src="<?=base_url('assets/images/play-button.png');?>">
        </a>
    </div>

    <div class="info">
        <h1><?= $anime['Judul'] ?></h1>
    <p>
        <?= $anime['Desc'] ?>
    </p>
        <div class="genre">
            <ul>
            <?php if (isset($anime['genre'])): ?>
                <?php foreach ($anime ['genre'] as $genre) : ?>
                <li><a href="<?= url_to('animesbyGenre', $genre['slug_genre']); ?>"><?= esc($genre['genre']) ?></a></li>
                <?php endforeach ?>
                <?php else: ?>
                    <p>Genre Kosong</p>
                <?php endif; ?>
            </ul>
        </div>
        <div class="infoBox">
            <div class="adicional">
                <h2>INFO</h2>
                <ul>
                    <?php if (isset($anime['Eps'])): ?>
                        <li><img src="<?=base_url('assets/images/gallery.png');?>"><?= $anime['Eps'] ?> Episode</li>
                    <?php else: ?>
                        <p>Belum tau total episode</p>
                    <?php endif; ?>
                    <?php if (isset($anime['Durasi'])): ?>
                        <li><img src="<?=base_url('assets/images/clock.png');?>"><?= $anime['Durasi'] ?> min.</li>
                    <?php else: ?>
                        <p>Durasi Kosong / Durasi beda beda</p>
                    <?php endif; ?>
                    <?php if (isset($anime['Rilis'])): ?>
                        <li><img src="<?=base_url('assets/images/calendar.png');?>"><?= format_indo_date($anime['Rilis']); ?>
                        </li>
                    <?php else: ?>
                        <p>Tanggal Rilis Belum di tambahkan</p>
                    <?php endif; ?>
                    <?php if (isset($anime['status'])): ?>
                        <li><img src="<?=base_url('assets/images/hourglass-end.png');?>"><?=$anime['status'] ?></li>
                    <?php else: ?>
                        <p>Status belum ditambahkan</p>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="sekuel">
                <h2>Seri Lainnya</h2>
                <ul>
                    <?php if (!empty($relatedAnime)) : ?>
                        <?php foreach ($relatedAnime as $related) : ?>
                            <li>
                                <img src="<?= base_url('assets/images/arrow-link.png'); ?>">
                                <a href="<?= route_to('animeDetail',  $related['slug'])?>">
                                    <?= $related['Judul']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li>Belum ada seri lainnya</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="title-alternative">
                <h2>Judul Lainnya</h2>
                <ul>
                    <?php if (isset($anime['JudulLainnya'])): ?>
                    <li><img src="<?=base_url('assets/images/japan.png');?>"><?= $anime['JudulLainnya'] ?></li>
                    <?php else: ?>
                    <p>JudulLainnya Kosong</p>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="type-anime" style="margin-top: 0;">
                <h2>Type Anime</h2>
                <ul>
                    <?php if (isset($anime['tipeAnime'])): ?>
                    <li><?= $anime['tipeAnime'] ?></li>
                    <?php else: ?>
                    <li>Tipe Anime belum ditentukan</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<!--    Episode    -->
<div class="episode" style="margin-top: 5%;">
    <h1><i class="fad fa-chevron-double-right"></i> EPISODE</h1>
    <div class="grid-episode">
            <?php if (isset($episode) && is_array($episode) && !empty($episode)) : ?>
            <?php foreach ($episode as $animeEpisode) : ?>
                <a href="<?= url_to('showPreviewVideo', $anime['slug'], $animeEpisode['slug-episode']); ?>" class="anime-section">
                    <div class="anime-img-1" style="background-image: url(<?= base_url('assets/imgPreview/' . $animeEpisode['GambarPreview']); ?>);" ></div>
                    <div class="anime-description">
                        <h2><?= $animeEpisode['Judul'] ?> | <?= $animeEpisode['judul'] ?></h2>
                    </div>
                </a>
            <?php endforeach ?>
                <?php else : ?>
                    <p>Belum ada Episode yang tayang</p>
                <?php endif ?>
        </div>
    </div>
<br>

<!--    Rekomendasi Anime    -->
<div class="episode">
    <h1><i class="fad fa-chevron-double-right"></i> REKOMENDASI ANIME LAINNYA</h1>
    <br>
    <div class="grid-episode">
        <?php if (isset($recommendedAnime) && is_array($recommendedAnime) && !empty($recommendedAnime)) : ?>
            <?php foreach ($recommendedAnime as $recommend) : ?>
                <a href="<?= url_to('animeDetail', $recommend['slug']); ?>" class="anime-section">
                <div class="article-card">
                        <div class="content">
                            <p class="date"><?= format_indo_date($recommend['Rilis']); ?></p>
                            <p class="title"><?= esc($recommend['Judul']) ?></p>
                        </div>
                        <img src="<?= base_url('assets/images/' . $recommend['Poster']); ?>" alt="article-cover">
                    </div>
                </a>

            <?php endforeach ?>
        <?php else : ?>
            <p>Tidak ada rekomendasi anime untuk saat ini</p>
        <?php endif ?>
    </div>
</div>



<?= $this->endSection() ?>