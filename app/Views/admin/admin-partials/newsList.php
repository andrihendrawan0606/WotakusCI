<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>


<style>
    .main-container { padding: 30px; }
    .news-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: #fff; overflow: hidden; }
    .news-header { padding: 25px 30px; background: #fff; border-bottom: 1px solid #f1f3f9; display: flex; justify-content: space-between; align-items: center; }
    
    /* Modern Table Styling */
    .table-modern thead th { 
        background-color: #f8fbff; 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 1px; 
        color: #8898aa; 
        border: none;
        padding: 15px 20px;
    }
    .table-modern tbody td { padding: 20px; vertical-align: middle; color: #32325d; border-bottom: 1px solid #f1f3f9; }
    .table-modern tbody tr:hover { background-color: #fcfdff; }
    
    /* Content Styling */
    .news-title { font-weight: 700; color: #32325d; font-size: 15px; display: block; }
    .news-subtitle { font-size: 13px; color: #8898aa; display: block; margin-top: 2px; }
    .badge-author { background: #f0f2ff; color: #5e72e4; padding: 5px 12px; border-radius: 8px; font-weight: 700; font-size: 12px; }
    
    /* Action Buttons */
    .btn-circle { width: 38px; height: 38px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; transition: 0.3s; border: none; }
    .btn-edit-soft { background: #e8f2ff; color: #2d8cf0; }
    .btn-edit-soft:hover { background: #2d8cf0; color: #fff; transform: translateY(-2px); }
    .btn-delete-soft { background: #fff0f0; color: #f5365c; }
    .btn-delete-soft:hover { background: #f5365c; color: #fff; transform: translateY(-2px); }

    @media (max-width: 768px) {
        .news-header { flex-direction: column; align-items: flex-start; gap: 15px; }
        .main-container { padding: 15px; }
    }
</style>

<div class="main-container">
    <div class="news-card">
        <div class="news-header">
            <div>
                <h4 class="m-0 font-weight-bold" style="color: #32325d;">
                    <i class="fas fa-newspaper mr-2 text-primary"></i> Berita & Artikel
                </h4>
                <small class="text-muted">Kelola semua berita terbaru untuk pengunjung</small>
            </div>
            <a href="<?= url_to('TambahNews'); ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus mr-2"></i> Tambah News
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive p-4">
                <table class="table table-modern" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="40%">Informasi Berita</th>
                            <th>Penulis</th>
                            <th>Jadwal Tayang</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($news as $n) : ?>
                        <tr>
                            <td class="text-muted font-weight-bold">#<?= $n['id'] ?></td>
                            <td>
                                <span class="news-title"><?= esc($n['Judul']) ?></span>
                                <span class="news-subtitle text-truncate" style="max-width: 300px;"><?= esc($n['subJudul']) ?></span>
                            </td>
                            <td>
                                <span class="badge-author">
                                    <i class="fas fa-user-edit mr-1"></i> <?= esc($n['author_name']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape icon-sm bg-light text-primary rounded-circle mr-2" style="width:30px; height:30px; display:flex; align-items:center; justify-content:center; font-size:12px;">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                    <span class="small font-weight-bold"><?= format_indo_date($n['waktu_penayangan']); ?></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn-circle btn-edit-soft mr-1" title="Edit Berita">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button class="btn-circle btn-delete-soft" title="Hapus Berita">
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

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "search": "Cari Berita:",
                "lengthMenu": "Tampilkan _MENU_ entri",
                "paginate": {
                    "previous": "<i class='fas fa-angle-left'></i>",
                    "next": "<i class='fas fa-angle-right'></i>"
                }
            }
        });
    });
</script>


<?= $this->endSection() ?>
