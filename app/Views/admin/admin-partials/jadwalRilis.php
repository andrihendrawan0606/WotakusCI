<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Main Layout */
    .main-container { padding: 30px; max-width: 100%; }
    .schedule-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: #fff; overflow: hidden; margin-bottom: 30px; }
    .card-header-custom { padding: 25px 30px; background: #fff; border-bottom: 1px solid #f1f3f9; }
    
    /* Form Styling */
    .form-section { padding: 30px; background: #fcfdff; border-bottom: 1px solid #f1f3f9; }
    .form-label-custom { font-weight: 700; font-size: 13px; color: #8898aa; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; display: block; }
    
    /* Input & Select Styling */
    .bootstrap-select .btn { 
        background: #fff !important; 
        border: 1px solid #dee2e6 !important; 
        border-radius: 12px !important; 
        padding: 12px 15px !important; 
        font-size: 14px !important;
        color: #32325d !important;
    }
    
    .btn-save-schedule { 
        background: #5e72e4; 
        color: white; 
        font-weight: 700; 
        padding: 12px 30px; 
        border-radius: 12px; 
        border: none; 
        transition: 0.3s;
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    }
    .btn-save-schedule:hover { background: #4559d4; transform: translateY(-1px); }

    /* Table Styling */
    .table-modern thead th { 
        background-color: #f8fbff; 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 1px; 
        color: #8898aa; 
        padding: 15px 25px;
        border: none;
    }
    .table-modern tbody td { padding: 20px 25px; vertical-align: middle; border-bottom: 1px solid #f1f3f9; color: #32325d; }
    
    /* Day Badge */
    .badge-day {
        padding: 6px 15px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        background: #e8f2ff;
        color: #2d8cf0;
        text-transform: capitalize;
    }

    /* Delete Button */
    .btn-delete-soft { 
        background: #fff0f0; 
        color: #f5365c; 
        border: none; 
        padding: 8px 15px; 
        border-radius: 10px; 
        font-weight: 600; 
        font-size: 13px;
        transition: 0.3s;
    }
    .btn-delete-soft:hover { background: #f5365c; color: #fff; }
    .text-muted{
        font-size: 13px;
    }
    @media (max-width: 768px) {
    .main-container { padding: 15px; }

    /* 1. Pastikan kotak dropdown mengambil lebar penuh */
    .bootstrap-select { width: 100% !important; }

    /* 2. Container Dropdown Menu */
    .bootstrap-select .dropdown-menu {
        width: 100% !important;
        min-width: 100% !important;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        margin-top: 5px !important;
        padding-top: 0 !important; /* Hapus padding agar searchbox nempel di atas */
        overflow: hidden !important; /* Cegah elemen bocor ke luar kotak */
    }

    /* 3. MENGEMBALIKAN KOTAK SEARCH YANG HILANG */
    .bootstrap-select .bs-searchbox {
        display: block !important; 
        padding: 12px 15px !important;
        background-color: #f8fbff;
        border-bottom: 1px solid #e2e8f0;
        position: sticky; /* Tempelkan kotak pencarian di bagian atas */
        top: 0;
        z-index: 99; /* Pastikan selalu di atas teks list */
    }

    .bootstrap-select .bs-searchbox .form-control {
        border-radius: 8px !important;
        font-size: 13px !important;
        padding: 10px 15px !important;
        height: auto !important;
    }

    /* 4. PERBAIKAN LIST ANIME AGAR BISA DI-SCROLL DENGAN AMAN */
    .bootstrap-select .dropdown-menu .inner {
        max-height: 220px !important; /* Batasi tinggi list agar tidak tertutup keyboard HP */
        overflow-y: auto !important;  /* Izinkan scroll ke bawah */
        padding-bottom: 10px;
    }

    /* 5. Teks turun ke bawah (Wrap) dan gampang diklik */
    .bootstrap-select .dropdown-menu li a {
        padding: 12px 15px !important;
        border-bottom: 1px dashed #f1f3f9;
        white-space: normal !important;
    }

    .bootstrap-select .dropdown-menu li:last-child a {
        border-bottom: none;
    }

    .bootstrap-select .dropdown-menu li a span.text {
        white-space: normal !important;
        word-wrap: break-word !important;
        line-height: 1.5;
        font-size: 13px !important;
        display: block; /* Pastikan teks turun dengan rapi */
    }

    /* Jarak form lainnya */
    .row.align-items-end > div { margin-bottom: 15px !important; }
    .btn-save-schedule { width: 100%; margin-top: 5px; }
}

</style>

<div class="main-container">
    <div class="schedule-card">
        <div class="card-header-custom">
            <h4 class="m-0 font-weight-bold" style="color: #32325d;">
                <i class="fas fa-calendar-alt mr-2 text-primary"></i> Atur Jadwal Rilis
            </h4>
            <small class="text-muted">Kelola hari tayang anime yang sedang On-Going</small>
        </div>

        <!-- Bagian Form -->
        <div class="form-section">
            <form action="<?= url_to('saveJadwalRilis'); ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="row align-items-end">
                    <div class="col-lg-5 mb-3 mb-lg-0">
                        <label class="form-label-custom">Pilih Anime On-Going</label>
                        <select class="form-control selectpicker w-100" data-size="7" data-max-options="10" title="-- Pilih Judul Anime --" data-live-search="true" name="animeOnGoing[]" multiple required>
                            <?php foreach($On_Going_Anime as $item): ?>
                                <option value="<?= $item['id']; ?>"><?= $item['Judul']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-lg-4 mb-3 mb-lg-0">
                        <label class="form-label-custom">Pilih Hari Rilis</label>
                        <select class="form-control selectpicker w-100" title="-- Pilih Hari --" name="hari_rilis" required>
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jumat</option>
                            <option value="sabtu">Sabtu</option>
                            <option value="minggu">Minggu</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-3">
                        <button type="submit" class="btn-save-schedule btn-block">
                            <i class="fas fa-save mr-2"></i> Simpan Jadwal
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bagian Tabel -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Judul Anime</th>
                            <th width="20%">Hari Rilis</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($AnimeTayang)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">Belum ada jadwal yang diatur.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($AnimeTayang as $item): ?>
                            <tr>
                                <td class="font-weight-bold"><?= $item['Judul'] ?></td>
                                <td>
                                    <span class="badge-day shadow-sm">
                                        <i class="far fa-clock mr-1"></i> <?= $item['hari_rilis'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="<?= url_to('deleteAnimeJadwal', $item['id']); ?>" method="POST" class="d-inline delete-form">
                                        <?= csrf_field(); ?>
                                        <button type="submit" class="btn-delete-soft">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Konfigurasi Toast (Pop up kecil di pojok)
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    <?php if (session()->getFlashdata('success') || session()->getFlashdata('pesan')) : ?>
        Toast.fire({
            icon: 'success',
            title: '<?= session()->getFlashdata('success') ?? session()->getFlashdata('pesan'); ?>'
        });
    <?php endif; ?>

    // 2. Cek Alert Error
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= session()->getFlashdata('error'); ?>',
            confirmButtonColor: '#5e72e4',
        });
    <?php endif; ?>

    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        const form = this; 

        Swal.fire({
            title: 'Hapus jadwal?',
            text: "Anime ini akan dihapus dari daftar rilis harian.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f5365c',
            cancelButtonColor: '#8898aa',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); 
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
