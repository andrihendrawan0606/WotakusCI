<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    .main-form-container { width: 100% !important; max-width: 1000px; margin: 30px auto; padding: 0 15px; }
    .user-card { background: #ffffff; border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .user-card-header { background: #ffffff; padding: 25px 30px; border-bottom: 1px solid #f1f3f9; }
    .form-section-title { font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: #8898aa; font-weight: 700; margin-bottom: 25px; display: block; border-bottom: 2px solid #ac11e9; width: fit-content; padding-bottom: 5px; }
    
    .custom-group label { font-weight: 600; font-size: 14px; color: #32325d; margin-bottom: 8px; }
    .custom-input-style { border-radius: 12px !important; border: 1px solid #dee2e6 !important; padding: 12px 15px !important; height: auto !important; font-size: 14px; transition: 0.3s; }
    
    .profile-upload-section { text-align: center; padding: 20px; background: #f8f9fe; border-radius: 15px; border: 2px dashed #dee2e6; }
    .avatar-preview-wrapper { width: 150px; height: 150px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; border: 4px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1); background: #eee; }
    #profile-preview { width: 100%; height: 100%; object-fit: cover; }
    
    .btn-update { background: #ac11e9; color: white; font-weight: 700; padding: 12px; border-radius: 12px; border: none; transition: 0.3s; }
    .btn-update:hover { background: #8e0ec2; transform: translateY(-2px); box-shadow: 0 7px 14px rgba(172, 17, 233, .2); }
    .bg-light.custom-input-style {
        background-color: rgba(255, 255, 255, 0.03) !important;
        border: 1px dashed rgba(172, 17, 233, 0.4) !important;
        color: #ac11e9 !important;
        font-weight: 700;
        cursor: not-allowed;
    }
    .custom-input-style.locked-input {
        background-color: rgba(172, 17, 233, 0.05) !important; /* Ungu sangat transparan */
        border: 1px dashed rgba(172, 17, 233, 0.4) !important;
        color: #ac11e9 !important;
        font-weight: 800 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: not-allowed;
    }

    .text-primary-neon {
        color: #ac11e9;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
</style>

<div class="main-form-container">
    <div class="user-card">
        <div class="user-card-header d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold" style="color: #32325d;">
                <i class="fas fa-user-edit mr-2 text-primary"></i> Edit Pengguna
            </h4>
            <span class="badge badge-light px-3 py-2">User ID: #<?= $user['id'] ?></span>
        </div>

        <div class="card-body p-4">
        <form action="<?= url_to('prosesEditUser', $user['id']); ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <!-- Simpan Nama Gambar Lama -->
                <input type="hidden" name="oldProfileImg" value="<?= $user['ProfileImg'] ?>">

                <div class="row">
                    <!-- KOLOM KIRI -->
                    <div class="col-lg-8 pr-lg-4 border-right">
                        <span class="form-section-title">Informasi Akun</span>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control custom-input-style <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" value="<?= old('nama', $user['nama']); ?>">
                                    <div class="invalid-feedback"><?= $validation->getError('nama') ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Alamat Email</label>
                                    <input type="email" name="email" class="form-control custom-input-style <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" value="<?= old('email', $user['email']); ?>">
                                    <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <!-- 1. ROLE / HAK AKSES -->
                        <div class="col-md-4">
                            <div class="form-group custom-group">
                                <label>Role / Hak Akses</label>
                                <?php if ($user['id'] == session()->get('id')) : ?>
                                    <input type="text" class="form-control custom-input-style locked-input" value="Administrator" readonly>
                                    <input type="hidden" name="role" value="admin">
                                    <small class="text-primary-neon mt-1 d-block"><i class="fas fa-lock"></i> Role dilindungi sistem</small>
                                <?php else : ?>
                                    <select name="role" id="roleSelect" class="form-control custom-input-style" onchange="toggleLevel()">
                                        <option value="user" <?= ($user['role'] == 'user') ? 'selected' : '' ?>>User (Member)</option>
                                        <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Administrator</option>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- 2. LEVEL MEMBER -->
                        <div class="col-md-4" id="levelGroup">
                            <div class="form-group custom-group">
                                <label>Level Member</label>
                                <?php if ($user['id'] == session()->get('id')) : ?>
                                    <!-- Admin yang login otomatis PRO selamanya -->
                                    <input type="text" class="form-control custom-input-style locked-input" value="PRO (Permanent)" readonly>
                                    <input type="hidden" name="level" value="Pro">
                                    <small class="text-primary-neon mt-1 d-block"><i class="fas fa-crown"></i> Akses Full Premium</small>
                                <?php else : ?>
                                    <select name="level" class="form-control custom-input-style">
                                        <option value="Basic" <?= ($user['level'] == 'Basic') ? 'selected' : '' ?>>Basic (Gratis)</option>
                                        <option value="Pro" <?= ($user['level'] == 'Pro') ? 'selected' : '' ?>>Pro (Premium)</option>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- 3. STATUS AKUN -->
                        <div class="col-md-4">
                            <div class="form-group custom-group">
                                <label>Status Akun</label>
                                <?php if ($user['id'] == session()->get('id')) : ?>
                                    <input type="text" class="form-control custom-input-style locked-input" value="Aktif (Sistem)" readonly>
                                    <input type="hidden" name="status" value="active">
                                    <small class="text-primary-neon mt-1 d-block"><i class="fas fa-shield-alt"></i> Status tidak dapat diubah</small>
                                <?php else : ?>
                                    <select name="status" class="form-control custom-input-style">
                                        <option value="active" <?= ($user['Status'] == 'active') ? 'selected' : '' ?>>Aktif</option>
                                        <option value="inactive" <?= ($user['Status'] == 'inactive') ? 'selected' : '' ?>>Banned (Non-aktif)</option>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                        <span class="form-section-title mt-4">Keamanan</span>
                        <p class="small text-muted mb-3"><i class="fas fa-info-circle"></i> Kosongkan password jika tidak ingin mengubahnya.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Password Baru</label>
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
                    </div>

                    <!-- KOLOM KANAN -->
                    <div class="col-lg-4 pl-lg-4">
                        <span class="form-section-title">Foto Profil</span>
                        <div class="profile-upload-section">
                            <div class="avatar-preview-wrapper">
                                <img src="<?= base_url('assets/images/' . $user['ProfileImg']) ?>" id="profile-preview">
                            </div>
                            <div class="custom-file text-left">
                                <input type="file" name="ProfileImg" id="ProfileImg" class="custom-file-input" onchange="previewImage()">
                                <label class="custom-file-label" for="ProfileImg">Ganti Foto...</label>
                            </div>
                            <small class="text-muted d-block mt-2">Maks: 2MB (JPG/PNG/WebP)</small>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top">
                    <button type="submit" class="btn btn-update btn-block shadow">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                    <a href="<?= url_to('manageUsers') ?>" class="btn btn-link btn-block text-muted small">Batal & Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage() {
        const file = document.querySelector('#ProfileImg');
        const imgPreview = document.querySelector('#profile-preview');
        const label = document.querySelector('.custom-file-label');

        label.textContent = file.files[0].name;

        const fileReader = new FileReader();
        fileReader.readAsDataURL(file.files[0]);
        fileReader.onload = function(e) { imgPreview.src = e.target.result; }
    }

    function toggleLevel() {
        const role = document.getElementById('roleSelect').value;
        const levelGroup = document.getElementById('levelGroup');
        levelGroup.style.display = (role === 'admin') ? 'none' : 'block';
    }
    document.addEventListener('DOMContentLoaded', toggleLevel);
</script>

<?= $this->endSection() ?>