<?= $this->extend('admin/admin-partials/index') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-5">
        <form id="episode-form" action="<?= url_to('prosesEpisode'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-icon text-center mb-4">
                <span><i class="icon icon-user"></i></span>
            </div>
            <input type="hidden" name="anime_id" value="<?= $animeId['id'] ?>">
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" name="judul" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="judul" placeholder="Judul" value="<?= old('judul'); ?>" autofocus>
                <div class="invalid-feedback">
                    <?= $validation->getError('judul') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="Desc">Deskripsi</label>
                <textarea name="Deskripsi" class="form-control <?= ($validation->hasError('Deskripsi')) ? 'is-invalid' : ''; ?>" id="Desc" placeholder="Deskripsi"><?= old('Deskripsi'); ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('Deskripsi') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="episodeNumber">Episode Ke Berapa</label>
                <input type="number" name="episodeNumber" class="form-control <?= ($validation->hasError('episodeNumber')) ? 'is-invalid' : ''; ?>" id="episodeNumber" placeholder="Episode Number" value="<?= old('episodeNumber'); ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('episodeNumber') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="gambarPreview">Gambar Preview Episode</label>
                <input type="file" name="gambarPreview" id="gambarPreview" class="form-control-file <?= ($validation->hasError('gambarPreview')) ? 'is-invalid' : ''; ?>" onchange="GambarPreview()">
                <div class="invalid-feedback">
                    <?= $validation->getError('gambarPreview') ?>
                </div>
                <img src="/assets/images/default.jpg" class="img-thumbnail mt-2" id="img-preview-episode" style="width: 30em; border-radius: 20px;">
            </div>
            <div class="form-group mt-4">
                <label for="video_path">Video Preview Episode <strong>* Maks 100MB Format mp4, avi, mkv </strong></label>
                <div id="drop-zone" class="drop-zone">Drag & Drop Video Episode Disini</div>
                <input type="file" name="video_path" id="video_path" accept="video/*" class="form-control-file <?= ($validation->hasError('video_path')) ? 'is-invalid' : ''; ?>" style="display: none;" onchange="displayFileDetails()">
                <div class="invalid-feedback">
                    <?= $validation->getError('video_path') ?>
                </div>
                <div id="loading-bar" style="display: none; margin-top: 10px;">
                    <progress id="progress-bar" class="custom-progress" value="0" max="100" style="width: 100%;"></progress>
                </div>
                <div id="video-container" class="video-container hide">
                    <div class="video-frame">
                        <button type="button" class="remove-video" onclick="removeVideo()"><i class="fal fa-times"></i></button>
                        <video id="video-preview" class="mt-2" width="100%" height="auto" controls style="display: none;">
                            <source id="video-source" src="" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
            <div class="form-group mt-5">
                <button type="submit" class="btn btn-primary btn-block">Tambah</button>
            </div>
            <div class="form-group">
                <a href="<?= url_to('viewDetail',  $animeId['slug']); ?>" class="btn btn-danger btn-block">Kembali</a>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
    $(document).ready(function() {
            $('#episode-form').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Mengunggah...',
                    html: '<div id="swal-progress-bar" class="progress"><div id="swal-progress" class="progress-bar" style="width: 0%;">0%</div></div>',
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
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $('#swal-progress').css('width', percentComplete + '%').text(percentComplete + '%');
                                if (percentComplete === 100) {
                                    Swal.update({
                                        title: 'Memproses data...',
                                        html: 'Harap tunggu bentaran...',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                }
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        Swal.close();
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Episode berhasil ditambahkan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?= url_to('viewDetail', $animeId['slug']) ?>';
                            }
                        });
                    },
                    error: function(response) {
                        Swal.close();
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menambahkan episode.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });


        function displayFileDetails() {
            const fileInput = document.getElementById('video_path');
            const videoPreview = document.getElementById('video-preview');
            const videoSource = document.getElementById('video-source');
            const loadingBar = document.getElementById('loading-bar');

            const file = fileInput.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                videoSource.src = url;
                videoPreview.style.display = 'block';
                loadingBar.style.display = 'block';
            } else {
                videoSource.src = '';
                videoPreview.style.display = 'none';
                loadingBar.style.display = 'none';
            }
        }

        function removeVideo() {
            const videoPreview = document.getElementById('video-preview');
            const videoSource = document.getElementById('video-source');
            const fileInput = document.getElementById('video_path');
            const loadingBar = document.getElementById('loading-bar');

            fileInput.value = '';
            videoSource.src = '';
            videoPreview.style.display = 'none';
            loadingBar.style.display = 'none';
        }
    </script>

<?= $this->endSection() ?>