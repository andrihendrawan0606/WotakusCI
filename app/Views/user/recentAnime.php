<?= $this->extend('animesLayout/pageLayout') ?>

<?= $this->section('content') ?>
<div class="section">
        <h1><i class="fas fa-angle-double-right"></i> RECENT ANIMES VIEWED</h1>
        <div class="img-box">
        <?php if (empty($recentAnime)): ?>
        <p>No recent anime viewed.</p>
         <?php else: ?>
        <?php foreach ($recentAnime  as $anime) : ?>
            <?php $slug = url_title($anime['Judul'], '-', true); ?>
            <a href='/animesHome/animeinfo/<?= $anime['id']; ?>/<?= $slug; ?>'><img src="<?=base_url('assets/images/'.$anime['Poster']);?>" alt=""><p><?= $anime['Judul'] ?></p></a>

        <?php endforeach ?>
        <?php endif; ?>
        </div>
        <div class="pagination">
            <ul>
        
                <li class="btn prev"><span><i class="fas fa-angle-left"></i> Prev</span></li>
                <li class="numb active"><span>1</span></li>
                <li class="numb"><span>2</span></li>
                <li class="dots"><span>...</span></li>
                <li class="numb"><span>4</span></li>
                <li class="numb"><span>5</span></li>
                <li class="dots"><span>...</span></li>
                <li class="numb"><span>7</span></li>
                <li class="btn next"><span>Next <i class="fas fa-angle-right"></i></span></li>
            </ul>
        </div>
    </div>
	
<?= $this->endSection() ?>