<?= $this->extend('animesLayout/pageLayout') ?>

<?= $this->section('content') ?>

<div class="section mb-5">
<div class="news">
    <div class="imgNews">
        <img src="<?= base_url('assets/imgPreview/' . $news['preview_gambar']); ?>" alt="">
    </div>

    <div><?= $news['isiKonten'] ?></div>
    </div>
</div>

<script>

</script>

<?= $this->endSection() ?>
