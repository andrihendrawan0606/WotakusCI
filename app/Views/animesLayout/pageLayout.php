<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= $this->renderSection('Judul') ?>Wotakus</title>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />



    <link rel="shortcut icon" href="https://cdn3.emoji.gg/emojis/6903-gojode.png" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-brands/css/uicons-brands.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url('css/animes.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/videoPre.css')?>">
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <style>
        .col:nth-of-type(1) .card-container-episode:nth-of-type(1) .card-episode:before{
            background-image: url(https://thumbs.dreamstime.com/b/icon-completed-banner-teamwork-business-success-vector-illustration-stock-picture-eps-258589005.jpg);
            background-size: cover;
            
        }

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

        .imgNews{
            /* width: 100%; */
        }
        .imgNews img{
            width: 100%;
        }
        .news p{
            font-family: "Noto Sans JP", "Roboto", sans-serif;
            font-size: 15px;
            font-weight: lighter;
            line-height: 1.6;
            margin-top: 2em;
        }
        .scrollToTop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            background-color: #e63946; 
            color: white;
            border: none;
            padding: 15px;
            border-radius: 100px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
            z-index: 1000;
            font-size: 20px;
        }

        .scrollToTop:hover {
            background-color: #d62828; 
            transform: scale(1.2); 
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.3);
        }

        .scrollToTop:active {
            transform: scale(1); 
        }

        @media screen and (max-width: 768px) {
            .scrollToTop {
                bottom: 10px;
                right: 10px;
                padding: 12px;
                font-size: 18px;
            }
        }

        /* =========================================
        TOP PROGRESS BAR STYLING
        ========================================= */
        .top-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%; /* Dimulai dari 0% */
            height: 3px; /* Ketebalan garis loading */
            background: linear-gradient(90deg, #ac11e9, #FF3D00); /* Warna gradasi premium */
            z-index: 999999; /* Pastikan selalu berada di paling atas */
            transition: width 0.4s ease, opacity 0.3s ease;
            opacity: 0; /* Tersembunyi secara default */
            pointer-events: none; /* Agar tidak menghalangi klik pada navbar */
        }

        /* Efek cahaya kecil di ujung kanan progress bar */
        .top-progress-bar .progress-glow {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 100px;
            box-shadow: 0 0 10px #FF3D00, 0 0 5px #ac11e9;
            opacity: 0.8;
            transform: translateY(-25%);
        }
    </style>
</head>
<body style="background-color: black;" >
    <div id="top-progress-bar" class="top-progress-bar">
        <div class="progress-glow"></div>
    </div>
    <?= $this->include('animesLayout/navbar') ?>
    <?= $this->renderSection('content') ?>
    <?= $this->include('animesLayout/footer') ?>
    <button id="scrollToTopBtn" class="scrollToTop" title="Kembali ke atas">
        <i class="fa fa-arrow-up"></i>
    </button>


    <script src="<?= base_url('js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    <!-- <script src="js/searchIcon.js"></script> -->
    <script src="<?= base_url('js/search.js') ?>"></script>

    <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <!-- Include Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const progressBar = document.getElementById('top-progress-bar');
        const links = document.querySelectorAll('a');

        links.forEach(link => {
            link.addEventListener('click', function(event) {
                const href = link.getAttribute('href');
                const target = link.getAttribute('target');

                // Syarat agar loading bar muncul:
                // 1. Punya href
                // 2. Bukan anchor link (#)
                // 3. Bukan script (javascript:)
                // 4. Bukan buka di tab baru (_blank)
                if (href && href !== '#' && !href.startsWith('javascript:') && target !== '_blank') {
                    
                    // Mencegah loading bar muncul jika user klik tengah (scroll wheel) 
                    // atau klik sambil tahan tombol CTRL/CMD (buka di tab baru)
                    if (event.button === 0 && !event.ctrlKey && !event.metaKey) {
                        // Munculkan progress bar dan jalankan ke 75% (Fake Loading)
                        progressBar.style.opacity = '1';
                        progressBar.style.width = '75%';
                    }
                }
            });
        });

        // Ketika halaman tujuan sudah selesai dimuat sepenuhnya
        window.addEventListener('pageshow', function(event) {
            // Tembak progress bar ke 100%
            progressBar.style.width = '100%';
            
            // Beri sedikit jeda agar user melihat angka 100%, lalu pudarkan
            setTimeout(() => {
                progressBar.style.opacity = '0';
                
                // Setelah memudar, reset kembali panjangnya menjadi 0% untuk klik berikutnya
                setTimeout(() => {
                    progressBar.style.width = '0%';
                }, 300); // Tunggu efek transisi opacity selesai
            }, 300);
        });
    });

    $('#summernote').summernote({
        placeholder: '',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });

      // Tombol Scroll
        const scrollToTopBtn = document.getElementById('scrollToTopBtn');

        window.onscroll = function () {
            toggleScrollToTopBtn();
        };

        // Fungsi untuk menampilkan/menyembunyikan tombol
        function toggleScrollToTopBtn() {
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                scrollToTopBtn.style.display = "block";
            } else {
                scrollToTopBtn.style.display = "none";
            }
        }

        // Fungsi untuk scroll ke atas
        scrollToTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth' // Efek smooth
            });
        });
    </script>

</body>


</html>