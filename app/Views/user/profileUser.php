<?= $this->extend('animesLayout/pageLayout') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --primary-neon: #ac11e9;
        --glass-bg: rgba(255, 255, 255, 0.05);
        --glass-border: rgba(255, 255, 255, 0.1);
    }

    .profile-wrapper { 
        max-width: 1350px; /* Sebelumnya 1100px, kita buat lebih lebar */
        width: 100%; 
        margin: 50px auto; 
        padding: 0 40px; /* Tambah padding samping agar tidak terlalu nempel di monitor besar */
    }    
    /* Profile Header & Banner */
    .profile-header-card { 
        background: rgba(20, 20, 20, 0.6); 
        backdrop-filter: blur(15px); 
        border-radius: 30px; 
        border: 1px solid var(--glass-border);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .profile-banner { 
        height: 200px; 
        background: url('https://t4.ftcdn.net/jpg/08/50/30/01/360_F_850300178_2R0d9z8EiG6hN8Yj5QaBEYJAEVFflJly.jpg') no-repeat top center;
        position: relative;
    }

    .avatar-position { 
        position: absolute; 
        bottom: -60px; 
        left: 40px; 
        display: flex; 
        align-items: flex-end; 
        gap: 20px;
    }

    .profile-avatar-img { 
        width: 140px; 
        height: 140px; 
        border-radius: 50%; 
        border: 5px solid #121212; 
        object-fit: cover;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5);
    }

    .profile-main-info { padding: 80px 40px 30px; }
    .user-full-name { font-size: 2rem; font-weight: 800; color: #fff; margin: 0; }
    .user-badge-level { 
        display: inline-block; 
        background: var(--primary-neon); 
        color: #fff; 
        padding: 4px 15px; 
        border-radius: 50px; 
        font-size: 11px; 
        font-weight: 800; 
        margin-top: 5px;
    }

    /* Form & Settings Section */
    .settings-card { 
        background: rgba(255, 255, 255, 0.03); 
        border-radius: 25px; 
        border: 1px solid var(--glass-border);
        padding: 30px;
    }

    .form-section-title { 
        font-size: 14px; 
        text-transform: uppercase; 
        color: var(--primary-neon); 
        font-weight: 700; 
        letter-spacing: 1px; 
        margin-bottom: 25px;
        display: block;
        border-left: 4px solid var(--primary-neon);
        padding-left: 15px;
    }

    .custom-form-group label { color: #aaa; font-size: 13px; font-weight: 600; margin-bottom: 8px; display: block; }
    
    .profile-input {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid var(--glass-border) !important;
        border-radius: 12px !important;
        color: #fff !important;
        padding: 12px 15px;
        transition: 0.3s;
    }

    .profile-input:focus {
        border-color: var(--primary-neon) !important;
        box-shadow: 0 0 15px rgba(172, 17, 233, 0.3) !important;
    }

    .btn-update-profile {
        background: var(--primary-neon);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-update-profile:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(172, 17, 233, 0.4); }

    /* File Upload Styling */
    .file-upload-wrapper {
        border: 2px dashed var(--glass-border);
        padding: 20px;
        border-radius: 15px;
        text-align: center;
        transition: 0.3s;
    }
    .file-upload-wrapper:hover { border-color: var(--primary-neon); }

    @media (max-width: 1200px) {
        .profile-wrapper {
            max-width: 95%;
            padding: 0 20px;
        }
    }

    @media (max-width: 768px) {
        .avatar-position { 
            left: 50%; 
            transform: translateX(-50%); 
            bottom: -70px; 
            flex-direction: column; 
            align-items: center; 
            text-align: center; 
        }
        .profile-main-info { 
            text-align: center; 
            padding: 100px 20px 30px; 
        }
    }
</style>

<div class="profile-wrapper">
    <!-- 1. Header Profil -->
    <div class="profile-header-card">
        <div class="profile-banner">
            <div class="avatar-position">
                <?php 
                    $profileImg = session()->get('ProfileImg'); 
                    $imgSrc = (filter_var($profileImg, FILTER_VALIDATE_URL)) ? $profileImg : base_url('assets/images/' . $profileImg);
                ?>
                <img src="<?= $imgSrc ?>" class="profile-avatar-img" id="img-preview">
                <div class="d-none d-md-block pb-3">
                    <h2 class="user-full-name"><?= esc($user['nama']) ?></h2>
                    <span class="user-badge-level"><?= strtoupper($user['level'] ?? 'BASIC') ?> MEMBER</span>
                </div>
            </div>
        </div>
        <div class="profile-main-info">
            <div class="d-md-none mb-4">
                <h2 class="user-full-name"><?= esc($user['nama']) ?></h2>
                <span class="user-badge-level"><?= strtoupper($user['level'] ?? 'BASIC') ?> MEMBER</span>
            </div>
            
            <div class="row text-center mt-3">
                <div class="col-4 border-right border-secondary">
                    <h5 class="mb-0 text-white font-weight-bold"><?= $user['coins'] ?? 0 ?></h5>
                    <small class="text-muted">Wotakus Coins</small>
                </div>
                <div class="col-4 border-right border-secondary">
                    <h5 class="mb-0 text-white font-weight-bold">12</h5>
                    <small class="text-muted">Watchlist</small>
                </div>
                <div class="col-4">
                    <h5 class="mb-0 text-white font-weight-bold"><?= date('M Y', strtotime($user['created_at'])) ?></h5>
                    <small class="text-muted">Joined</small>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Form Pengaturan (PENTING: Tag FORM membungkus seluruh baris kolom) -->
    <form action="<?= url_to('updateProfileUser') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="oldProfileImg" value="<?= $user['ProfileImg'] ?>">

        <div class="row">
            <!-- KOLOM KIRI: SETTINGS -->
            <div class="col-lg-8 mb-4">
                <div class="settings-card shadow">
                    <span class="form-section-title">Identity Settings</span>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group custom-form-group">
                                <label>Display Name</label>
                                <input type="text" name="nama" class="form-control profile-input <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" value="<?= old('nama', $user['nama']) ?>" required>
                                <div class="invalid-feedback"><?= $validation->getError('nama') ?></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group custom-form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control profile-input <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" value="<?= old('email', $user['email']) ?>" required>
                                <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                            </div>
                        </div>
                    </div>

                    <span class="form-section-title mt-4">Security</span>
                    <p class="small text-muted mb-3 italic"><i class="fas fa-info-circle"></i> Biarkan kosong jika tidak ingin mengganti password.</p>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="form-group custom-form-group">
                                <label>New Password</label>
                                <input type="password" name="password" class="form-control profile-input <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" placeholder="Min. 6 characters">
                                <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group custom-form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control profile-input" placeholder="Repeat new password">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-update-profile px-5">Save Changes</button>
                </div>
            </div>

            <!-- KOLOM KANAN: UPLOAD FOTO -->
            <div class="col-lg-4">
                <div class="settings-card shadow text-center">
                    <span class="form-section-title text-left">Profile Picture</span>
                    
                    <!-- Box Upload dengan indikator Error -->
                    <div class="file-upload-wrapper mt-3 <?= ($validation->hasError('ProfileImg')) ? 'border-danger' : ''; ?>">
                        <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-3"></i>
                        <p class="small text-muted">Upload foto baru untuk mengganti avatar Anda.</p>
                        
                        <input type="file" name="ProfileImg" id="ProfileImg" class="d-none" onchange="previewAvatar()">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-4" onclick="document.getElementById('ProfileImg').click()">
                            Pilih File
                        </button>
                    </div>
                    <!-- Pesan Error Gambar -->
                    <div class="text-danger small mt-2"><?= $validation->getError('ProfileImg') ?></div>
                    <small class="text-muted d-block mt-3">Format: JPG, PNG, WEBP (Max 2MB)</small>
                </div>
            </div>
        </div>
    </form> <!-- TUTUP FORM DI SINI -->
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Alert Sukses
    $(document).ready(function() {
        <?php if (session()->getFlashdata('pesan')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('pesan'); ?>',
                timer: 3000,
                showConfirmButton: false,
                background: '#1a1a1a',
                color: '#fff'
            });
        <?php endif; ?>
    });

    // Preview Foto Profil secara Real-time
    function previewAvatar() {
        const file = document.querySelector('#ProfileImg');
        const imgPreview = document.querySelector('#img-preview');
        
        if (file.files && file.files[0]) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(file.files[0]);
            fileReader.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }
    }
</script>

<?= $this->endSection() ?>