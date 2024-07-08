<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('Judul') ?>Wotakus</title>
    <!-- Include Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <!-- Include Bootstrap CSS (Optional if not included already) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />



    <link rel="shortcut icon" href="https://cdn3.emoji.gg/emojis/6903-gojode.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url('css/animes.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/videoPre.css')?>">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
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


    </style>
</head>
<body style="background-color: #000000;" >
    <div class="loading-overlay">
        <span class="loader"></span>
    </div>
    <?= $this->include('animesLayout/navbar') ?>
    <main>
    <?= $this->renderSection('content') ?>
    </main>
    <?= $this->include('animesLayout/footer') ?>

    <!-- Jquery dan Bootsrap JS -->
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
    </script>

</body>


</html>