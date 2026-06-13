<!-- Gunakan tabel modern yang kita buat untuk Genre sebelumnya -->
<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<!-- Container Utama -->
<!-- Perbaikan Padding Container untuk Mobile (p-4) dan Desktop (md:p-6) -->
<div class="p-4 md:p-6 bg-gray-50 min-h-screen">
    
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 md:p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h4 class="text-xl md:text-2xl font-extrabold text-slate-800">Manajemen Studio</h4>
                <p class="text-slate-500 text-sm mt-1">Kelola data studio produksi anime.</p>
            </div>
            <!-- Perbaikan Tombol: Lebar penuh di Mobile (w-full), menyesuaikan di Desktop (md:w-auto) -->
            <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                <button onclick="syncStudios()" class="w-full md:w-auto px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-emerald-200 flex justify-center items-center">
                    <i class="fas fa-sync-alt mr-2"></i> Sync Global
                </button>
                <button id="openModalManual" class="w-full md:w-auto px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-indigo-200 flex justify-center items-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Manual
                </button>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <!-- Perbaikan Padding untuk Mobile -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-4 md:p-6">
        <table id="studioTable" class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-widest border-b border-gray-100">
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Nama Studio</th>
                    <th class="px-6 py-4">Slug</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                <?php foreach ($studios as $s) : ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <!-- TAMBAHAN PENTING: Tambahkan atribut data-label="..." pada setiap <td> -->
                    <td data-label="ID Studio" class="px-6 py-4 text-slate-400">#<?= $s['id'] ?></td>
                    <td data-label="Nama Studio" class="px-6 py-4 font-bold text-slate-700"><?= esc($s['nama_studio']) ?></td>
                    <td data-label="Slug" class="px-6 py-4">
                        <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded text-xs"><?= $s['slug_studio'] ?></span>
                    </td>
                    <td data-label="Aksi" class="px-6 py-4 text-center">
                        <div class="flex md:justify-center gap-2">
                            <!-- Tombol Edit -->
                            <button class="edit-studio p-2 text-amber-500 hover:bg-amber-50 rounded-lg" 
                                    data-id="<?= $s['id'] ?>" 
                                    data-nama="<?= esc($s['nama_studio']) ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <!-- Tombol Hapus -->
                            <button class="delete-studio p-2 text-rose-500 hover:bg-rose-50 rounded-lg" 
                                    data-id="<?= $s['id'] ?>"
                                    data-nama="<?= esc($s['nama_studio']) ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTables (PASTIKAN ID COCOK)
    const table = $('#studioTable').DataTable({
        "pageLength": 25, // Paginasi per 25 item
        "dom": '<"flex flex-col md:flex-row justify-between gap-4 mb-4"lf>rt<"flex justify-between items-center mt-4"ip>',
        "language": {
            "search": "",
            "searchPlaceholder": "Cari studio...",
            "lengthMenu": "Tampil _MENU_",
        }
    });

    // 2. Fungsi Tambah Manual
    $('#openModalManual').on('click', function() {
        Swal.fire({
            title: 'Tambah Studio',
            input: 'text',
            inputPlaceholder: 'Nama Studio...',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                $.post("<?= url_to('Studios') ?>/store", {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                    nama_studio: result.value
                }, () => location.reload());
            }
        });
    });

    // 3. Fungsi Edit (FIXED)
    $(document).on('click', '.edit-studio', function() {
    const id = $(this).data('id');
    const namaLama = $(this).data('nama');
    
    Swal.fire({
        title: 'Edit Nama Studio',
        input: 'text',
        inputValue: namaLama,
        showCancelButton: true,
        confirmButtonText: 'Update',
        confirmButtonColor: '#4f46e5',
        background: '#fff',
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            Swal.fire({ title: 'Memproses...', didOpen: () => Swal.showLoading() });

            $.ajax({
                url: "<?= base_url('dashboard/studios/update') ?>/" + id,
                method: "POST",
                data: {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                    nama_studio: result.value
                },
                dataType: "json",
                success: function(response) {
                    Swal.fire('Berhasil!', response.message, 'success')
                        .then(() => location.reload());
                },
                error: function(xhr) {
                    // Jika Error 500, ambil pesan error dari JSON yang dikirim Controller
                    let errorMsg = "Terjadi kesalahan sistem.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire('Gagal!', errorMsg, 'error');
                }
            });
        }
    });
});

    // 4. Fungsi Hapus (FIXED)
    $(document).on('click', '.delete-studio', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        
        Swal.fire({
            title: 'Hapus Studio?',
            text: "Yakin ingin menghapus " + nama + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= base_url('dashboard/studios/delete') ?>/" + id, {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                }, () => {
                    Swal.fire('Terhapus!', 'Data telah hilang', 'success').then(() => location.reload());
                });
            }
        });
    });
});

// Fungsi Sync Global (Tetap)
let currentStudioPage = 1;

function syncStudios() {
    Swal.fire({
        title: 'Global Studio Sync',
        text: `Memeriksa data studio halaman ${currentStudioPage}...`,
        icon: 'info',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
            
            fetch(`<?= base_url('dashboard/studios/fetchGlobal') ?>/${currentStudioPage}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.fetched > 0) {
                            // Jika ada data baru yang masuk
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: `${data.fetched} studio baru ditambahkan dari halaman ${currentStudioPage}.`,
                                confirmButtonText: 'Oke'
                            }).then(() => {
                                currentStudioPage++; // Siapkan untuk klik berikutnya
                                location.reload();
                            });
                        } else if (data.has_next) {
                            // JIKA FETCHED 0 TAPI MASIH ADA HALAMAN SELANJUTNYA
                            Swal.fire({
                                title: 'Halaman Sudah Sinkron',
                                text: `Semua studio di halaman ${currentStudioPage} sudah ada di database. Lanjut cari di halaman ${currentStudioPage + 1}?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Lanjut',
                                cancelButtonText: 'Cukup'
                            }).then(res => {
                                if (res.isConfirmed) {
                                    currentStudioPage++; // Naikkan halaman
                                    syncStudios(); // Panggil lagi fungsi ini
                                }
                            });
                        } else {
                            Swal.fire('Selesai!', 'Semua data dari Jikan sudah tersinkron sepenuhnya.', 'success');
                        }
                    }
                })
                .catch(err => {
                    Swal.fire('Error', 'Terjadi kesalahan koneksi atau limit API.', 'error');
                });
        }
    });
}
</script>

<style>
    /* Styling DataTables Default (Desktop) */
    .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 6px 12px;
        outline: none;
    }
    .dataTables_length select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 4px;
    }
    .paginate_button {
        padding: 5px 10px;
        margin: 0 2px;
        border-radius: 8px;
        border: 1px solid #e2e8f0 !important;
        cursor: pointer;
    }
    .paginate_button.current {
        background: #4f46e5 !important;
        color: white !important;
        border-color: #4f46e5 !important;
    }

    /* ==========================================================
       RESPONSIVE MOBILE CSS (MERUBAH TABEL JADI KARTU/CARD)
       ========================================================== */
       @media (max-width: 768px) {
        /* 1. Paksa Wrapper DataTables Full Width */
        .dataTables_wrapper {
            width: 100% !important;
            display: block;
        }

        /* 2. Rapihkan Fitur Search & Length DataTables */
        .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_length {
            text-align: left !important;
            float: none !important;
            width: 100% !important;
            margin-bottom: 12px;
        }
        .dataTables_wrapper .dataTables_filter label {
            display: flex;
            flex-direction: column;
            width: 100%;
            font-size: 0.875rem;
            color: #64748b;
        }
        .dataTables_wrapper .dataTables_filter input {
            width: 100% !important;
            margin-left: 0 !important;
            margin-top: 6px;
            padding: 10px 14px;
            box-sizing: border-box; /* Agar padding tidak merusak lebar */
        }

        /* 3. Sembunyikan Header Tabel */
        table#studioTable thead {
            display: none;
        }

        /* 4. Paksa Tabel dan Body Full Width */
        table#studioTable {
            display: block;
            width: 100% !important;
        }
        
        table#studioTable tbody {
            display: block;
            width: 100% !important;
        }

        /* 5. Ubah Baris (Row) menjadi format Kartu Full Width */
        table#studioTable tbody tr {
            display: block;
            width: 100% !important;
            box-sizing: border-box; /* Sangat penting agar tidak tembus ke kanan */
            margin-bottom: 1rem;
            border: 1px solid #f1f5f9; /* slate-100 */
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            background-color: #fff;
        }

        /* 6. Ubah Kolom (Data) sejajar kiri-kanan */
        table#studioTable tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center; /* Agar teks panjang rapi */
            padding: 0.75rem 1rem !important; /* py-3 px-4 */
            text-align: right;
            border-bottom: 1px dashed #f1f5f9;
        }

        /* Hilangkan garis pada kolom terakhir (Aksi) */
        table#studioTable tbody td:last-child {
            border-bottom: none;
            justify-content: flex-end; /* Tombol rata kanan */
            padding-bottom: 0.75rem !important;
            gap: 10px;
        }

        /* 7. Tampilkan Label menggunakan pseudo-element ::before */
        table#studioTable tbody td::before {
            content: attr(data-label); /* Mengambil teks dari atribut HTML data-label */
            font-weight: 700;
            color: #94a3b8; /* slate-400 */
            font-size: 0.70rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-right: 1rem;
            flex-shrink: 0;
        }
    }
</style>



<?= $this->endSection() ?>