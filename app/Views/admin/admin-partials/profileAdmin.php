<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    .profile-container { width: 100% !important; max-width: 900px; margin: 30px auto; padding: 0 15px; }
    
    /* Header Profile Card */
    .profile-card { background: #ffffff; border-radius: 25px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.05); overflow: hidden; }
    
    .profile-cover { height: 160px; background: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/b9245aa6-5972-493f-b911-f805ed5133e0/d7ujd83-55773d95-d287-4f70-b85f-19d941760229.jpg/v1/fill/w_1600,h_900,q_75,strp/kakashi_hatake___youtube_anime_banner_by_raikoufx_d7ujd83-fullview.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9OTAwIiwicGF0aCI6Ii9mL2I5MjQ1YWE2LTU5NzItNDkzZi1iOTExLWY4MDVlZDUxMzNlMC9kN3VqZDgzLTU1NzczZDk1LWQyODctNGY3MC1iODVmLTE5ZDk0MTc2MDIyOS5qcGciLCJ3aWR0aCI6Ijw9MTYwMCJ9XV0sImF1ZCI6WyJ1cm46c2VydmljZTppbWFnZS5vcGVyYXRpb25zIl19.LHkO7SOKDE3N4iNfmaDpHHey-sUcZIJPKNiv2Z3FODM') no-repeat center center fixed; position: relative; }
    
    .avatar-container { position: absolute; bottom: -60px; left: 40px; }
    .avatar-img { width: 130px; height: 130px; border-radius: 30px; border: 5px solid #fff; object-fit: cover; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    
    .profile-header-info { padding: 75px 40px 25px; display: flex; justify-content: space-between; align-items: flex-end; }
    .name-text h2 { font-weight: 800; color: #32325d; margin: 0; }
    .name-text p { color: #8898aa; margin: 0; font-size: 14px; font-weight: 600; }
    
    /* Info Grid */
    .info-grid { padding: 20px 40px 40px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; }
    
    .info-item { background: #f8f9fe; padding: 20px; border-radius: 18px; border: 1px solid #f1f3f9; transition: 0.3s; }
    .info-item:hover { border-color: #ac11e9; background: #fff; transform: translateY(-3px); }
    
    .info-item label { display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #8898aa; font-weight: 800; margin-bottom: 5px; }
    .info-item span { font-size: 15px; color: #32325d; font-weight: 700; }
    .info-item i { color: #ac11e9; margin-right: 8px; font-size: 14px; }

    /* Badges */
    .badge-premium { background: rgba(172, 17, 233, 0.1); color: #ac11e9; border: 1px solid rgba(172, 17, 233, 0.2); padding: 5px 15px; border-radius: 10px; font-size: 12px; font-weight: 800; }

    /* Button Action */
    .btn-edit-profile { background: #ac11e9; color: white !important; font-weight: 700; padding: 12px 25px; border-radius: 15px; transition: 0.3s; box-shadow: 0 4px 15px rgba(172, 17, 233, 0.3); }
    .btn-edit-profile:hover { transform: translateY(-3px); background: #8e0ec2; box-shadow: 0 8px 20px rgba(172, 17, 233, 0.4); }

    @media (max-width: 768px) {
        .info-grid { grid-template-columns: 1fr; }
        .profile-header-info { flex-direction: column; align-items: center; text-align: center; }
        .avatar-container { left: 50%; transform: translateX(-50%); }
    }
</style>

<div class="profile-container">
    <div class="profile-card">
        <!-- Cover Section -->
        <div class="profile-cover">
            <div class="avatar-container">
                <img src="<?= base_url('assets/images/' . $user['ProfileImg']) ?>" class="avatar-img" alt="Profile Image">
            </div>
        </div>

        <!-- Header Info -->
        <div class="profile-header-info">
            <div class="name-text">
                <h2><?= esc($user['nama']) ?></h2>
                <p><i class="fas fa-envelope mr-1"></i> <?= esc($user['email']) ?></p>
            </div>
            <div class="action-btn">
                <a href="<?= url_to('editUser', $user['id']) ?>" class="btn btn-edit-profile">
                    <i class="fas fa-user-edit mr-2"></i> Edit Profil
                </a>
            </div>
        </div>

        <hr class="mx-4 my-0" style="opacity: 0.1;">

        <!-- Detailed Info (Readonly) -->
        <div class="info-grid">
            <div class="info-item">
                <label>Role / Akses</label>
                <span><i class="fas fa-shield-alt"></i> Administrator</span>
            </div>
            <div class="info-item">
                <label>Level Sistem</label>
                <span class="badge-premium"><i class="fas fa-crown"></i> PRO PERMANENT</span>
            </div>
            <div class="info-item">
                <label>Status Akun</label>
                <span class="text-success font-weight-bold"><i class="fas fa-check-circle"></i> AKTIF</span>
            </div>
            <div class="info-item">
                <label>Bergabung Sejak</label>
                <span><i class="fas fa-calendar-day"></i> <?= date('d F Y', strtotime($user['created_at'])) ?></span>
            </div>
            <div class="info-item">
                <label>Login Terakhir</label>
                <span><i class="fas fa-clock"></i> Baru Saja</span>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="<?= url_to('dashboard') ?>" class="text-muted small" style="text-decoration:none;">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<?= $this->endSection() ?>