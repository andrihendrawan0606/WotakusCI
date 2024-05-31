<?= $this->extend('user/pageLayoutInfo') ?>

<?= $this->section('Judul') ?>
<?= $title ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<!--    VIDEO    -->
<section class="video">
    <h1>Preview <?= $episode['judul'] ?></h1>
    <div class="box">
        <?php if ($episode['video_path']): ?>
        <video id="video-player" data-episode-id="<?= $episode['id'] ?>" height="550" controls>
            <source src="<?= base_url('assets/videos/' . $episode['video_path']) ?>" type="video/mp4">
        </video>
        <?php else: ?>
        <h2>Video tidak tersedia.</h2>
        <?php endif; ?>
    </div>
    <div class="ab">
        <ul>
            <?php if ($EpisodeSebelumnya): ?>
            <li>
                <a href="<?= url_to('showPreviewVideo', $EpisodeSebelumnya['id'], url_title($EpisodeSebelumnya['judul'], '-', true)); ?>">
                    <img src="<?= base_url('assets/images/before-arrow.png'); ?>"> Episode Sebelumnya
                </a>
            </li>
            <?php endif; ?>
            <?php if ($EpisodeSelanjutnya): ?>
            <li>
                <a href="<?= url_to('showPreviewVideo', $EpisodeSelanjutnya['id'], url_title($EpisodeSelanjutnya['judul'], '-', true)); ?>">
                    Episode Selanjutnya <img src="<?= base_url('assets/images/next-arrow.png'); ?>">
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</section>

<script>

</script>

<?= $this->endSection() ?>
