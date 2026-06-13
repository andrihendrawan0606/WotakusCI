<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    /* Konsistensi Layout */
    .main-container { padding: 30px; }
    .user-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: #fff; overflow: hidden; }
    .user-header { padding: 25px 30px; background: #fff; border-bottom: 1px solid #f1f3f9; display: flex; justify-content: space-between; align-items: center; }
    
    /* Table Styling */
    .table-modern thead th { 
        background-color: #f8fbff; 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 1px; 
        color: #8898aa; 
        border: none;
        padding: 15px 20px;
    }
    .table-modern tbody td { padding: 15px 20px; vertical-align: middle; color: #32325d; border-bottom: 1px solid #f1f3f9; }
    
    /* Avatar Style */
    .avatar-wrapper { display: flex; align-items: center; gap: 15px; }
    .user-avatar { width: 45px; height: 45px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border: 2px solid #fff; }
    .user-info-text { display: flex; flex-direction: column; }
    .user-info-text .name { font-weight: 700; color: #32325d; font-size: 14px; }
    .user-info-text .email { font-size: 12px; color: #8898aa; }

    /* Badges */
    .badge-pill-custom { padding: 6px 12px; border-radius: 50px; font-weight: 800; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; border: none; }
    .bg-soft-admin { background-color: rgba(94, 114, 228, 0.1); color: #5e72e4; }
    .bg-soft-user { background-color: rgba(17, 205, 239, 0.1); color: #11cdef; }
    .bg-soft-active { background-color: rgba(45, 206, 137, 0.1); color: #2dce89; }
    .bg-soft-inactive { background-color: rgba(245, 54, 92, 0.1); color: #f5365c; }

    /* Action Buttons */
    .btn-circle { width: 35px; height: 35px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; transition: 0.3s; border: none; }
    .btn-edit-soft { background: #e8f2ff; color: #2d8cf0; }
    .btn-edit-soft:hover { background: #2d8cf0; color: #fff; transform: translateY(-2px); }
    .btn-delete-soft { background: #fff0f0; color: #f5365c; }
    .btn-delete-soft:hover { background: #f5365c; color: #fff; transform: translateY(-2px); }

    .nav-tabs-custom { border-bottom: 2px solid #f1f3f9; gap: 10px; margin-bottom: 20px; }
    .nav-tabs-custom .nav-link { 
        border: none; color: #8898aa; font-weight: 700; font-size: 14px; 
        padding: 12px 25px; border-radius: 12px 12px 0 0; transition: 0.3s;
    }
    .nav-tabs-custom .nav-link.active { 
        background: transparent; color: #ac11e9; border-bottom: 3px solid #ac11e9; 
    }
    .nav-tabs-custom .nav-link:hover { color: #32325d; }
    
    .badge-count { font-size: 10px; padding: 2px 8px; border-radius: 50px; background: #eee; margin-left: 5px; }
    .active .badge-count { background: rgba(172, 17, 233, 0.1); color: #ac11e9; }

/* ==========================================================
       RESPONSIVE MOBILE KHUSUS MANAJEMEN PENGGUNA
       ========================================================== */
       @media (max-width: 768px) {
        .main-container { padding: 15px 10px !important; }
        
        /* 1. Header & Tombol Tambah User */
        .user-header { flex-direction: column; align-items: flex-start; padding: 20px 15px; }
        .user-header div { margin-bottom: 15px; text-align: left; }
        .user-header .btn { width: 100%; padding: 12px; }

        /* 2. Navigasi Tab (Admin vs Member) */
        .nav-tabs-custom { 
            display: flex; 
            flex-direction: row; 
            flex-wrap: nowrap; /* Jangan biarkan turun ke baris baru */
            overflow-x: auto; /* Bisa digeser ke kanan kiri jika sempit */
            margin-bottom: 15px; 
            border-bottom: 2px solid #f1f3f9;
        }
        .nav-tabs-custom .nav-item { white-space: nowrap; flex: 1; text-align: center; }
        .nav-tabs-custom .nav-link { padding: 10px; font-size: 13px; }
        
        /* Sembunyikan scrollbar pada nav tabs mobile */
        .nav-tabs-custom::-webkit-scrollbar { display: none; }

        /* 3. Rapihkan Box Pencarian DataTables (Jika menggunakan JS DataTables) */
        .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_length {
            text-align: left !important;
            float: none !important;
            width: 100% !important;
            margin-bottom: 10px;
        }
        .dataTables_wrapper .dataTables_filter label {
            display: flex; flex-direction: column; width: 100%;
        }
        .dataTables_wrapper .dataTables_filter input {
            width: 100% !important; margin-left: 0 !important; margin-top: 5px; box-sizing: border-box;
        }

        /* 4. KONVERSI TABEL MENJADI KARTU/CARD */
        .table-modern, .table-modern tbody {
            display: block; width: 100% !important;
        }
        .table-modern thead { display: none; } /* Sembunyikan Judul Kolom */

        .table-modern tbody tr {
            display: block;
            width: 100% !important;
            box-sizing: border-box;
            margin-bottom: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
            background-color: #fff;
        }

        /* 5. Styling Isi Data (TD) */
        .table-modern tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center; /* Teks sejajar kanan-kiri */
            padding: 10px 0 !important;
            border-bottom: 1px solid #c7c2b5;
            text-align: right; /* Default isi rata kanan */
        }
        
        /* Label buatan di sebelah kiri */
        .table-modern tbody td::before { 
            font-weight: 700; color: #8898aa; font-size: 11px; 
            text-transform: uppercase; letter-spacing: 0.5px;
            flex-shrink: 0; margin-right: 15px;
        }

        /* 6. Aturan Khusus Setiap Baris */
        
        /* Baris 1: ID */
        .table-modern tbody td:nth-of-type(1)::before { content: "ID User"; }
        .table-modern tbody td:nth-of-type(1) { padding-top: 0 !important; font-weight: 700;}

        /* Baris 2: Profil & Avatar */
        /* Karena avatar ukurannya besar, kita atur supaya label 'Pengguna' ada di atasnya, bukan sejajar */
        .table-modern tbody td:nth-of-type(2)::before { content: "Profil"; align-self: flex-start; margin-top: 10px;}
        .table-modern tbody td:nth-of-type(2) {
            align-items: flex-start; /* Gambar dan teks rata atas */
        }
        .avatar-wrapper { text-align: left; } /* Teks nama dan email rata kiri */
        
        /* Baris 3: Status / Level */
        .table-modern tbody td:nth-of-type(3)::before { content: "Status Akun / Level"; }

        /* Baris 4: Status Online */
        .table-modern tbody td:nth-of-type(4)::before { content: "Status Online"; }

        /* Baris 5: Last Login (Khusus Admin) */
        .table-modern tbody td:nth-of-type(5):not(:last-child)::before { content: "Last Login"; }

        /* Baris Terakhir: Aksi (Tombol Edit/Hapus) */
        .table-modern tbody td:last-child {
            border-bottom: none;
            padding-bottom: 0 !important;
            margin-top: 10px;
            justify-content: flex-end; /* Tombol geser ke kanan */
            gap: 10px; /* Jarak antar tombol */
        }
        .table-modern tbody td:last-child::before { content: "Aksi"; margin-right: auto; }
    }

</style>

<div class="main-container">
    <div class="user-card">
        <div class="user-header">
            <div>
                <h4 class="m-0 font-weight-bold" style="color: #32325d;">Manajemen Pengguna</h4>
                <small class="text-muted">Kelola hak akses dan status akun member</small>
            </div>
            <a href="<?= url_to('tampilTambahUser') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-user-plus mr-2"></i> Tambah User
            </a>
        </div>

        <div class="p-4">
            <!-- Navigasi Tab -->
            <ul class="nav nav-tabs nav-tabs-custom" id="userTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="admin-tab" data-toggle="tab" href="#admin-section" role="tab">
                        Administrator <span class="badge-count"><?= count(array_filter($users, fn($u) => $u['role'] == 'admin')) ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="member-tab" data-toggle="tab" href="#member-section" role="tab">
                        Member <span class="badge-count"><?= count(array_filter($users, fn($u) => $u['role'] == 'user')) ?></span>
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="userTabContent">
                <!-- PANEL 1: ADMINISTRATOR -->
                <div class="tab-pane fade show active" id="admin-section" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-modern display-table" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Administrator</th>
                                    <th>Status Akun</th>
                                    <th>Status Online</th> <!-- Tambahan -->
                                    <th>Last Login</th>   <!-- Tambahan -->
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $u) : ?>
                                    <?php if($u['role'] == 'admin'): ?>
                                    <tr>
                                        <td>#<?= $u['id'] ?></td>
                                        <td>
                                            <div class="avatar-wrapper">
                                                <img src="<?= base_url('assets/images/' . $u['ProfileImg']) ?>" class="user-avatar">
                                                <div class="user-info-text">
                                                    <span class="name"><?= esc($u['nama']) ?></span>
                                                    <span class="email"><?= esc($u['email']) ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge-pill-custom bg-soft-active">Active</span></td>
                                        <td>
                                            <?php 
                                                $isOnline = false;
                                                if($u['last_activity']){
                                                    $lastActive = strtotime($u['last_activity']);
                                                    $isOnline = (time() - $lastActive) < 300; // 5 menit
                                                }
                                            ?>
                                            <?php if($isOnline): ?>
                                                <span class="badge-pill-custom bg-soft-active"><i class="fas fa-circle mr-1" style="font-size: 8px;"></i> Online</span>
                                            <?php else: ?>
                                                <span class="badge-pill-custom bg-soft-inactive">Offline</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small text-muted">
                                            <?= $u['last_login'] ? date('d M, H:i', strtotime($u['last_login'])) : 'Belum pernah' ?>
                                        </td>

                                        <td class="text-center">
                                            
                                            <!-- LOGIKA PEMBATASAN AKSI -->
                                            <?php if ($u['id'] == session()->get('id')) : ?>
                                                <!-- Jika ID sama dengan ID login, munculkan tombol -->
                                                <a href="<?= url_to('editUser', $u['id']) ?>" class="btn-circle btn-edit-soft mr-1" title="Edit Profil Saya">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button" class="btn-circle btn-delete-soft delete-user" 
                                                        data-id="<?= $u['id'] ?>" 
                                                        data-nama="<?= esc($u['nama']) ?>" title="Hapus Akun Saya">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php else : ?>
                                                <!-- Jika milik Admin lain, tampilkan icon gembok atau teks info -->
                                                <span class="badge badge-light text-muted" style="border-radius: 10px; padding: 5px 15px;">
                                                    <i class="fas fa-lock mr-1"></i> Protected
                                                </span>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PANEL 2: REGULAR MEMBER -->
                <div class="tab-pane fade" id="member-section" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-modern display-table" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Member</th>
                                    <th>Level</th> <!-- Kolom khusus Member -->
                                    <th>Status Akun</th>
                                    <th>Status Online</th> <!-- Tambahan -->
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $u) : ?>
                                    <?php if($u['role'] == 'user'): ?>
                                    <tr>
                                        <td>#<?= $u['id'] ?></td>
                                        <td>
                                            <div class="avatar-wrapper">
                                                <img src="<?= base_url('assets/images/' . $u['ProfileImg']) ?>" class="user-avatar">
                                                <div class="user-info-text">
                                                    <span class="name"><?= esc($u['nama']) ?></span>
                                                    <span class="email"><?= esc($u['email']) ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <!-- Kita tampilkan levelnya (Basic/Pro) -->
                                            <span class="badge-pill-custom <?= ($u['level'] == 'Pro') ? 'bg-soft-admin' : 'bg-soft-user' ?>">
                                                <?= $u['level'] ?? 'Basic' ?>
                                            </span>
                                        </td>
                                        <td><span class="badge-pill-custom <?= ($u['Status'] == 'active') ? 'bg-soft-active' : 'bg-soft-inactive' ?>"><?= $u['Status'] ?></span></td>
                                        <td>
                                            <?php 
                                                $isOnline = false;
                                                if($u['last_activity']){
                                                    $lastActive = strtotime($u['last_activity']);
                                                    $isOnline = (time() - $lastActive) < 300; // 5 menit
                                                }
                                            ?>
                                            <div class="d-flex align-items-center">
                                                <div class="dot <?= $isOnline ? 'dot-online' : 'dot-offline' ?> mr-2"></div>
                                                <span class="small font-weight-bold <?= $isOnline ? 'text-success' : 'text-muted' ?>">
                                                    <?= $isOnline ? 'Active Now' : 'Last: '.timeAgo($u['last_activity']) ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <!-- Tombol Edit (Nanti) -->
                                            <a href="<?= url_to('editUser', $u['id']) ?>" class="btn-circle btn-edit-soft mr-1">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            
                                            <!-- Tombol Hapus: Tambahkan class dan data attributes -->
                                            <button class="btn-circle btn-delete-soft delete-user" 
                                                    data-id="<?= $u['id'] ?>" 
                                                    data-nama="<?= esc($u['nama']) ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script SweetAlert2 & DataTable -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "language": {
                "search": "Cari Pengguna:",
                "lengthMenu": "Tampilkan _MENU_ user",
            }
        });
    });
    // Inisialisasi ID Admin yang sedang login
    const currentAdminId = "<?= session()->get('id') ?>";

    $(document).ready(function() {
        // 1. Inisialisasi DataTable
        $('.display-table').DataTable({
            "language": {
                "search": "Cari Pengguna:",
                "lengthMenu": "Tampilkan _MENU_ user",
            }
        });

        // 2. Event Listener Tombol Tambah User (Link ke halaman)
        // Jika Anda menggunakan halaman khusus, pastikan tombol di HTML adalah tag <a> 
        // Namun jika masih ingin menggunakan modal, kodenya ada di bawah:
        $('#addUser').on('click', function() {
             window.location.href = "<?= url_to('tampilTambahUser') ?>";
        });

        // 3. Event Listener Tombol Hapus User (Gunakan Event Delegation)
        $(document).on('click', '.delete-user', function() {
            const userId = $(this).data('id');
            const userName = $(this).data('nama');

            // Pengaturan Alert Default
            let swalTitle = 'Hapus Pengguna?';
            let swalText = `Apakah Anda yakin ingin menghapus "${userName}"?`;
            let swalIcon = 'warning';
            let confirmText = 'Ya, Hapus!';

            // Pengaturan Alert Khusus jika Menghapus Diri Sendiri
            if (userId == currentAdminId) {
                swalTitle = '<span style="color: #f5365c">Hapus Akun Anda Sendiri?</span>';
                swalText = 'PERHATIAN: Anda akan otomatis keluar (Logout) dan akun ini akan terhapus permanen dari sistem!';
                swalIcon = 'error';
                confirmText = 'Ya, Hapus & Keluar';
            }

            Swal.fire({
                title: swalTitle,
                text: swalText,
                icon: swalIcon,
                showCancelButton: true,
                confirmButtonColor: '#f5365c',
                cancelButtonColor: '#8898aa',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                reverseButtons: true,
                background: '#1a1a1a',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan Loading Spinner
                    Swal.fire({
                        title: 'Sedang memproses...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Eksekusi AJAX ke Server
                    $.ajax({
                        url: "<?= url_to('hapusUser', ''); ?>/" + userId,
                        method: "POST",
                        data: {
                            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                        },
                        dataType: "json",
                        success: function(response) {
                            // Sembunyikan loading memproses
                            Swal.close();

                            if (response.logout) {
                                // Jika menghapus diri sendiri
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Akun Anda telah dihapus. Mengalihkan ke halaman login...',
                                    showConfirmButton: false,
                                    timer: 2500,
                                    background: '#1a1a1a',
                                    color: '#fff'
                                }).then(() => {
                                    window.location.href = "<?= url_to('login') ?>";
                                });
                            } else {
                                // Jika menghapus user/admin lain
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: 'Pengguna berhasil dihapus dari database.',
                                    timer: 1500,
                                    showConfirmButton: false,
                                    background: '#1a1a1a',
                                    color: '#fff'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            // PENTING: Tutup loading jika terjadi error di sisi server (PHP)
                            Swal.close();
                            
                            let errorMessage = "Terjadi kesalahan sistem saat mencoba menghapus data.";
                            
                            // Ambil pesan error spesifik dari server jika ada
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Menghapus',
                                text: errorMessage,
                                confirmButtonColor: '#ac11e9',
                                background: '#1a1a1a',
                                color: '#fff'
                            });
                        }
                    });
                }
            });
        });
    });

$(document).ready(function() {
        // 1. Alert untuk Sukses (Tambah/Edit/Hapus)
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success'); ?>',
                background: '#1a1a1a', // Warna gelap sesuai tema
                color: '#ffffff',
                iconColor: '#ac11e9', // Warna ungu neon
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'anime-swal-popup'
                }
            });
        <?php endif; ?>

        // 2. Alert untuk Pesan (Sama dengan sukses, sebagai cadangan key)
        <?php if (session()->getFlashdata('pesan')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('pesan'); ?>',
                background: '#1a1a1a',
                color: '#ffffff',
                iconColor: '#ac11e9',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        <?php endif; ?>

        // 3. Alert untuk Error/Gagal
        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: '<?= session()->getFlashdata('error'); ?>',
                background: '#1a1a1a',
                color: '#ffffff',
                confirmButtonColor: '#ac11e9'
            });
        <?php endif; ?>
    });
</script>

<?= $this->endSection() ?>