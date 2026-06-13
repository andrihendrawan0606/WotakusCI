<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<style>
    .main-container { padding: 30px; max-width: 1000px; margin: 0 auto; }
    .log-card { background: #fff; border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 30px; }
    
    .timeline-modern { position: relative; padding-left: 45px; list-style: none; }
    .timeline-modern::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #f1f3f9;
    }

    .log-item { position: relative; margin-bottom: 35px; }
    
    /* Dot/Icon di Timeline */
    .log-dot {
        position: absolute;
        left: -35px;
        top: 5px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #5e72e4;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }
    .log-dot i { font-size: 10px; color: #5e72e4; }

    .log-item.added .log-dot { border-color: #2dce89; }
    .log-item.added .log-dot i { color: #2dce89; }
    .log-item.modified .log-dot { border-color: #11cdef; }
    .log-item.modified .log-dot i { color: #11cdef; }

    .log-content {
        background: #f8fbff;
        padding: 20px;
        border-radius: 15px;
        transition: 0.3s;
        border: 1px solid transparent;
    }
    .log-content:hover {
        background: #fff;
        border-color: #eef2f6;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transform: translateX(5px);
    }
    .log-change-details {
        background-color: rgba(172, 17, 233, 0.05); /* Background ungu sangat tipis */
        border-left: 3px solid #ac11e9; /* Garis aksen ungu di kiri */
        padding: 8px 12px;
        margin-bottom: 12px;
        border-radius: 0 8px 8px 0;
        font-size: 0.85rem;
        color: #555;
        font-weight: 500;
    }

    .log-change-details i {
        color: #ac11e9;
    }

    .log-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
    .admin-badge { background: #e8f2ff; color: #5e72e4; font-weight: 700; font-size: 11px; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; }
    
    .log-title { font-weight: 700; color: #32325d; font-size: 15px; margin-bottom: 5px; display: block; }
    .log-desc { color: #525f7f; font-size: 14px; line-height: 1.6; margin-bottom: 10px; }
    
    .log-time { font-size: 12px; color: #adb5bd; font-weight: 600; display: flex; align-items: center; }
    .log-time i { margin-right: 5px; }

    .item-label { font-size: 12px; font-weight: 700; color: #8898aa; background: #fff; border: 1px solid #eef2f6; padding: 2px 10px; border-radius: 6px; }

    /* Custom Scrollbar untuk Timeline Wrapper */
    .timeline-scroll { max-height: 750px; overflow-y: auto; padding-right: 15px; }
    .timeline-scroll::-webkit-scrollbar { width: 6px; }
    .timeline-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

    .log-filter-container {
    /* Sesuaikan max-width ini dengan lebar kotak putih log Anda */
    max-width: 900px; 
    margin: 0 auto 15px auto; 
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10px;
    }

    .filter-left-area {
        display: flex;
        align-items: center;
        gap: 15px; /* Jarak antara teks "Filter" dan Kotak Select */
        flex-wrap: nowrap; /* Jangan biarkan jatuh ke bawah */
    }
    .log-filter-info {
        display: flex;
        align-items: center;
        white-space: nowrap; /* Jangan biarkan teks terpotong */
    }

    .custom-select-wrapper {
        position: relative;
        width: 220px;
    }

    .modern-filter-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 100%;
        background: #fff;
        border: 1px solid #e2e8f0;
        padding: 8px 35px 8px 15px; /* Ruang untuk ikon panah di kanan */
        border-radius: 8px;
        color: #4a5568;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        outline: none;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .modern-filter-select:hover {
        border-color: #cbd5e1;
    }

    .modern-filter-select:focus {
        border-color: #ac11e9;
        box-shadow: 0 0 0 3px rgba(172, 17, 233, 0.15);
    }
    .select-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        pointer-events: none;
        font-size: 0.8rem;
    }

    .select-arrow {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        pointer-events: none; /* Agar klik tembus ke select */
        font-size: 0.8rem;
    }

    /* Tampilan jika log kosong setelah difilter */
    .empty-log-message {
        text-align: center;
        padding: 40px;
        color: #a0aec0;
        font-weight: 600;
        display: none; /* Disembunyikan default */
    }
        /* Responsif Mobile */
    @media (max-width: 768px) {
        .log-filter-container {
            flex-direction: column;
            align-items: stretch; /* Memanjang penuh di HP */
            gap: 15px;
        }
        
        .filter-left-area {
            width: 100%;
            justify-content: space-between;
        }
        
        .custom-select-wrapper {
            width: auto;
            flex: 1; /* Kotak select memenuhi sisa ruang */
        }
    }
</style>

<div class="main-container">
    <div class="text-center mb-5">
        <h2 class="font-weight-bold" style="color: #32325d;">Admin Activity Logs</h2>
        <p class="text-muted small">Catatan riwayat aktivitas seluruh administrator sistem</p>
    </div>

<!-- ============================================== -->
    <!-- FILTER & ACTION BUTTONS (DIPERBAIKI)           -->
    <!-- ============================================== -->
    <div class="log-filter-container d-flex justify-content-between align-items-center">
        
        <!-- Bagian Kiri: Info & Kotak Dropdown -->
        <div class="filter-left-area">
            <div class="log-filter-info">
                <i class="fas fa-filter text-muted mr-2"></i>
                <span class="text-muted font-weight-bold" style="font-size: 0.9rem;">Filter Aktivitas:</span>
            </div>
            
            <div class="custom-select-wrapper">
                <select id="actionFilter" class="modern-filter-select" onchange="filterActivityLogs()">
                    <option value="ALL">Semua Aktivitas</option>
                    <option value="SYNC API">Sync Jikan API</option>
                    <option value="CREATE">Tambah Manual</option>
                    <option value="UPDATE">Update / Edit Data</option>
                    <option value="DELETE">Hapus Data</option>
                    <option value="LOGIN">Admin Login</option>
                </select>
                <i class="fas fa-chevron-down select-icon"></i>
            </div>
        </div>

        <!-- Bagian Kanan: Tombol Aksi (Download & Purge) -->
        <div class="log-actions d-flex gap-2">
            <a href="<?= url_to('downloadLogsPdf') ?>" target="_blank" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center px-3" style="border-radius: 8px; font-weight: 600;">
                <i class="fas fa-file-pdf mr-2"></i> Export PDF
            </a>
            
            <button type="button" onclick="confirmPurgeLogs()" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center px-3" style="border-radius: 8px; font-weight: 600;" title="Hapus log yang lebih tua dari 90 Hari">
                <i class="fas fa-trash-alt mr-2"></i> Auto-Purge <span class="d-none d-sm-inline ml-1">(90 Hari)</span>
            </button>
        </div>
        
    </div>
    <!-- ============================================== -->

<div class="log-card">
    <div class="timeline-scroll">
        <ul class="timeline-modern">
            <?php if (!empty($logs)): ?>
                <?php foreach ($logs as $log): ?>
                    <?php 
                        $icon = "fa-info-circle";
                        $statusClass = "modified";
                        if(strpos(strtolower($log['description']), 'ditambahkan') !== false) {
                            $icon = "fa-plus-circle";
                            $statusClass = "added";
                        }
                        // Ambil action asli dari DB (misal: 'SYNC API', 'CREATE') dan amankan spasi
                        $dbAction = strtoupper(trim($log['action'])); 
                    ?>
                    
                    <!-- PENTING: data-action dipindah langsung ke LI -->
                    <li class="log-item <?= $statusClass ?>" data-action="<?= $dbAction ?>">
                        <div class="log-dot">
                            <i class="fas <?= $icon ?>"></i>
                        </div>
                        <div class="log-content">
                            <div class="log-header">
                                <span class="admin-badge">
                                    <i class="fas fa-user-shield mr-1"></i> <?= htmlspecialchars($log['admin_name']) ?>
                                </span>
                                <span class="item-label">ID: <?= htmlspecialchars($log['item_id']) ?></span>
                            </div>
                            
                            <span class="log-title"><?= htmlspecialchars($log['item']) ?></span>
                            <p class="log-desc"><?= formatTanggalDalamDeskripsi($log['description']) ?></p>
                            
                            <?php if (!empty($log['change_type'])): ?>
                                <div class="log-change-details">
                                    <i class="fas fa-info-circle mr-1"></i> <?= $log['change_type'] ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="log-time">
                                <i class="far fa-clock"></i> <?= htmlspecialchars(timeAgo($log['created_at'])) ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-light mb-3"></i>
                    <p class="text-muted">Belum ada log aktivitas hari ini.</p>
                </div>
            <?php endif; ?>

            <!-- Pesen jika filter kosong (Sembunyi by default) -->
            <div id="emptyLogMsg" class="text-center py-5" style="display: none;">
                <i class="fas fa-search-minus fa-3x text-light mb-3" style="color: #e2e8f0;"></i>
                <p class="text-muted">Tidak ada log untuk aktivitas ini.</p>
            </div>
            
        </ul>
    </div>
</div>
</div>

<script>
function filterActivityLogs() {
    // 1. Ambil nilai persis dari dropdown (Misal: "SYNC API")
    const filterValue = document.getElementById('actionFilter').value.toUpperCase().trim();
    
    // 2. Ambil semua elemen log (Sekarang kita targetkan tag <li>)
    const logItems = document.querySelectorAll('.log-item'); 
    let visibleCount = 0;

    logItems.forEach(item => {
        // Ambil nilai data-action dari HTML
        const itemAction = item.getAttribute('data-action');
        
        // Logika Tampil/Sembunyi
        if (filterValue === 'ALL') {
            item.style.display = ''; // Munculkan semua
            visibleCount++;
        } else if (itemAction === filterValue) {
            item.style.display = ''; // Munculkan yang cocok
            visibleCount++;
        } else {
            item.style.display = 'none'; // Sembunyikan yang tidak cocok
        }
    });

    // Tampilkan pesan kosong jika tidak ada yang cocok
    const emptyMsg = document.getElementById('emptyLogMsg');
    if (emptyMsg) {
        emptyMsg.style.display = (visibleCount === 0) ? 'block' : 'none';
    }
}

// Fungsi Konfirmasi Hapus Log Lama
function confirmPurgeLogs() {
    Swal.fire({
        title: 'Bersihkan Log Lama?',
        text: "Semua catatan aktivitas yang berumur lebih dari 90 hari akan dihapus permanen. Sangat disarankan untuk meng-Export PDF terlebih dahulu.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Bersihkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            
            Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});

            // Tembak ke Controller
            fetch('<?= url_to('purgeOldLogs') ?>', {
                method: 'POST',
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Info', data.message, 'info');
                }
            })
            .catch(error => Swal.fire('Error', 'Gagal menghubungi server.', 'error'));
        }
    });
}// Fungsi Konfirmasi Hapus Log Lama
function confirmPurgeLogs() {
    Swal.fire({
        title: 'Bersihkan Log Lama?',
        text: "Semua catatan aktivitas yang berumur lebih dari 90 hari akan dihapus permanen. Sangat disarankan untuk meng-Export PDF terlebih dahulu.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Bersihkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            
            Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});

            // Tembak ke Controller
            fetch('<?= url_to('purgeOldLogs') ?>', {
                method: 'POST',
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Info', data.message, 'info');
                }
            })
            .catch(error => Swal.fire('Error', 'Gagal menghubungi server.', 'error'));
        }
    });
}
</script>

<?= $this->endSection() ?>
