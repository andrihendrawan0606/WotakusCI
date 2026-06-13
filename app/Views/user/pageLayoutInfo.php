<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('Judul') ?></title>
    <link rel="shortcut icon" href="https://cdn3.emoji.gg/emojis/6903-gojode.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-brands/css/uicons-brands.css'>
    <link rel="stylesheet" href="<?= base_url('css/animes.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/animesDetail.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/videoPre.css')?>">
    <style>
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            min-height: 99vh;
            <?php 
                if (isset($anime['BackgroundCover'])): 
                    $bgPath = $anime['BackgroundCover'];
                    
                    if (filter_var($bgPath, FILTER_VALIDATE_URL)): ?>
                        background-image: url(<?= $bgPath ?>); 
                    <?php else: ?>
                        background-image: url(<?= base_url('assets/images/' . $bgPath) ?>);
                    <?php endif; 
                else: ?>
                    background-image: none; 
            <?php endif; ?>
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0.5;
            z-index: -1;
            filter: blur(22px)
        }

        .episode .grid-episode .anime-section .anime-img-1::after {
            content: '';
            position: relative;
            top: -50%;
            left: 50%;
            width: 50px;
            height: 50px;
            transform: translate(-50%, -50%);
            background: url(<?=base_url('assets/images/play-button.png');?>);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0;
            z-index: 10000;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.2s;
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

        .vjs-theater-mode {
        width: 100% !important;
        height: 100vh !important;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        background-color: #000;
        }

        .vjs-theater-mode .vjs-tech {
            width: 100% !important;
            height: 100vh !important;
        }

        .theater-btn {
            background-color: transparent;
            color: #fff;
            border: none;
            cursor: pointer;
            margin-left: 10px;
        }

        .theater-btn:hover {
            color: #00f;
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
    </style>

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>
<div class="loading-overlay">
        <span class="loader"></span>
    </div>
    <?= $this->include('animesLayout/navbar') ?>

    <main>
    <?= $this->renderSection('content') ?>
    </main>
    <?= $this->include('animesLayout/footer') ?>
    <button id="scrollToTopBtn" class="scrollToTop" title="Kembali ke atas">
        <i class="fa fa-arrow-up"></i>
    </button>

    <!-- Jquery dan Bootsrap JS -->
    <script src="<?= base_url('js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://vjs.zencdn.net/7.20.3/video.js"></script>
    <!-- <script src="js/searchIcon.js"></script> -->
    <script src="<?= base_url('js/countView.js') ?>"></script>
    <script src="<?= base_url('js/cutomVideoPlay.js') ?>"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('a');
        const loadingOverlay = document.querySelector('.loading-overlay');

        links.forEach(link => {
            link.addEventListener('click', function(event) {
            if (link.getAttribute('target') !== '_blank' && link.getAttribute('href') !== '#' && !link.href.startsWith('javascript:')) {
                loadingOverlay.style.display = 'flex';
            }
            });
        });

    window.addEventListener('pageshow', function(event) {
        loadingOverlay.style.display = 'none';
    });
    });

    // Tombol Scroll
    const scrollToTopBtn = document.getElementById('scrollToTopBtn');

    window.onscroll = function () {
        toggleScrollToTopBtn();
    };

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
            behavior: 'smooth' 
        });
    });
    </script>


</body>

</html>