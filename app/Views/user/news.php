<?= $this->extend('animesLayout/pageLayout') ?>

<?= $this->section('content') ?>
    <div class="section mb-5">
	<?php foreach ($news as $n) : ?>
        <?php 
        $slug = url_title($n['Judul'], '-', true); 
        ?>
        <div class="card-news">
            <div class="card-news-img-holder">
                <img src="<?= base_url('assets/imgPreview/' . $n['preview_gambar']); ?>" alt="Blog image">
            </div>
            <h3 class="blog-title" style="color: #FFFFFF"><?= $n['Judul'] ?></h3>
            <span class="blog-time" style="color: #ABABAB"><?= format_indo_date($n['waktu_penayangan']); ?></span>
            <p class="description" style="color: #DEDEDE">
                <?= $n['subJudul'] ?>
            </p>
            <div class="options">
                <span style="color: #FFFFFF">
                Read Full 
                </span>
                <a href="<?= route_to('newsDetail', $n['slug']); ?>"><button class="btn" id="btnNews">Lihat</button></a>
            </div>
        </div>
		<?php endforeach ?>
    </div>


<?= $this->endSection() ?>
