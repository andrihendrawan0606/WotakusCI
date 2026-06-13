<?= $this->extend('admin/admin-partials/index') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .flatpickr-calendar {
    font-family: 'Arial', sans-serif;
    border-radius: 8px;
}
/* Border Kuning untuk Opsional Kosong */
.is-warning {
    border-color: #ffcc00 !important;
    background-color: rgba(255, 204, 0, 0.05) !important;
}

.is-warning:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 204, 0, 0.25) !important;
}

/* Border Merah khusus untuk plugin Selectpicker & Summernote */
.border-danger-custom {
    border: 1px solid #dc3545 !important;
}

.border-warning-custom {
    border: 1px solid #ffcc00 !important;
}
/* Styling Khusus Upload Box Saat Warning/Error */
.upload-box {
    border-radius: 12px;
    padding: 10px;
    transition: all 0.3s ease;
}

.upload-box.border-warning-custom {
    border: 2px dashed #ffcc00 !important;
    background-color: rgba(255, 204, 0, 0.03);
}

.upload-box.border-danger-custom {
    border: 2px dashed #dc3545 !important;
    background-color: rgba(220, 53, 69, 0.03);
}

/* Mempercantik kotak gambar preview */
.img-preview-box {
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
}
/* Modern File Info Badge */
.file-info-badge {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
    margin-bottom: 12px;
    font-size: 0.75rem;
}

.file-info-item {
    background-color: rgba(172, 17, 233, 0.05); /* Ungu transparan */
    color: #4e4e6a; /* Abu-abu keunguan */
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid rgba(172, 17, 233, 0.15);
    font-weight: 600;
    display: inline-flex;
    align-items: center;
}

.file-info-item i {
    color: #ac11e9; /* Ikon Ungu */
    margin-right: 5px;
}
.validation-legend {
    display: none; /* UBAH INI MENJADI NONE */
    background-color: rgba(241, 245, 249, 0.5); /* Abu-abu sangat tipis */
    padding: 10px 15px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    align-items: center;
    transition: opacity 0.3s ease-in-out; /* Tambahkan animasi muncul halus */
    opacity: 0;
}
.validation-legend.show {
    display: inline-flex;
    opacity: 1;
}

.validation-legend .legend-item {
    font-size: 0.8rem;
    display: flex;
    align-items: center;
}

.validation-legend .legend-item i {
    margin-right: 6px;
    font-size: 0.9rem;
}
.text-danger-star {
    color: #e53e3e;
    font-size: 1rem;
    line-height: 1;
    margin-left: 3px;
    vertical-align: middle;
}

/* Label Opsional (Abu-abu Kuning) */
.label-optional {
    font-size: 0.7rem;
    color: #b45309; /* Warna kuning gelap agar mudah dibaca */
    background: #fef3c7; /* Background kuning sangat tipis */
    padding: 2px 6px;
    border-radius: 4px;
    margin-left: 6px;
    font-weight: 600;
    vertical-align: middle;
}

.img-source-toggle {
    display: flex;
    background: rgba(241, 245, 249, 0.5);
    border-radius: 10px;
    padding: 4px;
    margin-bottom: 15px;
    border: 1px solid #e2e8f0;
}

.img-source-toggle input[type="radio"] {
    display: none;
}

.img-source-toggle label {
    flex: 1;
    text-align: center;
    padding: 8px 0;
    margin: 0;
    font-size: 0.8rem;
    font-weight: 700;
    color: #64748b;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

/* Saat radio button dipilih (checked) */
.img-source-toggle input[type="radio"]:checked + label {
    background: #fff;
    color: #ac11e9; /* Ungu Neon */
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
/* Efek saat gambar di-drag ke atas kotak */
.upload-box.dragover {
    background-color: rgba(172, 17, 233, 0.1) !important;
    border: 2px dashed #ac11e9 !important;
    transform: scale(1.02);
}

/* Transisi halus agar efek drag terlihat natural */
.upload-box {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Responsif untuk Mobile */
@media (max-width: 576px) {
    .validation-legend {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        width: 100%;
    }
    .validation-legend .legend-item.ml-3 {
        margin-left: 0 !important;
    }
}
</style>
<div class="main-form-container">
    <div class="anime-card">
        <div class="anime-card-header">
            <h4 class="m-0 font-weight-bold" style="color: #32325d;">
                <i class="fas fa-plus-circle mr-2 text-primary"></i> Tambah Anime Baru
            </h4>
        </div>

        <div class="card-body p-4">
            <!-- ============================================== -->
            <!-- INDIKATOR WARNA (LEGENDA VALIDASI)             -->
            <!-- ============================================== -->
            <div class="validation-legend mb-4">
                <span class="legend-item text-danger font-weight-bold">
                    <i class="fas fa-times-circle"></i> Merah = Wajib Diisi (Form Gagal Simpan)
                </span>
                <span class="legend-item text-warning font-weight-bold ml-3" style="color: #d39e00 !important;">
                    <i class="fas fa-exclamation-triangle"></i> Kuning = Opsional (Boleh Kosong / Auto Default)
                </span>
            </div>
            <!-- ============================================== -->
            <form id="formTambahAnime" action="<?= url_to('prosesTambah'); ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                
                <div class="row">
                    <!-- KOLOM KIRI: DETAIL INFORMASI -->
                    <div class="col-lg-7 pr-lg-5">
                        <span class="form-section-title">Informasi Dasar</span>
                        
                        <div class="form-group custom-group">
                            <label>Judul Utama<span class="text-danger-star">*</span></label>
                            <!-- Tambahkan id="judulAnime" dan event onkeyup -->
                            <input type="text" name="Judul" id="judulAnime" class="form-control custom-input-style <?= ($validation->hasError('Judul')) ? 'is-invalid' : ''; ?>" placeholder="Masukkan judul..." value="<?= old('Judul'); ?>" autofocus onkeyup="checkAnimeDuplicate()">
                            
                            <!-- Ini adalah tempat pesan peringatan muncul -->
                            <small id="judulFeedback" class="form-text mt-2 font-weight-bold" style="display: none;"></small>
                            
                            <div class="invalid-feedback"><?= $validation->getError('Judul') ?></div>
                        </div>

                        <div class="form-group custom-group">
                            <label>Judul Lainnya<span class="label-optional">Opsional</span></label>
                            <input type="text" name="JudulLainnya" class="form-control custom-input-style" placeholder="Judul alternatif..." value="<?= old('JudulLainnya'); ?>">
                        </div>

                        <div class="form-group custom-group">
                            <label>Sinopsis<span class="label-optional">Opsional</span></label>
                            <textarea name="Desc" id="summernote" class="form-control"><?= old('Desc'); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Jumlah Episode<span class="label-optional">Opsional</span></label>
                                    <input type="number" step="1" min="0" name="Eps" class="form-control custom-input-style" value="<?= old('Eps'); ?>" oninput="this.value = Math.abs(Math.floor(this.value));">                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Durasi (Menit)<span class="label-optional">Opsional</span></label>
                                    <input type="number" step="1" min="0" name="Durasi" class="form-control custom-input-style" value="<?= old('Durasi'); ?>" oninput="this.value = Math.abs(Math.floor(this.value));">                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Tanggal Rilis<span class="label-optional">Opsional</span></label>
                                    <input type="text" name="Rilis" class="form-control custom-input-style bg-white" id="Rilis" placeholder="Pilih tanggal...">
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Tanggal Rilis <span class="label-optional">Opsional</span></label>
                                    <?php 
                                        // Di halaman tambah, kita hanya cek nilai old()
                                        $valRilis = old('Rilis');
                                        $formattedDate = '';
                                        if (!empty($valRilis) && $valRilis !== 'TBA') {
                                            $formattedDate = date('Y-m-d', strtotime(substr($valRilis, 0, 10)));
                                        }
                                    ?>
                                    <!-- Gunakan id="Rilis" -->
                                    <input type="text" name="Rilis" class="form-control custom-input-style bg-white" id="Rilis" placeholder="Pilih tanggal..." value="<?= $formattedDate ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Tipe Anime<span class="label-optional">Opsional</span></label>
                                    <select class="form-control selectpicker w-100" name="typeAnime" title="Pilih Tipe">
                                        <?php foreach($typeAnime as $item): ?>
                                            <option value="<?= $item['id'] ?>"><?= $item['tipeAnime'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group custom-group">
                            <label>Genre<span class="label-optional">Opsional</span></label>
                            <select name="genre[]" id="choices-multiple-remove-button" class="form-control" multiple >
                                <?php foreach ($genres as $genre): ?>
                                    <option value="<?= $genre['id'] ?>"><?= $genre['genre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group custom-group">
                            <label>Studio Produksi <strong>* Bisa pilih lebih dari 1</strong><span class="label-optional">Opsional</span></label>
                            <select name="studios[]" class="form-control selectpicker" data-live-search="true" multiple >
                                <?php foreach ($studios as $s): ?>
                                    <option value="<?= $s['id'] ?>" <?= in_array($s['id'], old('studios', [])) ? 'selected' : '' ?>><?= $s['nama_studio'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if($validation->hasError('studios')): ?>
                                <div class="text-danger small mt-1"><?= $validation->getError('studios') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- ========================================== -->
                        <!-- TAMBAHAN: METADATA PRODUKSI (JIKAN API SYNC) -->
                        <!-- ========================================== -->
                        <div class="mt-5 mb-4">
                            <span class="form-section-title d-block mb-3" style="font-size: 0.8rem; border-bottom: 2px dashed #f1f5f9; padding-bottom: 5px;">
                                <i class="fas fa-database text-primary mr-1"></i> Metadata Produksi <strong>(Opsional)</strong>
                            </span>

                            <div class="row">
                                <!-- Source Material -->
                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold small text-muted">Source Material<span class="label-optional">Opsional</span></label>
                                    <select name="source" class="form-control selectpicker" title="-- Pilih Source --">
                                        <option value="Manga" <?= old('source') == 'Manga' ? 'selected' : '' ?>>Manga</option>
                                        <option value="Light Novel" <?= old('source') == 'Light Novel' ? 'selected' : '' ?>>Light Novel</option>
                                        <option value="Original" <?= old('source') == 'Original' ? 'selected' : '' ?>>Original</option>
                                        <option value="Visual Novel" <?= old('source') == 'Visual Novel' ? 'selected' : '' ?>>Visual Novel</option>
                                        <option value="Game" <?= old('source') == 'Game' ? 'selected' : '' ?>>Game</option>
                                        <option value="Web Manga" <?= old('source') == 'Web Manga' ? 'selected' : '' ?>>Web Manga</option>
                                        <option value="Novel" <?= old('source') == 'Novel' ? 'selected' : '' ?>>Novel</option>
                                        <option value="Unknown" <?= old('source') == 'Unknown' ? 'selected' : '' ?>>Lainnya / Unknown</option>
                                    </select>
                                </div>

                                <!-- Season -->
                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold small text-muted">Musim (Season) <span class="label-optional">Opsional</span></label>
                                    <!-- PASTIKAN ADA id="seasonSelect" -->
                                    <select name="season" id="seasonSelect" class="form-control selectpicker" title="-- Pilih Musim --">
                                        <option value="spring" <?= old('season') == 'spring' ? 'selected' : '' ?>>🌸 Spring</option>
                                        <option value="summer" <?= old('season') == 'summer' ? 'selected' : '' ?>>☀️ Summer</option>
                                        <option value="fall" <?= old('season') == 'fall' ? 'selected' : '' ?>>🍂 Fall</option>
                                        <option value="winter" <?= old('season') == 'winter' ? 'selected' : '' ?>>❄️ Winter</option>
                                        <option value="Unknown" <?= old('season') == 'Unknown' ? 'selected' : '' ?>>Unknown</option>
                                    </select>
                                </div>

                                <!-- Release Year -->
                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold small text-muted">Tahun Rilis<span class="label-optional">Opsional</span></label>
                                    <input type="number" min="1960" max="2040" name="release_year" class="form-control custom-input-style" placeholder="Cth: 2024" value="<?= old('release_year'); ?>" onblur="validateYear(this)">                                </div>
                            </div>

                            <div class="row">
                                <!-- MAL ID -->
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold small text-muted">MyAnimeList ID (MAL_ID)<span class="label-optional">Opsional</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-link text-primary"></i></span>
                                        </div>
                                        <!-- Tambahkan id="malIdAnime" dan onkeyup="checkMalIdDuplicate()" -->
                                        <input type="number" name="mal_id" id="malIdAnime" class="form-control custom-input-style" style="border-left: none;" placeholder="Cth: 52991" value="<?= old('mal_id'); ?>" onkeyup="checkMalIdDuplicate()">
                                    </div>
                                    <!-- Tempat memunculkan pesan -->
                                    <small id="malIdFeedback" class="form-text mt-1 font-weight-bold" style="display: none;"></small>
                                </div>

                                <!-- MAL Score -->
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold small text-muted">MAL Score<span class="label-optional">Opsional</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-star text-warning"></i></span>
                                        </div>
                                        <input type="number" step="0.01" min="0" max="10" name="mal_score" class="form-control custom-input-style" style="border-left: none;" placeholder="Cth: 8.75" value="<?= old('mal_score'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ========================================== -->

                    </div>

<!-- KOLOM KANAN: MEDIA & STATUS -->
<div class="col-lg-5">
                        <span class="form-section-title">Media & Status</span>

                        <!-- Status & Seri Terkait ... (Biarkan sama) ... -->
                        <div class="form-group custom-group">
                            <label>Status Tayang <span class="label-optional">Opsional</span></label>
                            <select name="status" class="form-control selectpicker w-100" title="Pilih Status">
                                <option value="Completed">Completed</option>
                                <option value="On-Going">On-Going</option>
                            </select>
                        </div>
                        <div class="form-group custom-group">
                            <label>Seri Terkait <span class="label-optional">Opsional</span></label>
                            <select class="form-control selectpicker w-100" data-live-search="true" name="seriLainnya[]" multiple title="Pilih seri terkait">
                                <?php foreach($animes as $item): ?>
                                    <option value="<?= $item['id'] ?>"><?= $item['Judul'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ============================== -->
                        <!-- UPLOAD BOX: BACKGROUND COVER   -->
                        <!-- ============================== -->
                        <div class="upload-box mt-3" id="wrapperBgCover">
                            <label class="font-weight-bold mb-2 d-block text-dark">
                                <i class="fas fa-image text-primary mr-1"></i> Background Cover <span class="label-optional">Opsional</span>
                            </label>

                            <?php 
                                $bgSourceType = old('bg_source_type', 'upload'); 
                                $isBgUrl = ($bgSourceType === 'url');
                            ?>

                            <!-- Tombol Switch -->
                            <div class="img-source-toggle">
                                <input type="radio" name="bg_source_type" id="bgTypeUpload" value="upload" <?= !$isBgUrl ? 'checked' : '' ?> onchange="toggleImgSource('bg')">
                                <label for="bgTypeUpload"><i class="fas fa-upload mr-1"></i> Upload File</label>
                                
                                <input type="radio" name="bg_source_type" id="bgTypeUrl" value="url" <?= $isBgUrl ? 'checked' : '' ?> onchange="toggleImgSource('bg')">
                                <label for="bgTypeUrl"><i class="fas fa-link mr-1"></i> Gunakan URL</label>
                            </div>

                            <!-- INFO BADGE (Hanya muncul saat tab Upload aktif) -->
                            <div class="file-info-badge" id="bgUploadInfo" style="display: <?= !$isBgUrl ? 'flex' : 'none' ?>;">
                                <span class="file-info-item"><i class="fas fa-weight-hanging"></i> Maks 2 MB</span>
                                <span class="file-info-item"><i class="fas fa-file-image"></i> JPG, PNG, WEBP</span>
                                <span class="file-info-item"><i class="fas fa-expand-arrows-alt"></i> Rasio 16:9</span>
                            </div>

                            <!-- INFO BADGE URL (Hanya muncul saat tab URL aktif) -->
                            <div class="file-info-badge" id="bgUrlInfo" style="display: <?= $isBgUrl ? 'flex' : 'none' ?>;">
                                <span class="file-info-item text-warning" style="background: rgba(255,193,7,0.1); border-color: #ffc107;">
                                    <i class="fas fa-info-circle text-warning"></i> Gunakan link stabil (MAL, Imgur, dsb)
                                </span>
                            </div>

                            <!-- AREA UPLOAD LOCAL -->
                            <div id="bgUploadArea" class="custom-file text-left" style="display: <?= !$isBgUrl ? 'block' : 'none' ?>;">
                                <input type="file" name="BackgroundCoverFile" id="fileBackgroundCover" class="custom-file-input" accept="image/jpeg, image/png, image/webp" onchange="previewImg('img-preview', 'fileBackgroundCover', 'btn-reset-background-cover')">
                                <label class="custom-file-label" for="fileBackgroundCover">Pilih file...</label>
                            </div>

                            <!-- AREA INPUT URL -->
                            <div id="bgUrlArea" class="text-left" style="display: <?= $isBgUrl ? 'block' : 'none' ?>;">
                                <input type="url" name="BackgroundCoverUrl" id="urlBackgroundCover" class="form-control custom-input-style" placeholder="Paste link gambar (https://...)" value="<?= old('BackgroundCoverUrl') ?>" oninput="previewImgUrl('img-preview', this.value, 'default3.jpg')">
                            </div>
                            
                            <div class="position-relative mt-3 text-center">
                                <img src="<?= old('BackgroundCoverUrl', '/assets/images/default3.jpg') ?>" id="img-preview" class="img-preview-box" style="height: 150px; width: 100%; object-fit: cover;">
                            </div>
                            <div class="feedback-placeholder text-center mt-2"></div>
                        </div>

                        <!-- ============================== -->
                        <!-- UPLOAD BOX: POSTER UTAMA       -->
                        <!-- ============================== -->
                        <div class="upload-box mt-4" id="wrapperPoster">
                            <label class="font-weight-bold mb-2 d-block text-dark">
                                <i class="fas fa-portrait text-primary mr-1"></i> Poster Utama <span class="label-optional">Opsional</span>
                            </label>

                            <?php 
                                $posterSourceType = old('poster_source_type', 'upload'); 
                                $isPosterUrl = ($posterSourceType === 'url');
                            ?>

                            <!-- Tombol Switch -->
                            <div class="img-source-toggle">
                                <input type="radio" name="poster_source_type" id="posterTypeUpload" value="upload" <?= !$isPosterUrl ? 'checked' : '' ?> onchange="toggleImgSource('poster')">
                                <label for="posterTypeUpload"><i class="fas fa-upload mr-1"></i> Upload File</label>
                                
                                <input type="radio" name="poster_source_type" id="posterTypeUrl" value="url" <?= $isPosterUrl ? 'checked' : '' ?> onchange="toggleImgSource('poster')">
                                <label for="posterTypeUrl"><i class="fas fa-link mr-1"></i> Gunakan URL</label>
                            </div>

                            <!-- INFO BADGE UPLOAD -->
                            <div class="file-info-badge" id="posterUploadInfo" style="display: <?= !$isPosterUrl ? 'flex' : 'none' ?>;">
                                <span class="file-info-item"><i class="fas fa-weight-hanging"></i> Maks 2 MB</span>
                                <span class="file-info-item"><i class="fas fa-file-image"></i> JPG, PNG, WEBP</span>
                                <span class="file-info-item"><i class="fas fa-mobile-alt"></i> Rasio 3:4 (Portrait)</span>
                            </div>

                            <!-- INFO BADGE URL -->
                            <div class="file-info-badge" id="posterUrlInfo" style="display: <?= $isPosterUrl ? 'flex' : 'none' ?>;">
                                <span class="file-info-item text-warning" style="background: rgba(255,193,7,0.1); border-color: #ffc107;">
                                    <i class="fas fa-info-circle text-warning"></i> Gunakan link stabil (MAL, Imgur, dsb)
                                </span>
                            </div>

                            <!-- AREA UPLOAD LOCAL -->
                            <div id="posterUploadArea" class="custom-file text-left" style="display: <?= !$isPosterUrl ? 'block' : 'none' ?>;">
                                <input type="file" name="PosterFile" id="Poster" class="custom-file-input" accept="image/jpeg, image/png, image/webp" onchange="previewImgPoster()">
                                <label class="custom-file-label" for="Poster">Pilih file...</label>
                            </div>

                            <!-- AREA INPUT URL -->
                            <div id="posterUrlArea" class="text-left" style="display: <?= $isPosterUrl ? 'block' : 'none' ?>;">
                                <input type="url" name="PosterUrl" id="urlPoster" class="form-control custom-input-style" placeholder="Paste link gambar (https://...)" value="<?= old('PosterUrl') ?>" oninput="previewImgUrl('img-preview-poster', this.value, 'default1.jpg')">
                            </div>
                            
                            <div class="position-relative mt-3 text-center">
                                <img src="<?= old('PosterUrl', '/assets/images/default1.jpg') ?>" id="img-preview-poster" class="img-preview-box" style="max-height: 250px; width: auto; border-radius: 12px;">
                            </div>
                            <div class="feedback-placeholder text-center mt-2"></div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-save btn-block">
                                <i class="fas fa-check-circle mr-2"></i> Simpan Data Anime
                            </button>
                            <a href="<?= url_to('dashboard') ?>" class="btn btn-light btn-block mt-3" style="border-radius: 12px; font-weight: 600;">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // ==========================================
    // 1. VARIABEL GLOBAL & FUNGSI HELPER
    // ==========================================
    let typingTimer; 
    let typingTimerMal; 
    const doneTypingInterval = 500; 
    let isTitleDuplicate = false; 
    let isMalIdDuplicate = false; 

    // Fungsi Toggle Gambar (Upload vs URL)
    window.toggleImgSource = function(type) {
        let uploadArea, urlArea, radioUpload, infoUpload, infoUrl;
        
        if (type === 'bg') {
            uploadArea = document.getElementById('bgUploadArea');
            urlArea = document.getElementById('bgUrlArea');
            radioUpload = document.getElementById('bgTypeUpload');
            infoUpload = document.getElementById('bgUploadInfo');
            infoUrl = document.getElementById('bgUrlInfo');
        } else if (type === 'poster') {
            uploadArea = document.getElementById('posterUploadArea');
            urlArea = document.getElementById('posterUrlArea');
            radioUpload = document.getElementById('posterTypeUpload');
            infoUpload = document.getElementById('posterUploadInfo');
            infoUrl = document.getElementById('posterUrlInfo');
        }

        if (radioUpload && radioUpload.checked) {
            if(uploadArea) uploadArea.style.display = 'block';
            if(urlArea) urlArea.style.display = 'none';
            if(infoUpload) infoUpload.style.display = 'flex'; // Munculkan badge upload
            if(infoUrl) infoUrl.style.display = 'none';
        } else {
            if(uploadArea) uploadArea.style.display = 'none';
            if(urlArea) urlArea.style.display = 'block';
            if(infoUpload) infoUpload.style.display = 'none';
            if(infoUrl) infoUrl.style.display = 'flex'; // Munculkan badge peringatan URL
        }
    };

    // Fungsi Preview URL Gambar
    window.previewImgUrl = function(previewId, urlValue, defaultImg) {
        const preview = document.getElementById(previewId);
        if (!preview) return;
        if (urlValue.trim() !== '' && urlValue.startsWith('http')) {
            preview.src = urlValue; 
        } else {
            preview.src = '<?= base_url('assets/images/') ?>' + defaultImg; 
        }
    };

    // Validasi Angka (MAL Score & Tahun)
    window.validateMalScore = function(input) {
        if (input.value !== '') {
            let val = parseFloat(input.value);
            if (val > 10) input.value = 10;
            if (val < 0) input.value = 0;
        }
    };
    window.validateYear = function(input) {
        if (input.value !== '') {
            let year = parseInt(input.value);
            if (year < 1960) input.value = 1960;
            if (year > 2040) input.value = 2040;
        }
    };

    // ==========================================
    // 2. FUNGSI CEK DUPLIKAT (AJAX REAL-TIME)
    // ==========================================
    window.checkAnimeDuplicate = function() {
        clearTimeout(typingTimer); 
        const judulInput = document.getElementById('judulAnime');
        const feedbackText = document.getElementById('judulFeedback');
        
        if (!judulInput || !feedbackText) return;

        const judulValue = judulInput.value.trim();
        if (judulValue.length === 0) {
            feedbackText.style.display = 'none';
            judulInput.classList.remove('is-invalid', 'is-valid');
            isTitleDuplicate = false; 
            return;
        }

        typingTimer = setTimeout(function() {
            feedbackText.style.display = 'block';
            feedbackText.className = 'form-text mt-2 font-weight-bold text-muted';
            feedbackText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengecek ketersediaan judul...';

            fetch(`<?= base_url('dashboard/checkDuplicateTitle') ?>?judul=${encodeURIComponent(judulValue)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'duplicate') {
                        feedbackText.className = 'form-text mt-2 font-weight-bold text-danger';
                        feedbackText.innerHTML = data.message;
                        judulInput.classList.add('is-invalid');
                        judulInput.classList.remove('is-valid');
                        isTitleDuplicate = true; 
                    } else {
                        feedbackText.className = 'form-text mt-2 font-weight-bold text-success';
                        feedbackText.innerHTML = data.message;
                        judulInput.classList.add('is-valid');
                        judulInput.classList.remove('is-invalid');
                        isTitleDuplicate = false; 
                    }
                }).catch(() => { feedbackText.style.display = 'none'; });
        }, doneTypingInterval);
    };

    window.checkMalIdDuplicate = function() {
        clearTimeout(typingTimerMal); 
        const malInput = document.getElementById('malIdAnime');
        const feedbackText = document.getElementById('malIdFeedback');
        
        if (!malInput || !feedbackText) return;

        const malValue = malInput.value.trim();
        if (malValue.length === 0) {
            feedbackText.style.display = 'none';
            malInput.classList.remove('is-invalid', 'is-valid');
            isMalIdDuplicate = false; 
            return;
        }

        typingTimerMal = setTimeout(function() {
            feedbackText.style.display = 'block';
            feedbackText.className = 'form-text mt-1 font-weight-bold text-muted';
            feedbackText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengecek MAL ID...';

            fetch(`<?= base_url('dashboard/checkDuplicateMalId') ?>?mal_id=${encodeURIComponent(malValue)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'duplicate') {
                        feedbackText.className = 'form-text mt-1 font-weight-bold text-danger';
                        feedbackText.innerHTML = data.message; 
                        malInput.classList.add('is-invalid');
                        malInput.classList.remove('is-valid');
                        isMalIdDuplicate = true; 
                    } else if (data.status === 'available') {
                        feedbackText.className = 'form-text mt-1 font-weight-bold text-success';
                        feedbackText.innerHTML = data.message;
                        malInput.classList.add('is-valid');
                        malInput.classList.remove('is-invalid');
                        isMalIdDuplicate = false; 
                    }
                }).catch(() => { feedbackText.style.display = 'none'; });
        }, doneTypingInterval);
    };

    // ==========================================
    // 3. INISIALISASI FLATPICKR + AUTO SEASON
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const rilisInput = document.getElementById("Rilis"); 
            const seasonSelect = document.getElementById("seasonSelect");
            
            if (rilisInput) {
                if (rilisInput._flatpickr) rilisInput._flatpickr.destroy();
                flatpickr(rilisInput, {
                    dateFormat: "Y-m-d", altInput: true, altFormat: "F j, Y", allowInput: true,    
                    minDate: "1960-01-01", maxDate: "2040-12-31",
                    defaultDate: rilisInput.value ? rilisInput.value : null,
                    onChange: function(selectedDates) {
                        if (selectedDates.length > 0 && seasonSelect) {
                            const month = selectedDates[0].getMonth() + 1; 
                            let seasonValue = "Unknown";
                            if (month >= 1 && month <= 3) seasonValue = "winter";
                            else if (month >= 4 && month <= 6) seasonValue = "spring";
                            else if (month >= 7 && month <= 9) seasonValue = "summer";
                            else if (month >= 10 && month <= 12) seasonValue = "fall";

                            seasonSelect.value = seasonValue;
                            seasonSelect.dispatchEvent(new Event('change', { bubbles: true }));
                            if (window.jQuery && $.fn.selectpicker) $(seasonSelect).selectpicker('refresh');
                        }
                    }
                });
            }
        }, 300);
    });

    // ==========================================
    // 4. LOGIKA UTAMA SUBMIT & VALIDASI FORM
    // ==========================================
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('formTambahAnime');
        
        function addFeedbackText(element, isWarning = false, customText = "") {
            let parent = element.parentElement;
            if(!parent) return;
            let oldFeedback = parent.querySelector('.custom-feedback-msg');
            if (oldFeedback) oldFeedback.remove();

            let msg = document.createElement('small');
            msg.className = 'custom-feedback-msg mt-1 font-weight-bold d-block';
            
            if (isWarning) {
                msg.style.color = '#d39e00'; 
                msg.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${customText || 'Belum diisi (Data akan diset default).'}`;
            } else {
                msg.style.color = '#dc3545'; 
                msg.innerHTML = `<i class="fas fa-times-circle"></i> ${customText || 'Field ini WAJIB diisi!'}`;
            }
            parent.appendChild(msg);
        }

        function removeFeedbackOnInput() {
            document.querySelectorAll('#formTambahAnime input, #formTambahAnime textarea').forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid', 'is-warning');
                    const feedback = this.parentElement.querySelector('.custom-feedback-msg');
                    if (feedback) feedback.remove();
                    const legendBox = document.querySelector('.validation-legend');
                    if (legendBox) legendBox.classList.remove('show');
                });
            });
            document.querySelectorAll('#formTambahAnime select').forEach(select => {
                select.addEventListener('change', function() {
                    const btn = this.parentElement.querySelector('.btn.dropdown-toggle');
                    if (btn) btn.classList.remove('border-danger-custom', 'border-warning-custom');
                    const choicesContainer = this.closest('.choices');
                    if (choicesContainer) choicesContainer.classList.remove('border-warning-custom');
                    const feedback = (this.closest('.form-group') || this.parentElement).querySelector('.custom-feedback-msg');
                    if (feedback) feedback.remove();
                });
            });
            document.querySelectorAll('#formTambahAnime input[type="file"]').forEach(fileInput => {
                fileInput.addEventListener('change', function() {
                    const wrapper = this.closest('.upload-box');
                    if (wrapper) {
                        wrapper.classList.remove('border-danger-custom', 'border-warning-custom');
                        const feedback = wrapper.querySelector('.feedback-placeholder');
                        if (feedback) feedback.innerHTML = '';
                    }
                });
            });
        }

        setupDragAndDrop('wrapperBgCover', 'fileBackgroundCover', 'img-preview', 'btn-reset-background-cover');

        // Aktifkan Drag & Drop untuk Poster
        setupDragAndDrop('wrapperPoster', 'Poster', 'img-preview-poster', 'btn-reset-poster');

        removeFeedbackOnInput();

        if (form) {
            form.setAttribute('novalidate', true);

            form.addEventListener('submit', function(e) {
                // TAHAN DULU SEMUA, GUNAKAN TRY-CATCH AGAR KEBAL ERROR
                try {
                    let isFormValid = true; 
                    let errorMessages = []; 

                    const optionalInputs = ['JudulLainnya', 'Eps', 'Durasi', 'Rilis', 'release_year', 'mal_id', 'mal_score'];
                    const optionalSelects = ['typeAnime', 'status', 'source', 'season', 'seriLainnya[]'];

                    // Bersihkan warna merah/kuning lama
                    document.querySelectorAll('.is-invalid, .is-warning, .border-danger-custom, .border-warning-custom').forEach(el => {
                        el.classList.remove('is-invalid', 'is-warning', 'border-danger-custom', 'border-warning-custom');
                    });
                    document.querySelectorAll('.custom-feedback-msg').forEach(el => el.remove());

                    // --- A. CEK JUDUL (WAJIB & TIDAK DUPLIKAT) ---
                    let judulInput = document.querySelector('[name="Judul"]');
                    if (judulInput) {
                        if (judulInput.value.trim() === '') {
                            judulInput.classList.add('is-invalid');
                            addFeedbackText(judulInput, false, "Judul Utama Mutlak Wajib Diisi!");
                            errorMessages.push("<b>Judul Utama</b> masih kosong.");
                            isFormValid = false;
                        } else if (isTitleDuplicate) {
                            judulInput.classList.add('is-invalid');
                            errorMessages.push("<b>Judul Utama</b> sudah ada di database!");
                            isFormValid = false;
                        }
                    }

                    // --- B. CEK MAL ID ---
                    let malInput = document.getElementById('malIdAnime');
                    if (isMalIdDuplicate) {
                        if(malInput) malInput.classList.add('is-invalid');
                        errorMessages.push("<b>MAL ID</b> sudah terdaftar pada anime lain!");
                        isFormValid = false;
                    }

                    // --- C. CEK GAMBAR (Maks 2MB) HANYA JIKA TAB "UPLOAD" AKTIF ---
                    const MAX_FILE_SIZE = 2 * 1024 * 1024; 
                    
                    // Cek Background Cover
                    let bgTypeUpload = document.getElementById('bgTypeUpload');
                    if (bgTypeUpload && bgTypeUpload.checked) {
                        let bgInput = document.getElementById('fileBackgroundCover');
                        if (bgInput && bgInput.files.length > 0 && bgInput.files[0].size > MAX_FILE_SIZE) {
                            let wrapperBg = document.getElementById('wrapperBgCover');
                            if(wrapperBg) wrapperBg.classList.add('border-danger-custom');
                            
                            let fbPlace = wrapperBg ? wrapperBg.querySelector('.feedback-placeholder') : null;
                            if(fbPlace) fbPlace.innerHTML = `<small class="text-danger font-weight-bold"><i class="fas fa-times-circle"></i> Ukuran Background Cover melebihi 2MB!</small>`;
                            
                            errorMessages.push("Ukuran <b>Background Cover</b> melebihi 2MB.");
                            isFormValid = false;
                        }
                        // Cek jika gambar masih default di tab upload
                        const imgPreviewSrc = document.getElementById('img-preview')?.getAttribute('src') || '';
                        if (bgInput && bgInput.files.length === 0 && imgPreviewSrc.includes('default3.jpg')) {
                            let wrapperBg = document.getElementById('wrapperBgCover');
                            if(wrapperBg) wrapperBg.classList.add('border-warning-custom');
                            let fbPlace = wrapperBg ? wrapperBg.querySelector('.feedback-placeholder') : null;
                            if(fbPlace) fbPlace.innerHTML = `<small class="text-warning font-weight-bold"><i class="fas fa-exclamation-triangle"></i> Background Default Digunakan.</small>`;
                        }
                    }

                    // Cek Poster Utama
                    let posterTypeUpload = document.getElementById('posterTypeUpload');
                    if (posterTypeUpload && posterTypeUpload.checked) {
                        let posterInput = document.getElementById('Poster');
                        if (posterInput && posterInput.files.length > 0 && posterInput.files[0].size > MAX_FILE_SIZE) {
                            let wrapperPoster = document.getElementById('wrapperPoster');
                            if(wrapperPoster) wrapperPoster.classList.add('border-danger-custom');
                            
                            let fbPlace = wrapperPoster ? wrapperPoster.querySelector('.feedback-placeholder') : null;
                            if(fbPlace) fbPlace.innerHTML = `<small class="text-danger font-weight-bold"><i class="fas fa-times-circle"></i> Ukuran Poster Utama melebihi 2MB!</small>`;
                            
                            errorMessages.push("Ukuran <b>Poster Utama</b> melebihi 2MB.");
                            isFormValid = false;
                        }
                        // Cek jika gambar masih default di tab upload
                        const imgPosterSrc = document.getElementById('img-preview-poster')?.getAttribute('src') || '';
                        if (posterInput && posterInput.files.length === 0 && imgPosterSrc.includes('default1.jpg')) {
                            let wrapperPoster = document.getElementById('wrapperPoster');
                            if(wrapperPoster) wrapperPoster.classList.add('border-warning-custom');
                            let fbPlace = wrapperPoster ? wrapperPoster.querySelector('.feedback-placeholder') : null;
                            if(fbPlace) fbPlace.innerHTML = `<small class="text-warning font-weight-bold"><i class="fas fa-exclamation-triangle"></i> Poster Default Digunakan.</small>`;
                        }
                    }

                    // --- D. CEK INPUT KUNING (OPSIONAL) ---
                    optionalInputs.forEach(name => {
                        let el = document.querySelector(`[name="${name}"]`);
                        if (el && el.value.trim() === '') {
                            el.classList.add('is-warning');
                            addFeedbackText(el, true);
                        }
                    });

                    optionalSelects.forEach(name => {
                        let selectEl = document.querySelector(`select[name="${name}"]`);
                        if (selectEl && (selectEl.value === '' || selectEl.value === 'Unknown')) {
                            let btn = selectEl.parentElement.querySelector('.btn.dropdown-toggle');
                            if (btn) {
                                btn.classList.add('border-warning-custom');
                                addFeedbackText(btn, true, "Belum dipilih.");
                            }
                        }
                    });

                    // (Opsional) Cek Genre, Studio, Summernote kuning bisa di sini...

                    // --- E. KESIMPULAN AKHIR ---
                    if (!isFormValid) {
                        e.preventDefault(); // GAGALKAN FORM KARENA ADA YANG MERAH
                        
                        const legendBox = document.querySelector('.validation-legend');
                        if (legendBox) legendBox.classList.add('show');
                        
                        let alertHtml = '';
                        if (errorMessages.length === 1) {
                            alertHtml = `<div style="text-align: center;">${errorMessages[0]}</div>`;
                        } else {
                            alertHtml = `<ul style="text-align: left; display: inline-block; margin: 0 auto; padding-left: 20px;">`;
                            errorMessages.forEach(msg => { alertHtml += `<li>${msg}</li>`; });
                            alertHtml += `</ul>`;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: alertHtml, 
                            confirmButtonColor: '#ac11e9'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                                setTimeout(() => {
                                    if (judulInput && (judulInput.value.trim() === '' || isTitleDuplicate)) {
                                        judulInput.focus();
                                    }
                                }, 500); 
                            }
                        });

                    } else {
                        // JIKA FORM VALID, TAMPILKAN KONFIRMASI SWEETALERT
                        e.preventDefault(); // Tahan dulu untuk Pop-up konfirmasi

                        Swal.fire({
                            title: 'Simpan Anime?',
                            text: "Pastikan data sudah benar sebelum disimpan.",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#ac11e9',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Ya, Simpan!',
                            cancelButtonText: 'Periksa Kembali',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Menyimpan...',
                                    text: 'Mohon tunggu sebentar.',
                                    allowOutsideClick: false,
                                    didOpen: () => { Swal.showLoading(); }
                                });
                                form.submit(); // Lanjutkan kirim ke server
                            }
                        });
                    }

                } catch (err) {
                    // JIKA ADA JS YANG CRASH, TANGKAP DISINI
                    e.preventDefault(); // Jangan biarkan form reload secara native
                    console.error("Terjadi Error di JS Validasi:", err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Sistem',
                        text: 'Terdapat kendala teknis pada validasi form. Silakan cek console browser (F12).',
                        confirmButtonColor: '#ac11e9'
                    });
                }
        });
    }
});

// --- FUNGSI HELPER DRAG & DROP GAMBAR ---
function setupDragAndDrop(boxId, inputId, previewId, btnResetId) {
    const dropBox = document.getElementById(boxId);
    const fileInput = document.getElementById(inputId);

    if (!dropBox || !fileInput) return;

    // 1. Matikan perilaku bawaan browser (agar browser tidak membuka gambar di tab baru)
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropBox.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // 2. Tambahkan efek visual saat file berada di atas kotak
    ['dragenter', 'dragover'].forEach(eventName => {
        dropBox.addEventListener(eventName, () => {
            dropBox.classList.add('dragover');
        }, false);
    });

    // 3. Hilangkan efek visual saat file keluar kotak
    ['dragleave', 'drop'].forEach(eventName => {
        dropBox.addEventListener(eventName, () => {
            dropBox.classList.remove('dragover');
        }, false);
    });

    // 4. Tangkap file saat di-drop
    dropBox.addEventListener('drop', (e) => {
        let dt = e.dataTransfer;
        let files = dt.files;

        if (files.length > 0) {
            // Masukkan file ke input type="file" secara programatik
            fileInput.files = files;
            
            // Trigger event 'change' agar fungsi previewImg() Anda berjalan otomatis
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    }, false);
}
</script>

<?= $this->endSection() ?>