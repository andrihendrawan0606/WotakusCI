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

            <form action="<?= url_to('prosesLogin'); ?>" method="post" class="signin-form mt-4">
                <?= csrf_field(); ?>
                <input type="hidden" name="redirect" value="<?= service('request')->getGet('redirect'); ?>">

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
                    <label class="checkbox-container">Remember Me
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-anime-primary w-100">
                    <span>SIGN IN | サインイン</span>
                </button>

                <div class="text-center mt-4">
                    <p class="register-text">Don't have an account? <a href="<?= url_to('register') ?>">Register</a></p>
                </div>
                <div class="text-center mt-4">
                    <p class="register-text">Masuk Tanpa Akun Disini <a href="<?= url_to('animes-home') ?>">Masuk</a></p>
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
        $(document).ready(function() {
            <?php if (session()->get('error')) : ?>
                const ToastError = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 400,  // Timer otomatis 5 detik
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    },
                    willClose: () => {
                        window.location.href = '<?= base_url('/auth/login'); ?>'; // Redirect ke halaman login setelah alert ditutup
                    }
                });

                ToastError.fire({
                    icon: 'error',
                    title: "<?= session()->get('error'); ?>"
                });
            <?php endif; ?>
        });

        (function($) {
        "use strict";

        var fullHeight = function() {

            $('.js-fullheight').css('height', $(window).height());
            $(window).resize(function(){
                $('.js-fullheight').css('height', $(window).height());
            });

        };
        fullHeight();

        $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
        });

        })(jQuery);
        
    </script>
</body>

</html>