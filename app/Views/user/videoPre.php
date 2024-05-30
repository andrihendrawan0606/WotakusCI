<?= $this->extend('user/pageLayoutInfo') ?>

<?= $this->section('Judul') ?>
<?= $title ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<!--    VIDEO    -->
<section class="video">
    <h1><a href="#"></a> Preview <?= $episode['judul'] ?></h1>
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
            <li><a href="#"><img src="<?=base_url('assets/images/before-arrow.png');?>"> Episode Sebelumnya</a></li>
            <li><a href="#">Episode Selanjutnya <img src="<?=base_url('assets/images/next-arrow.png');?>"></a></li>
        </ul>
    </div>
</section>

<script>

</script>

<?= $this->endSection() ?>
