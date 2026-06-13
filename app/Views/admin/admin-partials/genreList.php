<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    .main-container { padding: 30px; }
    .genre-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: #fff; overflow: hidden; }
    .genre-header { padding: 25px 30px; background: #fff; border-bottom: 1px solid #f1f3f9; display: flex; justify-content: space-between; align-items: center; }
    
    /* Modern Table Styling */
    .table-modern thead th { 
        background-color: #f8fbff; 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 1px; 
        color: #8898aa; 
        border-top: none; 
        padding: 15px 20px;
    }
    .table-modern tbody td { padding: 18px 20px; vertical-align: middle; color: #32325d; border-bottom: 1px solid #f1f3f9; }
    .table-modern tbody tr:hover { background-color: #fcfdff; }
    
    /* Action Buttons */
    .btn-circle { width: 35px; height: 35px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; transition: 0.3s; border: none; }
    .btn-edit-soft { background: #e8f2ff; color: #2d8cf0; }
    .btn-edit-soft:hover { background: #2d8cf0; color: #fff; }
    .btn-delete-soft { background: #fff0f0; color: #f5365c; }
    .btn-delete-soft:hover { background: #f5365c; color: #fff; }

    /* SweetAlert Form Customization */
    .swal-input-custom { border-radius: 10px !important; padding: 12px 15px !important; border: 1px solid #dee2e6 !important; margin-top: 10px; }
    .swal-btn-submit { background: #5e72e4 !important; border-radius: 10px !important; padding: 10px 30px !important; font-weight: 600 !important; }
    .text-muted,.badge {
        font-size: 13px;
    }
    @media (max-width: 768px) {
    /* 1. Reset Container & Card agar melebar penuh */
    .main-container { padding: 15px 10px !important; }
    .genre-card { border-radius: 15px; }
    
    /* Hapus padding besar bawaan bootstrap agar tabel tidak tertekan ke tengah */
    .card-body .table-responsive.p-4 {
        padding: 15px !important; 
    }

    /* 2. Header & Tombol Tambah */
    .genre-header {
        flex-direction: column;
        align-items: flex-start;
        padding: 20px 15px;
    }
    .genre-header > div { margin-bottom: 15px; }
    .genre-header button { width: 100%; padding: 12px; }

    /* 3. Perbaiki Posisi Pencarian DataTables agar Rapi */
    div.dataTables_wrapper div.dataTables_filter,
    div.dataTables_wrapper div.dataTables_length {
        text-align: left !important;
        width: 100% !important;
    }
    div.dataTables_wrapper div.dataTables_filter label {
        display: flex;
        flex-direction: column;
        width: 100%;
        font-size: 13px;
        color: #8898aa;
    }
    div.dataTables_wrapper div.dataTables_filter input {
        width: 100% !important;
        margin-left: 0 !important;
        margin-top: 8px;
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid #dee2e6;
        box-sizing: border-box;
    }

    /* 4. TABEL CARD FULL WIDTH */
    .table-modern {
        width: 100% !important; /* Paksa lebar 100% */
        display: block;
    }
    .table-modern thead { display: none; }
    
    .table-modern tbody {
        display: block;
        width: 100%;
    }

    .table-modern tbody tr {
        display: block;
        width: 100%; /* Paksa Card melebar penuh */
        box-sizing: border-box;
        margin-bottom: 15px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        background-color: #fff;
    }

    .table-modern tbody td {
        display: flex;
        justify-content: space-between;
        align-items: flex-start; /* Agar teks panjang turun dengan rapi */
        padding: 12px 0 !important;
        border-bottom: 1px dashed #e2e8f0;
        text-align: right;
    }

    /* Atur label di sebelah kiri */
    .table-modern tbody td::before { 
        font-weight: 700; color: #8898aa; font-size: 11px; 
        text-transform: uppercase; letter-spacing: 0.5px;
        flex-shrink: 0; /* Agar teks label tidak mengecil */
        margin-right: 15px;
    }

    /* Injeksi Nama Label */
    .table-modern tbody td:nth-of-type(1)::before { content: "ID Genre"; }
    .table-modern tbody td:nth-of-type(2)::before { content: "Nama Genre"; }
    .table-modern tbody td:nth-of-type(3)::before { content: "Tanggal Dibuat"; }
    .table-modern tbody td:nth-of-type(4)::before { content: "Aksi"; margin-right: auto; margin-top: 5px; }

    /* 5. Perbaikan khusus bagian Tanggal & Ikon Kalender */
    .table-modern tbody td.text-muted.small {
        display: flex;
        justify-content: space-between;
        align-items: center; /* Ikon dan teks sejajar */
        text-align: right;
    }

    /* 6. Aksi Action Button */
    .table-modern tbody td:last-child {
        border-bottom: none;
        padding-bottom: 0 !important;
        margin-top: 5px;
        justify-content: flex-end; 
        gap: 10px; 
    }
}
</style>

<div class="main-container">
    <div class="genre-card">
        <div class="genre-header">
            <div>
                <h4 class="m-0 font-weight-bold" style="color: #32325d;">Manajemen Genre</h4>
                <small class="text-muted">Total Genre Terdaftar: <span class="badge badge-primary-soft text-primary font-weight-bold"><?= esc($genres) ?></span></small>
            </div>
            <button type="button" id="openModal" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus mr-2"></i> Tambah Genre
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive p-4">
                <table class="table table-modern" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th>Nama Genre</th>
                            <th>Tanggal Dibuat</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($genre as $anime) : ?>
                        <tr>
                            <td class="font-weight-bold text-muted">#<?= $anime['id'] ?></td>
                            <td>
                                <span class="font-weight-bold" style="font-size: 15px; color: #525f7f;"><?= esc($anime['genre']) ?></span>
                            </td>
                            <td class="text-muted small">
                                <i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y, H:i', strtotime($anime['created_at'])) ?>
                            </td>
                            <td class="text-center">
                                <button class="btn-circle btn-edit-soft edit-genre mr-1" 
                                        data-id="<?= $anime['id'] ?>" 
                                        data-slug="<?= $anime['slug_genre'] ?>" 
                                        data-genre="<?= $anime['genre'] ?>" 
                                        title="Edit">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn-circle btn-delete-soft delete-genre" 
                                        data-id="<?= $anime['id'] ?>" 
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "search": "Cari Genre:",
                "lengthMenu": "Tampilkan _MENU_ entri",
                "paginate": {
                    "previous": "<i class='fas fa-angle-left'></i>",
                    "next": "<i class='fas fa-angle-right'></i>"
                }
            }
        });

        <?php if (session()->getFlashdata('pesan')) : ?>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '<?= session()->getFlashdata('pesan'); ?>',
                showConfirmButton: false,
                timer: 3000
            });
        <?php endif; ?>

        // Tambah Genre
        $('#openModal').on('click', function() {
            Swal.fire({
                title: 'Tambah Genre Baru',
                text: 'Masukkan nama genre yang ingin ditambahkan',
                input: 'text',
                inputPlaceholder: 'Contoh: Action, Comedy, dll',
                inputAttributes: { 'class': 'form-control swal-input-custom' },
                showCancelButton: true,
                confirmButtonText: 'Simpan Genre',
                confirmButtonColor: '#5e72e4',
                cancelButtonText: 'Batal',
                buttonsStyling: true,
                customClass: { confirmButton: 'swal-btn-submit' },
                preConfirm: (genre) => {
                    if (!genre) {
                        Swal.showValidationMessage('Nama genre tidak boleh kosong!');
                    }
                    return genre;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= url_to('prosesGenre'); ?>",
                        method: "POST",
                        data: {
                            <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                            genre: result.value
                        },
                        success: function() {
                            Swal.fire('Sukses!', 'Genre berhasil ditambah', 'success').then(() => location.reload());
                        }
                    });
                }
            });
        });

        // Edit Genre
        $(document).on('click', '.edit-genre', function() {
            const slug = $(this).data('slug');
            const genre = $(this).data('genre');

            Swal.fire({
                title: 'Edit Nama Genre',
                input: 'text',
                inputValue: genre,
                showCancelButton: true,
                confirmButtonText: 'Update Genre',
                confirmButtonColor: '#2d8cf0',
                customClass: { confirmButton: 'swal-btn-submit' },
                preConfirm: (newGenre) => {
                    if (!newGenre) { Swal.showValidationMessage('Nama tidak boleh kosong!'); }
                    return newGenre;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= url_to('updateGenre', ''); ?>/" + slug,
                        method: "POST",
                        data: {
                            <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                            genre: result.value
                        },
                        success: function() {
                            Swal.fire('Terupdate!', 'Genre telah diubah', 'success').then(() => location.reload());
                        }
                    });
                }
            });
        });

        // Hapus Genre
        $(document).on('click', '.delete-genre', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Genre?',
                text: "Anime yang menggunakan genre ini mungkin akan terpengaruh.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f5365c',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= url_to('deleteGenre', ''); ?>/" + id,
                        method: "POST",
                        data: { <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                        success: function() {
                            Swal.fire('Dihapus!', 'Genre telah dihapus.', 'success').then(() => location.reload());
                        }
                    });
                }
            });
        });
    });
</script>


<?= $this->endSection() ?>
