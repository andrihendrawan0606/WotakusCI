<!doctype html>
<html lang="en">

<head>
    <title>Login | WOTAKUS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="shortcut icon" href="https://cdn3.emoji.gg/emojis/6903-gojode.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
:root {
    --primary-color: #ff4757;
    --accent-color: #2f3542;
    --glass-bg: rgba(255, 255, 255, 0.12);
    --glass-border: rgba(255, 255, 255, 0.2);
}

body, html {
    height: 100%;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}

.login-page {
    background: url('https://images5.alphacoders.com/105/1053417.jpg') no-repeat center center fixed; /* Ganti dengan URL gambar anime Anda */
    background-size: cover;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

/* Overlay kegelapan agar teks terbaca */
.login-page::before {
    content: '';
    position: absolute;
    top:0; left:0; right:0; bottom:0;
    background: rgba(0, 0, 0, 0.4);
}

.glass-container {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 400px;
    padding: 20px;
}

.login-box {
    background: var(--glass-bg);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid var(--glass-border);
    border-radius: 25px;
    padding: 40px 30px;
    box-shadow: 0 25px 45px rgba(0,0,0,0.2);
}

.header-logo h2 {
    color: white;
    font-weight: 800;
    letter-spacing: 2px;
    margin-top: 10px;
}

.jp-text {
    color: rgba(255,255,255,0.7);
    font-size: 0.8rem;
    margin-top: -5px;
}

.anime-float {
    width: 60px;
    animation: floating 3s ease-in-out infinite;
}

@keyframes floating {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* Custom Input Style */
.custom-input {
    position: relative;
}

.custom-input .input-icon {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255,255,255,0.6);
}

.form-control {
    background: rgba(255, 255, 255, 0.08) !important;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px !important;
    height: 55px;
    color: white !important;
    padding-left: 50px !important;
    transition: 0.3s;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.15) !important;
    border-color: var(--primary-color);
    box-shadow: 0 0 15px rgba(255, 71, 87, 0.3);
}

/* Password Toggle */
.toggle-password {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: rgba(255,255,255,0.6);
}

/* Button Anime */
.btn-anime-primary {
    background: linear-gradient(45deg, #ff4757, #ff6b81);
    border: none;
    border-radius: 15px;
    height: 55px;
    color: white;
    font-weight: 700;
    letter-spacing: 1px;
    transition: 0.4s;
    box-shadow: 0 10px 20px rgba(255, 71, 87, 0.3);
}

.btn-anime-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 25px rgba(255, 71, 87, 0.4);
    color: white;
}

/* Checkbox & Links */
.checkbox-container {
    color: white;
    cursor: pointer;
    font-size: 0.85rem;
}

.forgot-link, .register-text a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

.register-text {
    color: white;
    font-size: 0.9rem;
}

.forgot-link:hover, .register-text a:hover {
    text-decoration: underline;
    color: #ff6b81;
}

    </style>
</head>

<body>
<div class="login-page">
    <div class="glass-container">
        <div class="login-box">
            <div class="header-logo text-center">
                <img src="https://cdn3.emoji.gg/emojis/6903-gojode.png" alt="Logo" class="anime-float">
                <h2>WOTAKUS</h2>
                <p class="jp-text">ログイン | Login</p>
            </div>

            <form action="<?= url_to('prosesLogin'); ?>" method="post" id="loginForm" class="signin-form mt-4">
                <?= csrf_field(); ?>
                <input type="hidden" name="redirect" value="<?= esc(service('request')->getGet('redirect')); ?>">

                <div class="form-group custom-input">
                    <i class="fa fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control" value="<?= old('email'); ?>" placeholder="Email | メール" required>
                </div>

                <div class="form-group custom-input mt-3">
                    <i class="fa fa-lock input-icon"></i>
                    <input id="password-field" type="password" name="password" class="form-control" placeholder="Password | パスワード" required>
                    <span toggle="#password-field" class="fa fa-eye toggle-password"></span>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3 mb-4 small">
                    <!-- Fitur Remember Me umumnya butuh logika cookies di CI4, tapi biarkan secara UI -->
                    <label class="checkbox-container">Remember Me
                        <input type="checkbox" name="remember">
                        <span class="checkmark"></span>
                    </label>
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" id="btnLogin" class="btn btn-anime-primary w-100">
                    <span>SIGN IN | サインイン</span>
                </button>

                <div class="text-center mt-4">
                    <p class="register-text">Don't have an account? <a href="<?= url_to('register') ?>">Register</a></p>
                </div>
                <div class="text-center mt-2">
                    <p class="register-text">Atau <a href="<?= url_to('animes-home') ?>">Masuk Tanpa Akun</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="<?= base_url('js/loginjs.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 
    </script>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
    
    // 1. TANGKAP PESAN ERROR (Email/Pass Salah)
    <?php if (session()->get('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Login',
            text: "<?= session()->get('error'); ?>",
            background: '#1e293b',
            color: '#fff',
            confirmButtonColor: '#ff4757'
        });
    <?php endif; ?>

    // 2. TANGKAP PESAN SUKSES (Misal habis Register)
    <?php if (session()->get('pesan')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "<?= session()->get('pesan'); ?>",
            background: '#1e293b',
            color: '#fff',
            confirmButtonColor: '#2ed573'
        });
    <?php endif; ?>

    // 3. TANGKAP ERROR VALIDASI FORM (Kosong/Format Salah)
    <?php if (session()->get('validation')) : ?>
        let errorMessages = "";
        <?php foreach (session()->get('validation')->getErrors() as $error) : ?>
            errorMessages += "<li><?= esc($error) ?></li>";
        <?php endforeach; ?>
        
        Swal.fire({
            icon: 'warning',
            title: 'Periksa Kembali',
            html: `<ul style="text-align: left; margin: 0; padding-left: 20px;">${errorMessages}</ul>`,
            background: '#1e293b',
            color: '#fff',
            confirmButtonColor: '#ff4757'
        });
    <?php endif; ?>

    // 4. FITUR SHOW/HIDE PASSWORD (Vanilla JS - Sangat Cepat & Aman)
    const toggleIcons = document.querySelectorAll('.toggle-password');
    toggleIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
            
            const targetInputId = this.getAttribute('toggle');
            const inputElement = document.querySelector(targetInputId);
            
            if (inputElement.getAttribute('type') === 'password') {
                inputElement.setAttribute('type', 'text');
            } else {
                inputElement.setAttribute('type', 'password');
            }
        });
    });

    // 5. MENCEGAH SPAM KLIK PADA TOMBOL LOGIN (Anti-Double Submit)
    const form = document.getElementById('loginForm');
    const btnLogin = document.getElementById('btnLogin');

    form.addEventListener('submit', function() {
        // Ubah teks dan disable tombol saat disubmit
        btnLogin.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Authenticating...';
        btnLogin.style.pointerEvents = 'none';
        btnLogin.style.opacity = '0.7';
    });

});
        
    </script>
</body>

</html>