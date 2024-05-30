<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard <?= $this->renderSection('Judul') ?> </title>
    <!-- Custom fonts for this template-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link rel="shortcut icon" href="https://cdn3.emoji.gg/emojis/6903-gojode.png" />
    <link href="<?= base_url() ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/cardTayang.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/cardAdminDetail.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/tambahAnime.css') ?>" rel="stylesheet">

    <style>
        #choices-multiple-remove-button {
            margin-top: 100px
        }

        .buttonn {
            --border: 5px;
            /* the border width */
            --slant: 0.7em;
            /* control the slanted corners */
            --color: #FFFFFF;
            /* the color */

            font-size: 1em;
            padding: 0.1em 0.9em;
            

            border: none;
            cursor: pointer;
            font-weight: bold;
            color: var(--color);
            background:
                linear-gradient(to bottom left, var(--color) 50%, #0000 50.1%) top right,
                linear-gradient(to top right, var(--color) 50%, #0000 50.1%) bottom left;
            background-size: calc(var(--slant) + 1.3*var(--border)) calc(var(--slant) + 1.3*var(--border));
            background-repeat: no-repeat;
            box-shadow:
                0 0 0 200px inset var(--s, #0000),
                0 0 0 var(--border) inset var(--color);
            clip-path:
                polygon(0 0, calc(100% - var(--slant)) 0, 100% var(--slant),
                    100% 100%, var(--slant) 100%, 0 calc(100% - var(--slant)));
            transition: color var(--t, 0.3s), background-size 0.3s;
            
        }

        .buttonn:focus-visible {
            outline-offset: calc(-1*var(--border));
            outline: var(--border) solid #000c;
            clip-path: none;
            background-size: 0 0;
        }

        .buttonn:hover,
        .buttonn:active {
            background-size: 100% 100%;
            color: #FFFFFF;
            --t: 0.2s 0.1s;

        }

        .buttonn:active {
            --s: #0005;
            transition: none;
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?= $this->include('admin/admin-partials/sidebar') ?>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?= $this->include('admin/admin-partials/topbar') ?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->

                <?= $this->renderSection('content') ?>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Wotakus <?= Date('Y') ?> </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <script>
        $(document).ready(function () {
            var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                removeItemButton: true,
                maxItemCount: 7,
                searchResultLimit: 50,
                renderChoiceLimit: 50,
                noChoicesText: 'Tidak ada pilihan yang tersedia',
                itemSelectText: 'Tekan untuk memilih',
                addItemText: function (value) {
                    return 'Tekan Enter untuk menambahkan <b>"' + value + '"</b>';
                },
                maxItemText: function (maxItemCount) {
                    return 'Maksimal ' + maxItemCount + ' Genre dapat dipilih.';
                },
                // uniqueItemText: 'Item ini sudah dipilih.',
                noResultsText: 'Gak ada Genre nya cok aowkaow',
                noChoicesText: 'Tidak ada pilihan yang tersedia',
                // searchPlaceholderValue: 'Mulai mengetik untuk mencari...',
                placeholder: true,
                placeholderValue: 'Pilih Maks 7 Genre',
                // loadingText: 'Memuat...'
            });
        });

        function previewImg() {
            const BackgroundCover = document.querySelector('#fileBackgroundCover');
            const BackgroundCoverLabel = document.querySelector('#custom-file-label');
            const BackgroundCoverPreview = document.querySelector('#img-preview');

            BackgroundCoverLabel.textContent = BackgroundCover.files[0].name;

            const fileBackgroundCover = new FileReader();
            fileBackgroundCover.readAsDataURL(BackgroundCover.files[0]);

            fileBackgroundCover.onload = function (e) {
                BackgroundCoverPreview.src = e.target.result;
            }
        }

        function previewImgPoster() {
            const Poster = document.querySelector('#Poster');
            const PosterLabel = document.querySelector('#custom-file-label-poster');
            const PosterPreview = document.querySelector('#img-preview-poster');

            PosterLabel.textContent = Poster.files[0].name;

            const filePoster = new FileReader();
            filePoster.readAsDataURL(Poster.files[0]);

            filePoster.onload = function (e) {
                PosterPreview.src = e.target.result;
            }
        }

        function GambarPreview() {
            const GambarPreview = document.querySelector('#gambarPreview');
            const GambarPreviewLabel = document.querySelector('#custom-file-label-episode');
            const GambarPreviewPreview = document.querySelector('#img-preview-episode');

            GambarPreviewLabel.textContent = GambarPreview.files[0].name;

            const fileGambarPreview = new FileReader();
            fileGambarPreview.readAsDataURL(GambarPreview.files[0]);

            fileGambarPreview.onload = function (e) {
                GambarPreviewPreview.src = e.target.result;
            }
        }

        function displayFileDetails() {
            var input = document.getElementById('video_path');
            if (input.files.length > 0) {
                var file = input.files[0];
                var fileName = file.name;
                document.getElementById('file-name').textContent = 'Selected file: ' + fileName;

                var videoPreview = document.getElementById('video-preview');
                var videoSource = document.getElementById('video-source');
                
                var reader = new FileReader();
                reader.onload = function(e) {
                    videoSource.src = e.target.result;
                    videoPreview.load();
                    videoPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('file-name').textContent = 'No file selected.';
                var videoPreview = document.getElementById('video-preview');
                videoPreview.style.display = 'none';
                videoPreview.pause();
                videoPreview.removeAttribute('src'); // Clear the video src
            }
        }

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

    


    <?= $this->renderSection('scripts') ?>
</body>

</html>