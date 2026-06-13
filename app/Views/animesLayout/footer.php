<style>
.content-grow {
    flex: 1 0 auto; /* Ini akan "memakan" semua ruang kosong dan mendorong footer ke bawah */
}

/* 3. Perbaikan pada Footer Modern */
.footer-modern {
    flex-shrink: 0; /* Mencegah footer menciut */
    background-color: #0f0f0f;
    padding: 80px 0 30px; /* Tambah padding atas agar tidak terlalu mepet konten grid */
    margin-top: 100px;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    color: #e2e2e2;
    position: relative;
    z-index: 10; /* Pastikan di atas elemen background */
    clear: both; /* Membersihkan float jika ada */
}

/* 4. Pastikan container grid anime tidak mengganggu aliran dokumen */
.section {
    overflow: visible !important; /* Agar bayangan atau elemen meluap tidak terpotong */
}

.footer-container {
    position: relative;
    z-index: 5;
    max-width: 1200px;
    margin: 0 auto;
    text-align: center;
    padding: 0 20px;
}

/* Perbaikan efek cahaya aura agar tidak membuat scrollbar horizontal muncul */
.footer-modern::before {
    content: '';
    position: absolute;
    top: -50px;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 600px;
    height: 200px;
    background: radial-gradient(circle, rgba(172, 17, 233, 0.15) 0%, transparent 70%);
    z-index: 0;
    pointer-events: none; /* Agar tidak bisa diklik */
}

.footer-container {
    position: relative;
    z-index: 1;
    max-width: 1200px;
    margin: 0 auto;
    text-align: center;
    padding: 0 20px;
}

.footer-logo {
    height: 60px;
    margin-bottom: 15px;
    filter: drop-shadow(0 0 10px rgba(172, 17, 233, 0.3));
}

.footer-tagline {
    font-size: 14px;
    color: #888;
    max-width: 400px;
    margin: 0 auto;
}

/* SOCIAL ICONS MODERN */
.social-links {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social-icon {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    color: #fff;
    font-size: 18px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none !important;
}

.social-icon:hover {
    transform: translateY(-5px);
    background: #ac11e9;
    color: #fff;
    box-shadow: 0 10px 20px rgba(172, 17, 233, 0.4);
    border-color: #ac11e9;
}

/* NAV LINKS */
.footer-nav {
    list-style: none;
    padding: 0;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 30px;
}

.footer-nav li a {
    color: #bbb;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: 0.3s;
}

.footer-nav li a:hover {
    color: #ac11e9;
}

/* DIVIDER & COPYRIGHT */
.footer-divider {
    border: 0;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    margin: 30px 0;
}

.copyright-text {
    font-size: 13px;
    color: #666;
    line-height: 1.6;
}

.text-primary-neon {
    color: #ac11e9;
    font-weight: 800;
}

/* RESPONSIVE */
@media (max-width: 600px) {
    .footer-nav {
        gap: 15px;
        flex-direction: column;
    }
    .footer-modern {
        padding: 40px 0 20px;
    }
}
</style>

<footer class="footer-modern">
    <div class="footer-container">
        <!-- Logo atau Nama Web di Footer -->
        <div class="footer-brand mb-4">
            <img src="<?= base_url('img/Wotakus.png') ?>" alt="Wotakus Logo" class="footer-logo">
            <p class="footer-tagline">Tempat terbaik untuk update anime favoritmu.</p>
        </div>

        <!-- Social Media Icons -->
        <div class="social-links mb-4">
            <a href="https://www.instagram.com/andriii_h06/" class="social-icon insta" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon twitter" title="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-icon facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://discordapp.com/users/679265300507656192" class="social-icon discord" title="Discord"><i class="fab fa-discord"></i></a>
        </div>

        <!-- Navigation Links -->
        <ul class="footer-nav mb-4">
            <li><a href="#">Home</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Terms</a></li>
            <li><a href="#">Privacy Policy</a></li>
        </ul>

        <!-- Divider Line -->
        <hr class="footer-divider">

        <!-- Copyright -->
        <p class="copyright-text">
            &copy; <?= date('Y') ?> <span class="text-primary-neon">Wotakus</span>. All rights reserved. 
            <br><small class="text-muted">Made with <i class="fas fa-heart text-danger"></i> by Sketzie</small>
        </p>
    </div>
</footer>