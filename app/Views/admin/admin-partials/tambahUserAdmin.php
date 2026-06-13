<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    .main-form-container { width: 100% !important; max-width: 1000px; margin: 30px auto; padding: 0 15px; }
    .user-card { background: #ffffff; border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .user-card-header { background: #ffffff; padding: 25px 30px; border-bottom: 1px solid #f0f0f0; }
    .form-section-title { font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: #8898aa; font-weight: 700; margin-bottom: 25px; display: block; border-bottom: 2px solid #5e72e4; width: fit-content; padding-bottom: 5px; }
    
    .custom-group label { font-weight: 600; font-size: 14px; color: #32325d; margin-bottom: 8px; }
    .custom-input-style { border-radius: 12px !important; border: 1px solid #dee2e6 !important; padding: 12px 15px !important; height: auto !important; font-size: 14px; transition: 0.3s; }
    .custom-input-style:focus { border-color: #5e72e4 !important; box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.1) !important; }
    
    /* Profile Image Styling */
    .profile-upload-section { text-align: center; padding: 20px; background: #f8f9fe; border-radius: 15px; border: 2px dashed #dee2e6; }
    .avatar-preview-wrapper { width: 150px; height: 150px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; border: 4px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1); background: #eee; }
    #profile-preview { width: 100%; height: 100%; object-fit: cover; }
    
    .btn-save { background: #5e72e4; color: white; font-weight: 700; padding: 12px; border-radius: 12px; border: none; transition: 0.3s; }
    .btn-save:hover { background: #4559d4; transform: translateY(-2px); box-shadow: 0 7px 14px rgba(50,50,93,.1); }
</style>

<div class="main-form-container">
    <div class="user-card">
        <div class="user-card-header">
            <h4 class="m-0 font-weight-bold" style="color: #32325d;">
                <i class="fas fa-user-plus mr-2 text-primary"></i> Tambah Pengguna Baru
            </h4>
        </div>

        <div class="card-body p-4">
            <!-- PENTING: Tambahkan enctype="multipart/form-data" -->
            <form action="<?= url_to('prosesTambahUser'); ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                
                <div class="row">
                    <!-- KOLOM KIRI: INFORMASI TEKS -->
                    <div class="col-lg-8 pr-lg-4 border-right">
                        <span class="form-section-title">Informasi Akun</span>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control custom-input-style <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" placeholder="Masukkan nama..." value="<?= old('nama'); ?>" required autofocus>
                                    <div class="invalid-feedback"><?= $validation->getError('nama') ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Alamat Email</label>
                                    <input type="email" name="email" class="form-control custom-input-style <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" placeholder="email@example.com" value="<?= old('email'); ?>" required>
                                    <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group custom-group">
                                    <label>Umur</label>
                                    <input type="number" name="age" class="form-control custom-input-style <?= ($validation->hasError('age')) ? 'is-invalid' : ''; ?>" placeholder="Contoh: 20" value="<?= old('age'); ?>">
                                    <div class="invalid-feedback"><?= $validation->getError('age') ?></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom-group">
                                    <label>Role</label>
                                    <select name="role" id="roleSelect" class="form-control custom-input-style" onchange="toggleLevel()">
                                        <option value="user" <?= old('role') == 'user' ? 'selected' : '' ?>>User (Member)</option>
                                        <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Administrator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" id="levelGroup">
                                <div class="form-group custom-group">
                                    <label>Level Member</label>
                                    <select name="level" class="form-control custom-input-style">
                                        <option value="Basic" <?= old('level') == 'Basic' ? 'selected' : '' ?>>Basic (Gratis)</option>
                                        <option value="Pro" <?= old('level') == 'Pro' ? 'selected' : '' ?>>Pro (Premium)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <span class="form-section-title mt-4">Keamanan</span>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control custom-input-style <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" placeholder="Minimal 6 karakter">
                                    <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" name="confirm_password" class="form-control custom-input-style <?= ($validation->hasError('confirm_password')) ? 'is-invalid' : ''; ?>" placeholder="Ulangi password">
                                    <div class="invalid-feedback"><?= $validation->getError('confirm_password') ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group custom-group mt-3">
                            <label>Status Akun</label>
                            <div class="d-flex">
                                <div class="custom-control custom-radio mr-4">
                                    <input type="radio" id="active" name="status" value="active" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="active">Aktif</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="inactive" name="status" value="inactive" class="custom-control-input">
                                    <label class="custom-control-label" for="inactive">Non Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: MEDIA / FOTO -->
                    <div class="col-lg-4 pl-lg-4">
                        <span class="form-section-title">Foto Profil</span>
                        <div class="profile-upload-section">
                            <div class="avatar-preview-wrapper">
                                <img src="<?= base_url('assets/images/default_profile.jpg') ?>" id="profile-preview" alt="Preview">
                            </div>
                            <div class="custom-file text-left">
                                <input type="file" name="ProfileImg" id="ProfileImg" class="custom-file-input" onchange="previewImage()">
                                <label class="custom-file-label" for="ProfileImg">Pilih Foto...</label>
                            </div>
                            <small class="text-muted d-block mt-2">Maks: 2MB (JPG/PNG/WebP)</small>
                            <button type="button" class="btn btn-sm btn-link text-danger mt-2 d-none" id="btn-reset-profile" onclick="resetProfile()">Hapus Foto</button>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top">
                    <button type="submit" class="btn btn-save btn-block shadow-primary">
                        <i class="fas fa-check-circle mr-2"></i> Daftarkan Pengguna
                    </button>
                    <a href="<?= url_to('manageUsers') ?>" class="btn btn-link btn-block text-muted small">Batal & Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function toggleLevel() {
        const role = document.getElementById('roleSelect').value;
        const levelGroup = document.getElementById('levelGroup');
        
        if (role === 'admin') {
            levelGroup.style.display = 'none'; // Sembunyikan jika admin
        } else {
            levelGroup.style.display = 'block'; // Munculkan jika user
        }
    }
    
    // Jalankan saat halaman pertama kali dimuat untuk sinkronisasi data 'old'
    document.addEventListener('DOMContentLoaded', toggleLevel);

        // Logic Preview Gambar
        function previewImage() {
        const file = document.querySelector('#ProfileImg');
        const imgPreview = document.querySelector('#profile-preview');
        const label = document.querySelector('.custom-file-label');
        const resetBtn = document.querySelector('#btn-reset-profile');

        label.textContent = file.files[0].name;
        resetBtn.classList.remove('d-none');

        const fileReader = new FileReader();
        fileReader.readAsDataURL(file.files[0]);
        fileReader.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }

    function resetProfile() {
        const file = document.querySelector('#ProfileImg');
        const imgPreview = document.querySelector('#profile-preview');
        const label = document.querySelector('.custom-file-label');
        const resetBtn = document.querySelector('#btn-reset-profile');

        file.value = '';
        label.textContent = 'Pilih Foto...';
        imgPreview.src = '<?= base_url('assets/images/default_profile.jpg') ?>';
        resetBtn.classList.add('d-none');
    }

    // Logic Sembunyikan Level jika Admin
    function toggleLevel() {
        const role = document.getElementById('roleSelect').value;
        const levelGroup = document.getElementById('levelGroup');
        levelGroup.style.display = (role === 'admin') ? 'none' : 'block';
    }

    // Jalankan saat load
    document.addEventListener('DOMContentLoaded', toggleLevel);
</script>
</script>
<?= $this->endSection() ?>