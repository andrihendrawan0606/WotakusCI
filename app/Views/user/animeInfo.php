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
        <p><?= $anime['Desc']?></p>

        <div class="genre">
            <ul>
            <?php if (isset($anime['genre'])): ?>
                <?php foreach ($anime ['genre'] as $genre) : ?>
                <li><a href="#"><?= esc($genre) ?></a></li>
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
                        <p>Episode Kosong</p>
                    <?php endif; ?>
                    <?php if (isset($anime['Durasi'])): ?>
                        <li><img src="<?=base_url('assets/images/clock.png');?>"><?= $anime['Durasi'] ?> min.</li>
                    <?php else: ?>
                        <p>Durasi Kosong</p>
                    <?php endif; ?>
                    <?php if (isset($anime['Rilis'])): ?>
                        <li><img src="<?=base_url('assets/images/calendar.png');?>"><?= format_indo_date($anime['Rilis']); ?>
                        </li>
                    <?php else: ?>
                        <p>Belum ada Tanggal Rilis</p>
                    <?php endif; ?>
                    <?php if (isset($anime['status'])): ?>
                        <li><img src="<?=base_url('assets/images/hourglass-end.png');?>"><?=$anime['status'] ?></li>
                    <?php else: ?>
                        <p>Belum ada Status</p>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="sekuel">
                <h2>Seri Lainnya</h2>
                <ul>
                    <li><img src="<?=base_url('assets/images/arrow-link.png');?>"><a href="#">Coming soon</a></li>
                    <li><img src="<?=base_url('assets/images/arrow-link.png');?>"><a href="#">Coming soon ( presequel )</a></li>
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
        </div>
    </div>
</div>

<!--    Episode    -->


<div class="episode">
    <h1><i class="fas fa-angle-double-right"></i> EPISODE</h1>
    <div class="grid-episode">
            <?php if (isset($episode) && is_array($episode) && !empty($episode)) : ?>
            <?php foreach ($episode as $anime) : ?>
                <?php 
                $slug = url_title($anime['judul'], '-', true); 
                ?>
                <a href="<?= url_to('showPreviewVideo', $anime['id'], $slug); ?>" class="anime-section">
                    <div class="anime-img-1" style="background-image: url(<?= base_url('assets/imgPreview/' . $anime['GambarPreview']); ?>);" ></div>
                    <div class="anime-description">
                        <h2><?= $anime['judul'] ?> | <?= $anime['deskripsi'] ?></h2>
                    </div>
                </a>
            <?php endforeach ?>
        <?php else : ?>
            <p>Belum ada Episode yang tayang</p>
        <?php endif ?>
    </div>
</div>
<br>
<?= $this->endSection() ?>