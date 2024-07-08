<?= $this->extend('admin/admin-partials/index') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="row">
    <img class="card" src="<?=base_url('assets/images/'.$animes['Poster']);?>" alt="Poster-Anime">
    <div class="col-6">
        <form>
            <div class="mb-3 ml-3">
                <label for="InputJudul" class="form-label">Judul</label>
                <input type="email" class="form-control border-left-primary" disabled="disabled" id="exampleInputEmail1"
                    value="<?= $animes['Judul'] ?>" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text"></div>
            </div>
            <div class="mb-3 ml-3">
                <label for="InputDesc" class="form-label">Desc</label>
                <div class="form-control border-left-primary" style="height: 100%; background-color: #e9ecef;" disabled
                    aria-label="With textarea"><?= $animes['Desc'] ?></div>
            </div>
            <div class="mb-3 ml-3">
                <label for="InputEps" class="form-label">Total Episode</label>
                <input type="text" disabled="disabled" value="<?= $animes['Eps'] ?> Episode" class="form-control border-left-primary"
                    id="exampleInputPassword1">
            </div>
            <div class="mb-3 ml-3">
                <label for="InputDurasi" class="form-label">Durasi</label>
                <input type="text" disabled="disabled" value="<?= $animes['Durasi'] ?> Menit" class="form-control border-left-primary"
                    id="exampleInputPassword1">
            </div>
            <div class="mb-3 ml-3">
                <label for="InputRilis" class="form-label">Rilis</label>
                <input type="text" disabled="disabled" value="<?= format_indo_date($animes['Rilis']); ?>"
                    class="form-control border-left-primary" id="exampleInputPassword1">
            </div>
            <div class="mb-3 ml-3">
                <label for="InputJudulLainnya" class="form-label">Judul Lainnya</label>
                <input type="text" disabled="disabled" value="<?= $animes['JudulLainnya'] ?>" class="form-control border-left-primary"
                    id="exampleInputPassword1">
            </div>
            <div class="mb-3 ml-3">
                <label for="InputGenre" class="form-label">Genre</label>
                <input type="text" disabled="disabled" value="<?= $animes['genre'] ?> " class="form-control border-left-primary"
                    id="exampleInputPassword1">
            </div>
            <div class="mb-3 ml-3">
                <label for="SelectionGenre" class="form-label">Seri Lainnya</label>
                <?php if (isset($animes['relatedAnime'])): ?>
                <input type="text" disabled="disabled" value="<?= $animes['relatedAnime'] ?>" class="form-control border-left-primary"
                    id="exampleInputPassword1">
                <?php else: ?>
                    <input type="text" disabled="disabled" value="Belum ada Seri Lainnya" placeholder="" class="form-control border-left-primary"
                    id="exampleInputPassword1">
                <?php endif; ?>
            </div>
            <div class="mb-3 ml-3">
                <label for="SelectionGenre" class="form-label">Tipe Anime</label>
                <input type="text" disabled="disabled" value="<?= $animes['typeAnime'] ?>" class="form-control border-left-primary"
                    id="exampleInputPassword1">
            </div>
            <div class="mb-3 ml-3">
                <label for="SelectionGenre" class="form-label">Status</label>
                <input type="text" disabled="disabled" value="<?= $animes['status'] ?>" class="form-control border-left-primary"
                    id="exampleInputPassword1">
            </div>
            <div class="mb-3 ml-3">
                <label for="SelectionGenre" class="form-label">Status Tayang</label>
                <input type="text" disabled="disabled" value="<?= $animes['statusTayang'] ?>" class="form-control border-left-primary"
                    id="exampleInputPassword1">
            </div>
            <a href="<?= url_to('dashboard') ?>"><button type="button" class="btn btn-danger  ml-3">Kembali</button></a>
        </form>

    </div>
</div>


<div class="row mt-5">
    <div class="col-10 ml-5">
        <div class="card-body">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Total Episode : <?= esc($totalEpisode) ?> </h6>

                    <a href="<?= url_to('createEpisode',  $animes['slug']); ?>">
                        <button type="button" class="btn btn-primary mt-2">Tambah Episode</button>
                    </a>
            </div>


    <div class="table-responsive">
            <table class="table center-table table-striped" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;">Nama Anime</th>
                        <th style="text-align: center;">Episode</th>
                        <th style="text-align: center;">Deskripsi Episode</th>
                        <th style="text-align: center;">Views</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    $(document).ready(function() {
        // Flashdata handling dengan SweetAlert2 toast
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

    $(document).ready(function() {
    var basePath = window.location.origin + '/assets/';
    var slug = "<?= $animes['slug'] ?>";  

    $('#dataTable').DataTable({
        ajax: {
            url: '/dashboard/detail/' + slug,
            dataSrc: ''
        },
        columns: [
            { data: 'Judul' , render: function(data, type, row) {
                return `<span class="" style="">${data}</span>`;
            }},
            { data: 'episode_number', render: function(data, type, row) {
                return `<span type="button" class="btn btn-dark">${data}</span>`;
            }},
            { data: 'deskripsi' , width: '400px',  render: function(data, type, row) {
                return `<span class="desc fw-light">${data}</span>`;
            }},
            { data: 'view_count', render: function(data, type, row) { return data + ' Views'; } },
            { data: null, render: function(data, type, row) {
                return `
                    <button type="button" class="btn btn-warning edit-episode" data-id="${row.id}" data-title="${row.judul}" data-desc="${row.deskripsi}" data-episode="${row.episode_number}" data-gambar="${basePath}imgPreview/${row.GambarPreview}" data-video="${row.video_path ? basePath + 'videos/' + row.video_path : ''}"><i class="fal fa-edit"></i></button>
                    <button type="button" class="btn btn-danger delete-episode" data-id="${row.id}"><i class="fal fa-trash-alt"></i></button>
                `;
            }}
        ],
        dom: '<"top"iBfl>rt<"bottom"p><"clear">',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ entri per halaman",
            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            emptyTable: "Belum ada Episode pada Anime ini"
        }
    });

    $(document).on('click', '.delete-episode', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan data pada Episode ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/dashboard/HapusEpisode/' + id,
                    type: 'GET',
                    success: function(response) {
                        Swal.fire(
                            'Terhapus!',
                            'Episode telah dihapus.',
                            'success'
                        ).then(() => {
                            $('#dataTable').DataTable().ajax.reload();
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus episode.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $(document).on('click', '.edit-episode', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        const desc = $(this).data('desc');
        const episodeNumber = $(this).data('episode');
        const gambar = $(this).data('gambar');
        const video = $(this).data('video');

        Swal.fire({
            title: 'Edit Episode',
            html: `
                <form id="editEpisodeForm" action="<?= url_to('updateEpisode'); ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" value="${id}">
                    <input type="hidden" name="old_video_path" value="${video}">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul">Judul</label>
                                    <input type="text" name="judul" class="form-control" id="judul" value="${title}" required>
                                </div>
                                <div class="form-group">
                                    <label for="Deskripsi">Deskripsi</label>
                                    <textarea name="Deskripsi" class="form-control" style="height: 130px;" id="Deskripsi" required>${desc}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="episodeNumber">Episode Ke Berapa</label>
                                    <input type="number" name="episodeNumber" class="form-control" id="episodeNumber" value="${episodeNumber}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gambarPreview">Gambar Preview Episode</label>
                                    <input type="file" name="gambarPreview" id="gambarPreview" class="form-control-file" onchange="GambarPreview()">
                                    <img src="${gambar}" class="img-thumbnail mt-2" id="img-preview-episode" style="width: 100%; border-radius: 20px;">
                                </div>
                                <div class="form-group mt-4">
                                    <label for="video_path">Video Preview Episode <strong>* Maks 100MB Format mp4,avi,mkv </strong></label>
                                    <div id="drop-zone" class="drop-zone ${video ? 'hide' : ''}">Drag & Drop Video Episode Disini</div>
                                    <input type="file" name="video_path" id="video_path" accept="video/*" class="form-control-file" style="display: none;" onchange="displayFileDetails()">
                                    <div id="loading-bar" style="display: none; margin-top: 10px;">
                                        <progress id="progress-bar" class="custom-progress" value="0" max="100" style="width: 100%;"></progress>
                                    </div>
                                    <div id="video-container" class="video-container" style="display: ${video ? 'block' : 'none'};">
                                        <div class="video-frame">
                                            <button type="button" class="remove-video" onclick="removeVideo()"><i class="fal fa-times"></i></button>
                                            <video id="video-preview" class="mt-2" width="100%" height="auto" controls style="display: ${video ? 'block' : 'none'};">
                                                <source id="video-source" src="${video}" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                </form>
            `,
        showCancelButton: true,
        showConfirmButton: false,
        cancelButtonText: 'Tutup',
        width: '60%',
        didOpen: () => {
            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('video_path');
            if (!video) {
                dropZone.classList.remove('hide');
            }
            dropZone.addEventListener('click', () => fileInput.click());
            dropZone.addEventListener('dragover', (event) => {
                event.preventDefault();
                dropZone.classList.add('dragover');
            });
            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('dragover');
            });
            dropZone.addEventListener('drop', (event) => {
                event.preventDefault();
                dropZone.classList.remove('dragover');
                fileInput.files = event.dataTransfer.files;
                displayFileDetails();
            });
        }
    });

    $(document).on('submit', '#editEpisodeForm', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Mengunggah...',
            text: 'Silakan tunggu beberapa saat video sedang diunggah.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.close();
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Episode berhasil diupdate.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengupdate episode.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});

    function GambarPreview() {
        const GambarPreview = document.querySelector('#gambarPreview');
        const GambarPreviewLabel = document.querySelector('#gambarPreview').nextElementSibling;
        const GambarPreviewPreview = document.querySelector('#img-preview-episode');

        GambarPreviewLabel.textContent = GambarPreview.files[0].name;

        const fileGambarPreview = new FileReader();
        fileGambarPreview.readAsDataURL(GambarPreview.files[0]);

        fileGambarPreview.onload = function(e) {
            GambarPreviewPreview.src = e.target.result;
        }
    }

    function displayFileDetails() {
        const fileInput = document.getElementById('video_path');
        const videoContainer = document.getElementById('video-container');
        const videoPreview = document.getElementById('video-preview');
        const videoSource = document.getElementById('video-source');
        const dropZone = document.getElementById('drop-zone');
        const loadingBar = document.getElementById('loading-bar');
        const progressBar = document.getElementById('progress-bar');

        const file = fileInput.files[0];

        if (file) {
            // Hide drop zone
            dropZone.classList.add('hide');
            
            // Show loading bar
            loadingBar.style.display = 'block';
            videoPreview.style.display = 'none';

            const reader = new FileReader();

            reader.onloadstart = () => {
                progressBar.value = 0;
            };

            reader.onprogress = (e) => {
                if (e.lengthComputable) {
                    const percentLoaded = Math.round((e.loaded / e.total) * 100);
                    progressBar.value = percentLoaded;
                }
            };

            reader.onload = () => {
                // Hide loading bar
                loadingBar.style.display = 'none';

                // Update video source and type
                videoSource.src = reader.result;
                videoSource.type = file.type;
                videoPreview.load();
                videoPreview.style.display = 'block';
                videoContainer.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    }

    function removeVideo() {
                const videoPreview = document.getElementById('video-preview');
                const videoSource = document.getElementById('video-source');
                const fileInput = document.getElementById('video_path');
                const loadingBar = document.getElementById('loading-bar');

                fileInput.value = '';  // Reset the input value to remove the selected file
                videoSource.src = '';  // Remove the video source
                videoPreview.style.display = 'none';  // Hide the video preview
                loadingBar.style.display = 'none';  // Hide the loading bar
            }
    });
</script>

















<?= $this->endSection() ?>