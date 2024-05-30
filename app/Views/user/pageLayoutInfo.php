<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('Judul') ?></title>
    <link rel="shortcut icon" href="https://cdn3.emoji.gg/emojis/6903-gojode.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url('css/animes.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/animesDetail.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/videoPre.css')?>">
    <style>

        .episode .grid-episode .anime-img-1 {
            <?php foreach ($episode as $eps) : ?>
            
            <?php endforeach ?>
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            width: 100%;
            height: 115px;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            min-height: 100vh;
            background-image: url(<?=base_url('assets/images/'.$anime['BackgroundCover']);?>);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0.2;
            z-index: -1;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 50px;
            background: linear-gradient(to top, #171717, transparent);
            z-index: -1;
        }

        .episode .grid-episode .anime-section .anime-img-1::before {
            content: '';
            position: relative;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            transform: translate(-50%, -50%);
            background-color: #000;
            opacity: 0;
            z-index: 100;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.2s;
        }

        .episode .grid-episode .anime-section .anime-img-1::after {
            content: '';
            position: relative;
            top: -50%;
            left: 50%;
            width: 50px;
            height: 50px;
            transform: translate(-50%, -50%);
            background: url('<?=base_url('assets/images/play-button.png');?>');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0;
            z-index: 100;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.5s;
        }

        .episode .grid-episode .anime-section:hover .anime-img-1::before,
            {
            opacity: 0.5;
        }

        .episode .grid-episode .anime-section:hover .anime-img-1::after {
            opacity: 1;
        }
    </style>

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>

    <?= $this->include('user/header') ?>

    <?= $this->renderSection('content') ?>

    <?= $this->include('user/footer') ?>

    <!-- Jquery dan Bootsrap JS -->
    <script src="<?= base_url('js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="js/searchIcon.js"></script>
    <script src="<?= base_url('js/countView.js') ?>"></script>

</body>

</html>