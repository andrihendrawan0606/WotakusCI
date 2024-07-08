<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard <?= $this->renderSection('Judul') ?> </title>

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="https://cdn3.emoji.gg/emojis/6903-gojode.png" />
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.1.1/css/bootstrap5-toggle.min.css"rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/14.0.0/material-components-web.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
    <link href="<?php echo base_url('css/summernoteImageList.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/cardTayang.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/cardAdminDetail.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/tambahAnime.css') ?>" rel="stylesheet">
    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(29, 28, 29, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .center-table th, .center-table td {
            text-align: center;
            vertical-align: middle;
        }
        .center-table .desc {
            display: inline-block;
            width: auto; /* Jangan atur ke 100% karena itu akan menyebabkan elemen mengisi seluruh sel */
            text-align: justify;
            font-size: 13px;
        }
        .center-table {
            /* display: inline-block;
            width: auto; 
            text-align: center; */
        }
        .loader {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            position: relative;
            animation: rotate 1s linear infinite;
        }
        .loader::before, .loader::after {
            content: "";
            box-sizing: border-box;
            position: absolute;
            inset: 0px;
            border-radius: 50%;
            border: 5px solid #FFF;
            animation: prixClipFix 2s linear infinite;
        }
        .loader::after {
            transform: rotate3d(90, 90, 0, 180deg);
            border-color: #FF3D00;
        }

        @keyframes rotate {
            0% {transform: rotate(0deg);}
            100% {transform: rotate(360deg);}
        }

        @keyframes prixClipFix {
            0% {clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0);}
            50% {clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0);}
            75%, 100% {clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%);}
        }

        .note-editor .dropdown-toggle::after {
            all: unset;
        }

        .note-editor .note-dropdown-menu {
            box-sizing: content-box;
        }

        .note-editor .note-modal-footer {
            box-sizing: content-box;
        }
        
        #progress-bar-container {
            display: none;
            margin-top: 20px;
        }
        .drop-zone {
            border: 2px dashed #007bff;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            margin-top: 10px;
        }
        .drop-zone.dragover {
            background-color: #e0e7ff;
        }
        .hide {
            display: none;
        }
        .video-container {
            position: relative;
            margin-top: 10px;
        }
        .video-frame {
            border: 2px solid #007bff;
            border-radius: 5px;
            padding: 10px;
            max-width: 100%;
        }
        .remove-video {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 16px;
        }
        .frame-image {
            max-width: 100%;
            max-height: 300px; /* Adjust the max-height as needed */
            object-fit: contain; /* This will keep the aspect ratio */
        }
        .position-relative {
            width: 100%;
            height: 300px; /* Adjust the height as needed */
            border: 1px solid #ddd; /* Optional: Adds a border to the frame */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background-color: #f8f8f8; /* Optional: Adds a background color to the frame */
        }
        .image-thumbnail {
            width: auto;
            height: 100%;
        }

        .swal2-cancel-margin {
        margin-right: 20px; 
        }
        
        progress {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 5px;
            border-radius: 5px;
            overflow: hidden;
        }
        progress::-webkit-progress-bar {
            background-color: #f3f3f3;
        }
        progress::-webkit-progress-value {
            background-color: #007bff;
        }
        progress::-moz-progress-bar {
            background-color: #007bff;
        }
        .custom-progress::-webkit-progress-value {
            background-color: purple; /* Warna hijau */
        }
        .custom-progress::-moz-progress-bar {
            background-color: #28a745; /* Warna hijau */
        }
        /* .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
        .toggle.ios .toggle-handle { border-radius: 20px; } */


 
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<div class="loading-overlay">
        <span class="loader"></span>
    </div>

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

  
    <!-- Bootstrap core JavaScript-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>
    <script src="<?= base_url('js/genreSelector.js') ?>"></script>
    <script src="<?= base_url('js/previewImg.js') ?>"></script>
    <script src="<?php echo base_url('js/summernoteImage.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.1.1/js/bootstrap5-toggle.ecmas.min.js"></script>
    <!-- <script type="text/javascript" src="cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   
    <!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('a');
        const loadingOverlay = document.querySelector('.loading-overlay');

    links.forEach(link => {
        link.addEventListener('click', function(event) {
        // Periksa apakah link tidak memiliki target _blank, tidak href "#", dan tidak memiliki javascript:
        if (link.getAttribute('target') !== '_blank' && link.getAttribute('href') !== '#' && !link.href.startsWith('javascript:')) {
            loadingOverlay.style.display = 'flex';
        }
        });
    });

    window.addEventListener('pageshow', function(event) {
        loadingOverlay.style.display = 'none';
    });
    });

    
    $(document).ready(function() {
            $('#summernote').summernote({
                callbacks: {
                    onImageUpload: function(files) {
                        for (let i = 0; i < files.length; i++) {
                            $.upload(files[i]);
                        }
                    },
                    onMediaDelete: function(target) {
                        let src = target[0].src;
                        let baseUrl = window.location.origin + '/';
                        let relativePath = src.replace(baseUrl, '');
                        $.delete(relativePath);
                    }
                },
                height: 200,
                toolbar: [
                    ["style", ["bold", "italic", "underline", "clear"]],
                    ["fontname", ["fontname"]],
                    ["fontsize", ["fontsize"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["height", ["height"]],
                    ["insert", ["link", "picture", "imgList", "video", "hr"]],
                    ['view', ["fullscreen", "codeview", "help"]],

                ],
                dialogsInBody: true,
                imgList: {
                    endpoint: "<?php echo site_url('adminController/listGambar') ?>",
                    fullUrlPrefix: "<?php echo base_url('uploads/berkas') ?>/",
                    thumbUrlPrefix: "<?php echo base_url('uploads/berkas') ?>/"
                }
            });

            $.upload = function(file) {
                let out = new FormData();
                out.append('file', file, file.name);
                $.ajax({
                    method: 'POST',
                    url: '<?php echo site_url('adminController/uploadGambarNews') ?>',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: out,
                    success: function(img) {
                        $('#summernote').summernote('insertImage', img);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus + " " + errorThrown);
                    }
                });
            };
                $.delete = function(src) {
                $.ajax({
                    method: 'POST',
                    url: '<?= site_url('adminController/deleteGambarNews') ?>',
                    cache: false,
                    data: {
                        src: src
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            };
        });

        function konfirmasi(url) {
            var result = confirm("Want to delete?");
            if (result) {
                window.location.href = url;
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
            const fileInput = document.getElementById('video_path');
            const videoContainer = document.getElementById('video-container');
            const videoPreview = document.getElementById('video-preview');
            const videoSource = document.getElementById('video-source');
            const dropZone = document.getElementById('drop-zone');

            // Clear input file
            fileInput.value = '';

            // Hide video container
            videoContainer.style.display = 'none';
            
            // Hide video preview
            videoPreview.style.display = 'none';
            videoSource.src = '';

            // Show drop zone
            dropZone.classList.remove('hide');
        }

        // Drag and Drop
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('video_path');

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
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>

</html>