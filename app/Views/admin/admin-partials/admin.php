<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard - Daftar Anime Tayang</h1>
    </div>

    <!-- Content Row -->
    <a href="<?= url_to('tampilTambah'); ?>">
        <button type="button" class="btn btn-primary ml-3">Tambah Anime</button>
    </a>
    <input type="text" id="search-input" class="form-control ml-3 mt-3 col-6" placeholder="Cari anime...">
    <div id="search-results"></div>

    <div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
        <!-- Total Anime Tayang Card -->
            <div class="courses-container">
        <div class="course">
            <div class="course-preview">
                <!-- <h6>Wotakus</h6>
                <h2>Total Anime</h2> -->
                <!-- <a href="#">View all chapters <i class="fas fa-chevron-right"></i></a> -->
            </div>
            <div class="course-info">
                <div class="progress-container">
                    <!-- <div class="progress"></div>
                    <span class="progress-text">

                    </span> -->
                </div>
                <h6>Total</h6>
                <h2><?= esc($totalAnime) ?> Anime</h2>
                <!-- <button class="btn"></button> -->
            </div>
        </div>
    </div>
</div>



        <!-- Total Episode Seluruh Anime Card -->
        <div class="col-xl-6 col-md-6 mb-4">
        <!-- Total Anime Tayang Card -->
            <div class="courses-container">
        <div class="course">
            <div class="course-preview-2">
                <!-- <h6>Wotakus</h6>
                <h2>Total Anime</h2> -->
                <!-- <a href="#">View all chapters <i class="fas fa-chevron-right"></i></a> -->
            </div>
            <div class="course-info">
                <div class="progress-container">
                    <!-- <div class="progress"></div>
                    <span class="progress-text">
                       
                    </span> -->
                </div>
                <h6>Total Episode</h6>
                <h2><?= esc($totalEpisode) ?> Episode</h2>
                <!-- <button class="btn"></button> -->
            </div>
        </div>
    </div>
</div>
    </div>



    <div class="container-p">
        <div class="row">
            <?php foreach ($animes as $anime) : ?>
                <div class="card-p" data-judul="<?= strtolower($anime['Judul']) ?>">
                    <div class="content">
                        <div class="imgBx">
                            <img src="<?= base_url('assets/images/' . $anime['Poster']); ?>" alt="">
                        </div>
                        <div class="contentBx">
                            <h3><?= $anime['Judul'] ?><br>
                                <span><?= $anime['JudulLainnya'] ?></span><br>
                                <p><strong><?= $anime['statusTayang'] ?></strong></p>
                            </h3>
                        </div>
                    </div>
                    <ul class="sci">
                        <li>

                            <a href="<?= url_to('edit', $anime['slug']); ?>">
                                <button style="--color:#000000; --border:1px; --slant:.7em" class="buttonn" alt="edit">Edit</button>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url_to('viewDetail', $anime['slug']); ?>">
                                <button style="--color:#414141; --border:1px; --slant:.7em" class="buttonn">Lihat</button>
                            </a>
                        </li>
                        <li>
                            <a href="http://" target="_blank" rel="noopener noreferrer">
                            <button style="--color:#414141; --border:1px; --slant:.7em" class="buttonn delete-anime" data-title="<?= $anime['Judul']; ?>" data-slug="<?= $anime['slug']; ?>">Delete</button>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

 

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

	<script>
    $(document).ready(function() {
        // Flashdata handling with SweetAlert2 toast
        <?php if (session()->getFlashdata('pesan')) : ?>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            Toast.fire({
                icon: 'success',
                title: '<?= session()->getFlashdata('pesan'); ?>'
            });
        <?php endif; ?>
    });

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
            alert.style.transition = "opacity 0.5s ease-out"; // Tambah efek transisi
            alert.style.opacity = 0; // Mengubah opacity buat animasi fade out

            // Hapus elemen setelah transisi selesai
            setTimeout(function() {
                alert.remove();
            }, 500); // Durasi yang sama dengan transisi
        }
    }, 3000); // 3000 milidetik = 3 detik

    $(document).ready(function() {
    $(document).on('click', '.delete-anime', function(e) {
        e.preventDefault();
        const slug = $(this).data('slug');
        const title = $(this).data('title');
        const deleteUrl = "<?= url_to('delete', ''); ?>/" + slug;

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success swal2-confirm-margin",
                cancelButton: "btn btn-danger swal2-cancel-margin"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "Apakah Anda yakin?",
            html: "Data Judul Anime <strong>\"" + title + "\"</strong>.  ini tidak akan bisa dikembalikan !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Tidak, batalkan!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    method: 'POST',
                    data: {<?= csrf_token() ?>: '<?= csrf_hash() ?>'},
                    success: function(response) {
                        swalWithBootstrapButtons.fire({
                            title: "Dihapus!",
                            html: "Anime dengan Judul <strong>\"" + title + "\"</strong>  berhasil dihapus.",
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        swalWithBootstrapButtons.fire({
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat menghapus anime.",
                            icon: "error"
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Dibatalkan",
                    html: "Data Anime <strong>\"" + title + "\"</strong>. Tidak jadi dihapus :)",
                    icon: "error"
                });
            }
        });
    });
});
</script>
	<?= $this->endSection() ?>