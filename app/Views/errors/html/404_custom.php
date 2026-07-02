<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Tersesat di Isekai | Wotakus</title>
    <style>
        /* Reset & Base */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: #11121b; /* Gelap elegan serasi dengan login page */
            color: #ffffff;
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Subtly Dark Background Decoration (Bukan Neon Terang) */
        .bg-blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 74, 90, 0.04) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            z-index: 1;
        }
        .blob-1 { top: -10%; left: -10%; }
        .blob-2 { bottom: -10%; right: -10%; }

        /* Container / Glassmorphism Card */
        .container {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 50px 30px;
            max-width: 500px;
            width: 90%;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Content */
        .kaomoji {
            font-size: 45px;
            color: #8F94A5;
            margin-bottom: 15px;
            display: block;
            font-weight: 300;
        }
        .error-code {
            font-size: 90px;
            margin-bottom: 10px;
            color: #FF4A5A; /* Merah coral senada tombol login */
            font-weight: 800;
            letter-spacing: -2px;
            line-height: 1;
        }
        h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        p {
            font-size: 15px;
            color: #8F94A5;
            line-height: 1.6;
            margin-bottom: 35px;
        }

        /* Button */
        .btn-back {
            display: inline-block;
            background-color: #FF4A5A;
            color: #ffffff;
            text-decoration: none;
            padding: 15px 32px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 12px;
            transition: transform 0.2s, background-color 0.2s, box-shadow 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-back:hover {
            background-color: #e03f4f;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 74, 90, 0.25);
        }
        .btn-back:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Background Bulatan Halus -->
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <!-- Kotak Pesan Error -->
    <div class="container">
        <!-- Kaomoji Anime Pasrah -->
        <span class="kaomoji">ヘ(>_<ヘ)</span>
        <div class="error-code">404</div>
        <h1>Tersesat di Isekai?</h1>
        <p>Halaman yang kamu cari tidak ditemukan. Mungkin telah berpindah dimensi, dihapus oleh admin, atau hancur berkeping-keping.</p>
        <a href="<?= base_url('animes-home') ?>" class="btn-back">Kembali ke Beranda</a>
    </div>
</body>
</html>