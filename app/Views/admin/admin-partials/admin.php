<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Dashboard - Daftar Anime tayang</h1>
	</div>

	<!-- Content Row -->
	<a href="<?= url_to('tampilTambah');  ?>"><button type="button" class="btn btn-primary ml-3">Tambah Anime</button></a>
	<input type="text" id="search-input" class="form-control ml-3 mt-3 col-6" placeholder="Cari anime...">
    <div id="search-results"></div>
		<div class="container-p">
			<div class="row">
				<!-- Earnings (Monthly) Card Example -->
				<div class="col-xl-6 col-md-6 mb-4">
					<div class="card border-left-primary shadow h-100 w-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
										Total Anime Tayang</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><strong><?= esc($totalAnime) ?> Anime</strong></div>
								</div>
								<div class="col-auto">
									<!-- <i class="fas fa-calendar fa-2x text-gray-300"></i> -->
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Earnings (Monthly) Card Example -->
				<div class="col-xl-6 col-md-6 mb-4">
					<div class="card border-left-success shadow h-100 w-1 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
										Total Episode Seluruh Anime</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<strong><?= esc($totalEpisode) ?> Episode</strong></div>
								</div>
								<div class="col-auto">
									<!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
								</div>
							</div>
						</div>
					</div>
				</div>
				
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert" id="flash-alert">>
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>

<?php foreach ($animes as $anime) : ?>
    <div class="card-p" data-judul="<?= strtolower($anime['Judul']) ?>">
        <div class="content">
            <div class="imgBx">
                <img src="<?= base_url('assets/images/' . $anime['Poster']); ?>" alt="">
            </div>
            <div class="contentBx">
                <h3><?= $anime['Judul'] ?><br><span><?= $anime['JudulLainnya'] ?></span></h3>
            </div>
        </div>
                <ul class="sci">
            <li>
                <?php 
                $slug = url_title($anime['Judul'], '-', true); 
                ?>
                <button style="--color:#000000; --border:1px; --slant:.7em" class="buttonn" alt="edit">
                    <a href="<?= url_to('edit', $anime['id'], $slug); ?>">Edit</a>
                </button>
            </li>
            <li>
                <button style="--color:#414141; --border:1px; --slant:.7em" class="buttonn">
                    <a href="<?= url_to('viewDetail', $anime['id'], $slug); ?>">Lihat</a>
                </button>
            </li>
            <li>
                <button class="buttonn" style="--color:#414141; --border:1px; --slant:.7em" onclick="return confirm('apakah anda yakin?');">
                    <a href="<?= url_to('delete', $anime['id'], $slug); ?>">Hapus</a>
                </button>
            </li>
        </ul>
    </div>
<?php endforeach ?>
</div>
<!-- Content Row -->
</div>
<!-- Content Row -->
</div>

	<script>
	document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const cards = Array.from(document.getElementsByClassName('card-p'));

    searchInput.addEventListener('input', function() {
        const query = searchInput.value.trim().toLowerCase();

        if (query.length > 2) { // Minimal 3 Huruf buat search 
            cards.forEach(card => {
                const judul = card.getAttribute('data-judul');
                if (judul.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        } else {
            cards.forEach(card => {
                card.style.display = 'block';
            });
        }
    });
});

// Transisi Flash alert
setTimeout(function() {
        var alert = document.getElementById('flash-alert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease-out"; // Tambahkan efek transisi
            alert.style.opacity = 0; // Mengubah opacity untuk animasi fade out

            // Hapus elemen setelah transisi selesai
            setTimeout(function() {
                alert.remove();
            }, 500); // Durasi yang sama dengan transisi
        }
    }, 3000); // 3000 milidetik = 3 detik
</script>
	<?= $this->endSection() ?>