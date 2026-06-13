<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    /* Konsistensi UI */
    .main-form-container { padding: 30px; max-width: 100%; }
    .news-card { background: #ffffff; border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .news-card-header { background: #ffffff; padding: 25px 30px; border-bottom: 1px solid #f1f3f9; }
    
    /* Input Styling */
    .form-section-title { font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: #8898aa; font-weight: 700; margin-bottom: 20px; display: block; }
    .custom-label { font-weight: 600; font-size: 14px; color: #32325d; margin-bottom: 8px; }
    .custom-input { border-radius: 12px !important; border: 1px solid #dee2e6 !important; padding: 12px 15px !important; height: auto !important; font-size: 14px; transition: 0.3s; }
    .custom-input:focus { border-color: #5e72e4 !important; box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.1) !important; }

    /* Media Upload Area */
    .upload-box { background: #f8f9fe; border: 2px dashed #dee2e6; border-radius: 15px; padding: 20px; text-align: center; transition: 0.3s; }
    .upload-box:hover { border-color: #5e72e4; background: #f0f2ff; }
    .img-preview-news { width: 100%; border-radius: 10px; margin-top: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); object-fit: cover; max-height: 200px; }

    /* Summernote Custom */
    .note-editor.note-frame { border-radius: 12px; border: 1px solid #dee2e6; overflow: hidden; }
    
    .btn-save-news { background: #5e72e4; color: white; font-weight: 700; padding: 15px; border-radius: 12px; border: none; transition: 0.3s; width: 100%; }
    .btn-save-news:hover { background: #4559d4; transform: translateY(-2px); box-shadow: 0 7px 14px rgba(50,50,93,.1); }

    @media (max-width: 991px) { .border-right-lg { border-right: none !important; } }
</style>

<div class="main-form-container">
    <div class="news-card">
        <div class="news-card-header">
            <h4 class="m-0 font-weight-bold" style="color: #32325d;">
                <i class="fas fa-pen-fancy mr-2 text-primary"></i> Tulis Berita Baru
            </h4>
        </div>

        <div class="card-body p-4">
            <form action="<?= url_to('SaveNews'); ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                
                <div class="row">
                    <!-- KOLOM KIRI: KONTEN UTAMA -->
                    <div class="col-lg-8 pr-lg-5 border-right-lg" style="border-right: 1px solid #f1f3f9;">
                        <span class="form-section-title">Isi Berita</span>
                        
                        <div class="form-group mb-4">
                            <label class="custom-label">Judul Berita</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-heading text-muted"></i></span>
                                </div>
                                <input type="text" name="JudulNews" class="form-control custom-input border-left-0" style="border-radius: 0 12px 12px 0 !important;" placeholder="Masukkan judul berita yang menarik..." required autofocus>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="custom-label">Sub Judul / Ringkasan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-quote-left text-muted"></i></span>
                                </div>
                                <input type="text" name="subJudulNews" class="form-control custom-input border-left-0" style="border-radius: 0 12px 12px 0 !important;" placeholder="Ringkasan singkat berita...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="custom-label">Artikel Lengkap</label>
                            <textarea id="summernote" name="isi"></textarea>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: METADATA & MEDIA -->
                    <div class="col-lg-4 pl-lg-5">
                        <span class="form-section-title">Media & Tags</span>

                        <div class="upload-box mb-4">
                            <label class="custom-label d-block text-left">Thumbnail Berita</label>
                            <div class="custom-file text-left">
                                <input type="file" name="previewGambarNews" id="newsimg" class="custom-file-input" onchange="GambarPreviewNews()">
                                <label class="custom-file-label" for="newsimg" id="newsimglabel">Pilih Gambar...</label>
                            </div>
                            <img src="/assets/images/default.jpg" id="img-preview-news" class="img-preview-news">
                        </div>

                        <div class="form-group mb-4">
                            <label class="custom-label">Tags / Kategori</label>
                            <select name="tags[]" id="choices-multiple-remove-button2" class="form-control" multiple required>
                                <?php foreach ($tags as $tag): ?>
                                    <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], old('tags', [])) ? 'selected' : '' ?>><?= $tag['namaTag'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="action-area mt-5 pt-4 border-top">
                            <button type="submit" class="btn-save-news mb-3">
                                <i class="fas fa-paper-plane mr-2"></i> Publikasikan Berita
                            </button>
                            <a href="<?= base_url('newsList') ?>" class="btn btn-link btn-block text-muted small">Batal & Kembali</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function GambarPreviewNews() {
        const file = document.querySelector('#newsimg');
        const label = document.querySelector('#newsimglabel');
        const imgPreview = document.querySelector('#img-preview-news');

        label.textContent = file.files[0].name;

        const fileReader = new FileReader();
        fileReader.readAsDataURL(file.files[0]);

        fileReader.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>

<?= $this->endSection() ?>
