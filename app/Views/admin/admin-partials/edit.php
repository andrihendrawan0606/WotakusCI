<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>


<style>
    .main-form-container { width: 100% !important; max-width: 1200px; margin: 30px auto; padding: 0 15px; }
    .anime-card { background: #ffffff; border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .anime-card-header { background: #ffffff; padding: 25px 30px; border-bottom: 1px solid #f0f0f0; }
    .form-section-title { font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: #8898aa; font-weight: 700; margin-bottom: 25px; display: block; border-bottom: 2px solid #5e72e4; width: fit-content; padding-bottom: 5px; }
    .custom-group label { font-weight: 600; font-size: 14px; color: #32325d; margin-bottom: 8px; }
    .custom-input-style { border-radius: 10px !important; border: 1px solid #dee2e6 !important; padding: 12px 15px !important; height: auto !important; font-size: 14px; }
    .upload-box { background: #f8f9fe; border: 2px dashed #dee2e6; border-radius: 15px; padding: 20px; margin-bottom: 20px; text-align: center; }
    .img-preview-box { width: 100%; border-radius: 10px; margin-top: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); object-fit: cover; }
    .btn-update { background: #5e72e4; color: white; font-weight: 700; padding: 15px; border-radius: 12px; border: none; transition: all 0.3s; }
    .btn-update:hover { background: #4559d4; transform: translateY(-2px); color: white; }
    
    .bootstrap-select .btn { background: white !important; border: 1px solid #dee2e6 !important; border-radius: 10px !important; }
    .note-editor.note-frame { border-radius: 10px; border: 1px solid #dee2e6; }

    * Border Merah khusus untuk plugin Selectpicker & Summernote */
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
.flatpickr-calendar {
    z-index: 99999 !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
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

/* Efek Drag & Drop */
.upload-box.dragover {
    background-color: rgba(172, 17, 233, 0.1) !important;
    border: 2px dashed #ac11e9 !important;
    transform: scale(1.02);
}

.upload-box {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* --- MODERN RESET BUTTON --- */
.btn-modern-reset {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: rgba(220, 53, 69, 0.05); /* Latar belakang merah sangat tipis */
    color: #dc3545; /* Teks merah */
    border: 1px solid rgba(220, 53, 69, 0.2);
    border-radius: 8px;
    padding: 6px 15px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px; /* Jarak dari gambar di atasnya */
}

.btn-modern-reset:hover {
    background: #dc3545;
    color: #fff;
    box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
}

.btn-modern-reset.d-none {
    display: none !important;
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
    <div class="anime-card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="m-0 font-weight-bold d-flex align-items-center" style="color: #32325d;">
                <i class="fas fa-edit mr-3 text-primary"></i> 
                <div>
                    <span class="d-block">Edit Data Anime</span>
                    <!-- Menampilkan Judul Anime yang sedang diedit -->
                    <small class="d-block text-muted mt-1" style="font-size: 0.9rem; font-weight: 500;">
                        <span class="text-primary font-weight-bold">"<?= esc($animes['Judul']) ?>"</span>
                    </small>
                </div>
            </h4>
            
            <div class="header-badges mt-2 mt-sm-0">
                <span class="badge badge-primary-soft text-primary px-3 py-2 mr-2" style="border-radius: 10px;">ID: #<?= $animes['id'] ?></span>
                
                <!-- Opsional: Menampilkan Badge Status Saat Ini di atas -->
                <?php if ($animes['statusTayang'] === 'published'): ?>
                    <span class="badge badge-success px-3 py-2" style="border-radius: 10px;"><i class="fas fa-check-circle"></i> PUBLISHED</span>
                <?php else: ?>
                    <span class="badge badge-secondary px-3 py-2" style="border-radius: 10px;"><i class="fas fa-pen-nib"></i> DRAFT</span>
                <?php endif; ?>
            </div>
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

            <form id="formEditAnime" action="<?= url_to('prosesEdit', $animes['id']); ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <!-- Hidden Inputs Penting untuk Fitur Reset -->
                <input type="hidden" name="BackgroundCoverOld" value="<?= $animes['BackgroundCover'] ?>">
                <input type="hidden" name="PosterOld" value="<?= $animes['Poster'] ?>">
                <!-- Nilai ini akan diubah oleh JavaScript saat tombol X ditekan -->
                <input type="hidden" name="BackgroundCoverReset" id="BackgroundCoverReset" value="0">
                <input type="hidden" name="PosterReset" id="PosterReset" value="0">

                <div class="row">
                    <!-- KOLOM KIRI: DETAIL INFORMASI -->
                    <div class="col-lg-7 pr-lg-5">
                        <span class="form-section-title">Informasi Dasar</span>
                        
                        <div class="form-group custom-group">
                            <label>Judul Anime <span class="text-danger-star">*</span></label>
                            
                            <!-- Tambahkan atribut data-original -->
                            <input type="text" name="Judul" id="judulAnime" data-original="<?= esc($animes['Judul']) ?>" class="form-control custom-input-style <?= ($validation->hasError('Judul')) ? 'is-invalid' : '' ?>" value="<?= esc($animes['Judul']) ?>" placeholder="Masukkan judul..." onkeyup="checkAnimeDuplicate()">
                            
                            <small id="judulFeedback" class="form-text mt-2 font-weight-bold" style="display: none;"></small>
                            <div class="invalid-feedback"><?= $validation->getError('Judul') ?></div>
                        </div>

                        <div class="form-group custom-group">
                            <label>Judul Lainnya / Alternatif <span class="label-optional">Opsional</span></label>
                            <input type="text" name="JudulLainnya" class="form-control custom-input-style" placeholder="Judul alternatif..." value="<?= esc($animes['JudulLainnya']) ?>">
                        </div>

                        <div class="form-group custom-group">
                            <label>Sinopsis / Deskripsi <span class="label-optional">Opsional</span></label>
                            <textarea name="Desc" id="summernote" class="form-control"><?= $animes['Desc'] ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Jumlah Episode <span class="label-optional">Opsional</span></label>
                                    <input type="number" step="1" min="0" name="Eps" class="form-control custom-input-style" value="<?= old('Eps', $animes['Eps'] ?? '') ?>" oninput="this.value = Math.abs(Math.floor(this.value));">                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Durasi (Menit) <span class="label-optional">Opsional</span></label>
                                    <input type="number" step="1" min="0" name="Durasi" class="form-control custom-input-style" value="<?= old('Durasi', $animes['Durasi'] ?? '') ?>" oninput="this.value = Math.abs(Math.floor(this.value));">                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group custom-group">
                                <label>Tanggal Rilis <span class="label-optional">Opsional</span></label>
                                <?php 
                                    $valRilis = old('Rilis', $animes['Rilis'] ?? '');
                                    $formattedDate = '';
                                    // Pastikan jika bukan TBA, ubah format ke Y-m-d
                                    if (!empty($valRilis) && $valRilis !== 'TBA') {
                                        $formattedDate = date('Y-m-d', strtotime(substr($valRilis, 0, 10)));
                                    }
                                ?>
                                <!-- Ganti ID-nya menjadi 'rilisEdit' agar pasti tidak bentrok dengan ID lain -->
                                <input type="text" name="Rilis" class="form-control custom-input-style bg-white" id="rilisEdit" placeholder="Pilih tanggal..." value="<?= $formattedDate ?>">                            </div>
                        </div>
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Tipe Anime <span class="label-optional">Opsional</span></label>
                                    <select class="form-control selectpicker w-100" name="typeAnime" title="Pilih Tipe">
                                        <?php foreach ($typeAnime as $item): ?>
                                            <option value="<?= $item['id'] ?>" <?= ($item['id'] == $animes['typeId']) ? 'selected' : '' ?>><?= $item['tipeAnime'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group custom-group">
                            <label>Genre <span class="label-optional">Opsional</span></label>
                            <select name="genre[]" id="choices-multiple-remove-button" class="form-control" multiple>
                                <?php foreach ($genres as $genre): ?>
                                    <option value="<?= $genre['id'] ?>" <?= in_array($genre['id'], array_column($selectedGenre, 'genre_id')) ? 'selected' : '' ?>><?= esc($genre['genre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group custom-group">
                            <label>Studio Produksi <span class="label-optional">Opsional</span></label>
                            <select name="studios[]" class="form-control selectpicker" data-live-search="true" multiple title="Bisa pilih lebih dari 1">
                                <?php foreach ($studios as $s): ?>
                                    <option value="<?= $s['id'] ?>" <?= in_array($s['id'], $selectedStudios) ? 'selected' : '' ?>><?= esc($s['nama_studio']) ?></option>
                                <?php endforeach; ?>
                            </select>
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
                                    <label class="font-weight-bold small text-muted">Source Material</label>
                                    <select name="source" class="form-control selectpicker" title="-- Pilih Source --">
                                        <option value="Manga" <?= ($animes['source'] ?? '') == 'Manga' ? 'selected' : '' ?>>Manga</option>
                                        <option value="Light Novel" <?= ($animes['source'] ?? '') == 'Light Novel' ? 'selected' : '' ?>>Light Novel</option>
                                        <option value="Original" <?= ($animes['source'] ?? '') == 'Original' ? 'selected' : '' ?>>Original</option>
                                        <option value="Visual Novel" <?= ($animes['source'] ?? '') == 'Visual Novel' ? 'selected' : '' ?>>Visual Novel</option>
                                        <option value="Game" <?= ($animes['source'] ?? '') == 'Game' ? 'selected' : '' ?>>Game</option>
                                        <option value="Web Manga" <?= ($animes['source'] ?? '') == 'Web Manga' ? 'selected' : '' ?>>Web Manga</option>
                                        <option value="Novel" <?= ($animes['source'] ?? '') == 'Novel' ? 'selected' : '' ?>>Novel</option>
                                        <option value="Unknown" <?= ($animes['source'] ?? '') == 'Unknown' ? 'selected' : '' ?>>Lainnya / Unknown</option>
                                    </select>
                                </div>

                                <!-- Season -->
                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold small text-muted">Musim (Season)</label>
                                    <select name="season" id="seasonSelect" class="form-control selectpicker" title="-- Pilih Musim --">
                                        <option value="spring" <?= ($animes['season'] ?? '') == 'spring' ? 'selected' : '' ?>>🌸 Spring</option>
                                        <option value="summer" <?= ($animes['season'] ?? '') == 'summer' ? 'selected' : '' ?>>☀️ Summer</option>
                                        <option value="fall" <?= ($animes['season'] ?? '') == 'fall' ? 'selected' : '' ?>>🍂 Fall</option>
                                        <option value="winter" <?= ($animes['season'] ?? '') == 'winter' ? 'selected' : '' ?>>❄️ Winter</option>
                                        <option value="Unknown" <?= ($animes['season'] ?? '') == 'Unknown' ? 'selected' : '' ?>>Unknown</option>
                                    </select>
                                </div>

                                <!-- Release Year -->
                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold small text-muted">Tahun Rilis</label>
                                    <input type="number" min="1960" max="2040" name="release_year" class="form-control custom-input-style" placeholder="Cth: 2024" value="<?= old('release_year', $animes['release_year'] ?? '') ?>" onblur="validateYear(this)">                                </div>
                            </div>

                            <div class="row">
                                <!-- MAL ID -->
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold small text-muted">MyAnimeList ID (MAL_ID) <span class="label-optional">Opsional</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-link text-primary"></i></span>
                                        </div>
                                        
                                        <!-- PENTING: Tambahkan id, onkeyup, dan data-original -->
                                        <input type="number" name="mal_id" id="malIdAnime" 
                                            data-original="<?= $animes['mal_id'] ?? '' ?>" 
                                            class="form-control custom-input-style" style="border-left: none;" 
                                            placeholder="Cth: 52991" 
                                            value="<?= $animes['mal_id'] ?? '' ?>" 
                                            onkeyup="checkMalIdDuplicate()">
                                            
                                    </div>
                                    <!-- Tempat memunculkan pesan AJAX -->
                                    <small id="malIdFeedback" class="form-text mt-1 font-weight-bold" style="display: none;"></small>
                                </div>

                                <!-- MAL Score -->
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold small text-muted">MAL Score <span class="label-optional">Opsional</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-star text-warning"></i></span>
                                        </div>
                                        <!-- Tambahkan atribut min="0", max="10", dan step="0.01" -->
                                        <!-- oninput mencegah admin mengetik karakter aneh yang lolos dari validasi browser -->
                                        <input type="number" step="0.01" min="0" max="10" name="mal_score" class="form-control custom-input-style" style="border-left: none;" placeholder="Cth: 8.75" value="<?= old('mal_score', $animes['mal_score'] ?? '') ?>" oninput="validateMalScore(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ========================================== -->

                    </div>

                    <!-- KOLOM KANAN: MEDIA & STATUS -->
                    <div class="col-lg-5">
                        <span class="form-section-title">Media & Status</span>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group custom-group">
                                    <label>Status Tayang <span class="label-optional">Opsional</span></label>
                                    <select name="status" class="form-control selectpicker w-100" title="Pilih Status">
                                        <option value="Completed" <?= $animes['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="On-Going" <?= $animes['status'] == 'On-Going' ? 'selected' : '' ?>>On-Going</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group custom-group">
                                <label>Status Publikasi</label> <!-- Ini penting, biarkan tanpa indikator jika wajib -->
                                <div class="d-flex gap-3 mt-1">
                                    <!-- Draft Card -->
                                    <div class="flex-fill mr-2">
                                        <input type="radio" name="status_tayang" value="draft" id="card-draft" class="d-none status-radio" <?= $animes['statusTayang'] == 'draft' ? 'checked' : '' ?>>
                                        <label for="card-draft" class="status-card draft-card">
                                            <i class="fas fa-pen-nib mb-1"></i>
                                            <span>Simpan Draft</span>
                                        </label>
                                    </div>

                                    <!-- Published Card -->
                                    <div class="flex-fill">
                                        <input type="radio" name="status_tayang" value="published" id="card-pub" class="d-none status-radio" <?= $animes['statusTayang'] == 'published' ? 'checked' : '' ?>>
                                        <label for="card-pub" class="status-card pub-card">
                                            <i class="fas fa-rocket mb-1"></i>
                                            <span>Publikasikan</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="form-group custom-group">
                            <label>Seri Terkait <span class="label-optional">Opsional</span></label>
                            <select class="form-control selectpicker w-100" data-live-search="true" name="seriLainnya[]" multiple title="Pilih seri terkait">
                                <?php foreach($animess as $item): ?>
                                    <?php if ($item['id'] !== $animes['id']): ?>
                                        <option value="<?= $item['id']; ?>" <?= in_array($item['id'], array_column($relatedAnime, 'id')) ? 'selected' : ''; ?>>
                                            <?= $item['Judul']; ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

<!-- ============================== -->
                        <!-- UPLOAD BOX: BACKGROUND COVER   -->
                        <!-- ============================== -->
                        <div class="upload-box mt-3" id="wrapperBgCover">
                            <label class="font-weight-bold mb-1 d-block text-dark">
                                <i class="fas fa-image text-primary mr-1"></i> Background Cover <span class="label-optional">Opsional</span>
                            </label>

                            <?php 
                                // Cek apakah data lama berupa URL atau File
                                $bgCoverSrc = $animes['BackgroundCover'];
                                $isBgUrl = filter_var($bgCoverSrc, FILTER_VALIDATE_URL) ? true : false; 
                                
                                // Set path gambar yang akan ditampilkan
                                $imgBgSrc = $isBgUrl ? $bgCoverSrc : '/assets/images/' . $bgCoverSrc;
                            ?>

                            <!-- Tombol Switch -->
                            <div class="img-source-toggle">
                                <input type="radio" name="bg_source_type" id="bgTypeUpload" value="upload" <?= !$isBgUrl ? 'checked' : '' ?> onchange="toggleImgSource('bg')">
                                <label for="bgTypeUpload"><i class="fas fa-upload mr-1"></i> Upload File</label>
                                
                                <input type="radio" name="bg_source_type" id="bgTypeUrl" value="url" <?= $isBgUrl ? 'checked' : '' ?> onchange="toggleImgSource('bg')">
                                <label for="bgTypeUrl"><i class="fas fa-link mr-1"></i> Gunakan URL</label>
                            </div>

                            <!-- INFO BADGE UPLOAD -->
                            <div class="file-info-badge" id="bgUploadInfo" style="display: <?= !$isBgUrl ? 'flex' : 'none' ?>;">
                                <span class="file-info-item"><i class="fas fa-weight-hanging"></i> Maks 2 MB</span>
                                <span class="file-info-item"><i class="fas fa-file-image"></i> JPG, PNG, WEBP</span>
                                <span class="file-info-item"><i class="fas fa-expand-arrows-alt"></i> Rasio 16:9</span>
                            </div>

                            <!-- INFO BADGE URL -->
                            <div class="file-info-badge" id="bgUrlInfo" style="display: <?= $isBgUrl ? 'flex' : 'none' ?>;">
                                <span class="file-info-item text-warning" style="background: rgba(255,193,7,0.1); border-color: #ffc107;">
                                    <i class="fas fa-info-circle text-warning"></i> Gunakan link stabil (MAL, Imgur, dsb)
                                </span>
                            </div>

                            <!-- AREA UPLOAD LOCAL -->
                            <div id="bgUploadArea" class="custom-file text-left" style="display: <?= !$isBgUrl ? 'block' : 'none' ?>;">
                                <input type="file" name="BackgroundCoverFile" id="fileBackgroundCover" class="custom-file-input" accept="image/jpeg, image/png, image/webp" onchange="previewImg('img-preview', 'fileBackgroundCover', 'btn-reset-background-cover')">
                                <label class="custom-file-label" for="fileBackgroundCover"><?= !$isBgUrl ? $animes['BackgroundCover'] : 'Pilih file...' ?></label>
                            </div>

                            <!-- AREA INPUT URL -->
                            <div id="bgUrlArea" class="text-left" style="display: <?= $isBgUrl ? 'block' : 'none' ?>;">
                                <input type="url" name="BackgroundCoverUrl" id="urlBackgroundCover" class="form-control custom-input-style" placeholder="Paste link gambar (https://...)" value="<?= $isBgUrl ? $animes['BackgroundCover'] : '' ?>" oninput="previewImgUrl('img-preview', this.value, 'default3.jpg')">
                            </div>
                            
                                <div class="mt-3 text-center">
                                    <?php 
                                        $bgCoverSrc = $animes['BackgroundCover'];
                                        $imgBgSrc = (filter_var($bgCoverSrc, FILTER_VALIDATE_URL)) ? $bgCoverSrc : '/assets/images/' . $bgCoverSrc;
                                    ?>
                                    <img src="<?= $imgBgSrc ?>" id="img-preview" class="img-preview-box" style="height: 150px; width: 100%; object-fit: cover;">
                                    
                                    <!-- Tombol Reset Baru yang Lebih Modern -->
                                    <button type="button" class="btn-modern-reset <?= ($bgCoverSrc == 'default3.jpg') ? 'd-none' : ''; ?>" id="btn-reset-background-cover" onclick="resetImage('bg')" title="Hapus Gambar Background">
                                        <i class="fas fa-trash-alt"></i> Hapus Gambar Background
                                    </button>
                            </div>
                            <div class="feedback-placeholder text-center mt-2"></div>
                        </div>

                        <!-- ============================== -->
                        <!-- UPLOAD BOX: POSTER UTAMA       -->
                        <!-- ============================== -->
                        <div class="upload-box mt-4" id="wrapperPoster">
                            <label class="font-weight-bold mb-1 d-block text-dark">
                                <i class="fas fa-portrait text-primary mr-1"></i> Poster Utama <span class="label-optional">Opsional</span>
                            </label>

                            <?php 
                                $posterSrc = $animes['Poster'];
                                $isPosterUrl = filter_var($posterSrc, FILTER_VALIDATE_URL) ? true : false;
                                
                                // Cek file exist untuk fallback jika file lokal hilang
                                if ($isPosterUrl) {
                                    $imgPSrc = $posterSrc;
                                } else {
                                    $imgPSrc = file_exists($_SERVER['DOCUMENT_ROOT'] . '/assets/images/' . $posterSrc) ? '/assets/images/' . $posterSrc : '/assets/images/default1.jpg';
                                }
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
                                <label class="custom-file-label" for="Poster"><?= !$isPosterUrl ? $animes['Poster'] : 'Pilih file...' ?></label>
                            </div>

                            <!-- AREA INPUT URL -->
                            <div id="posterUrlArea" class="text-left" style="display: <?= $isPosterUrl ? 'block' : 'none' ?>;">
                                <input type="url" name="PosterUrl" id="urlPoster" class="form-control custom-input-style" placeholder="Paste link gambar (https://...)" value="<?= $isPosterUrl ? $animes['Poster'] : '' ?>" oninput="previewImgUrl('img-preview-poster', this.value, 'default1.jpg')">
                            </div>
                            
                            <div class="mt-3 text-center">
                                <?php 
                                    $posterSrc = $animes['Poster'];
                                    $isPosterUrl = filter_var($posterSrc, FILTER_VALIDATE_URL) ? true : false;
                                    if ($isPosterUrl) {
                                        $imgPSrc = $posterSrc;
                                    } else {
                                        $imgPSrc = file_exists($_SERVER['DOCUMENT_ROOT'] . '/assets/images/' . $posterSrc) ? '/assets/images/' . $posterSrc : '/assets/images/default1.jpg';
                                    }
                                ?>
                                <img src="<?= $imgPSrc ?>" id="img-preview-poster" class="img-preview-box" style="max-height: 250px; width: auto; border-radius: 12px;">
                                
                                <!-- Tombol Reset Baru yang Lebih Modern -->
                                <button type="button" class="btn-modern-reset <?= ($posterSrc == 'default1.jpg') ? 'd-none' : ''; ?>" id="btn-reset-poster" onclick="resetImage('poster')" title="Hapus Poster Utama">
                                    <i class="fas fa-trash-alt"></i> Hapus Poster Utama
                                </button>
                            </div>
                            <div class="feedback-placeholder text-center mt-2"></div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-update btn-block">
                                <i class="fas fa-sync-alt mr-2"></i> Perbarui Data Anime
                            </button>
                            <a href="<?= url_to('dashboard') ?>" class="btn btn-light btn-block mt-3" style="border-radius: 12px; font-weight: 600;">Batal & Kembali</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// --- 1. VARIABEL GLOBAL UNTUK AJAX ---
let typingTimer; 
const doneTypingInterval = 500; 
let isTitleDuplicate = false; 

let typingTimerMal; 
let isMalIdDuplicate = false; 

// --- 2. FUNGSI CEK DUPLIKAT (Harus di luar event DOMContentLoaded) ---
window.checkAnimeDuplicate = function(e) {
    if (e) e.stopPropagation();
    clearTimeout(typingTimer); 
    const judulInput = document.getElementById('judulAnime');
    const feedbackText = document.getElementById('judulFeedback');
    
    if (!judulInput || !feedbackText) return;

    const judulValue = judulInput.value.trim();
    const judulAwal = judulInput.getAttribute('data-original').trim(); 

    if (judulValue.length === 0) {
        feedbackText.style.display = 'none';
        judulInput.classList.remove('is-invalid', 'is-valid');
        isTitleDuplicate = false; 
        return;
    }

    if (judulValue.toLowerCase() === judulAwal.toLowerCase()) {
        feedbackText.style.display = 'block';
        feedbackText.className = 'form-text mt-2 font-weight-bold text-success';
        feedbackText.innerHTML = '<i class="fas fa-check-circle"></i> Judul tidak diubah (Aman).';
        judulInput.classList.remove('is-invalid');
        judulInput.classList.add('is-valid'); 
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
            })
            .catch(error => {
                feedbackText.style.display = 'none';
                isTitleDuplicate = false;
            });

    }, doneTypingInterval);
};

window.checkMalIdDuplicate = function(e) {
    if (e) e.stopPropagation();
    clearTimeout(typingTimerMal); 
    
    const malInput = document.getElementById('malIdAnime');
    const feedbackText = document.getElementById('malIdFeedback');
    
    if (!malInput || !feedbackText) return;

    const malValue = malInput.value.trim();
    const malAwal = malInput.getAttribute('data-original').trim(); 

    if (malValue.length === 0) {
        feedbackText.style.display = 'none';
        malInput.classList.remove('is-invalid', 'is-valid');
        isMalIdDuplicate = false; 
        return;
    }

    if (malValue === malAwal) {
        feedbackText.style.display = 'block';
        feedbackText.className = 'form-text mt-1 font-weight-bold text-success';
        feedbackText.innerHTML = '<i class="fas fa-check-circle"></i> MAL ID tidak diubah (Aman).';
        malInput.classList.remove('is-invalid');
        malInput.classList.add('is-valid'); 
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
            })
            .catch(error => {
                feedbackText.style.display = 'none';
                isMalIdDuplicate = false;
            });
    }, doneTypingInterval);
};

// --- 3. LOGIKA UTAMA SAAT HALAMAN DIBUKA ---
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('formEditAnime');
    
    function addFeedbackText(element, isWarning = false, customText = "") {
        let parent = element.parentElement;
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
        const allInputs = document.querySelectorAll('#formEditAnime input, #formEditAnime textarea');
        allInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid', 'is-warning');
                const parent = this.parentElement;
                const feedback = parent.querySelector('.custom-feedback-msg');
                if (feedback) feedback.remove();

                const legendBox = document.querySelector('.validation-legend');
                if (legendBox) legendBox.classList.remove('show');
            });
        });

        const allSelects = document.querySelectorAll('#formEditAnime select');
        allSelects.forEach(select => {
            select.addEventListener('change', function() {
                const btn = this.parentElement.querySelector('.btn.dropdown-toggle');
                if (btn) btn.classList.remove('border-danger-custom', 'border-warning-custom');
                
                const choicesContainer = this.closest('.choices');
                if (choicesContainer) choicesContainer.classList.remove('border-danger-custom', 'border-warning-custom');
                
                const parent = this.closest('.form-group') || this.parentElement;
                const feedback = parent.querySelector('.custom-feedback-msg');
                if (feedback) feedback.remove();
            });
        });
        
        const fileInputs = document.querySelectorAll('#formEditAnime input[type="file"]');
        fileInputs.forEach(fileInput => {
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

    setupDragAndDrop('wrapperBgCover', 'fileBackgroundCover');
    setupDragAndDrop('wrapperPoster', 'Poster');

    removeFeedbackOnInput();

    if (form) {
        form.setAttribute('novalidate', true);

        form.addEventListener('submit', function(e) {
            let isFormValid = true; 
            let errorMessages = []; 

            const optionalInputs = ['JudulLainnya', 'Eps', 'Durasi', 'Rilis', 'release_year', 'mal_id', 'mal_score'];
            const optionalSelects = ['typeAnime', 'status', 'source', 'season', 'seriLainnya[]'];

            // Bersihkan semua error lama
            document.querySelectorAll('.is-invalid, .is-warning, .border-danger-custom, .border-warning-custom').forEach(el => {
                el.classList.remove('is-invalid', 'is-warning', 'border-danger-custom', 'border-warning-custom');
            });
            document.querySelectorAll('.custom-feedback-msg').forEach(el => el.remove());

            // --- A. CEK JUDUL ---
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

            // --- C. CEK INPUT KUNING (OPSIONAL) ---
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

            // Genre
            let genreSelect = document.querySelector('select[name="genre[]"]');
            if (genreSelect && genreSelect.selectedOptions.length === 0) {
                let choicesContainer = genreSelect.closest('.choices');
                if (choicesContainer) {
                    choicesContainer.classList.add('border-warning-custom');
                    addFeedbackText(choicesContainer, true, "Tidak ada genre. Akan tampil 'Belum ada genre'.");
                }
            }

            // Studio
            let studioSelect = document.querySelector('select[name="studios[]"]');
            if (studioSelect && studioSelect.selectedOptions.length === 0) {
                let btn = studioSelect.parentElement.querySelector('.btn.dropdown-toggle');
                if (btn) {
                    btn.classList.add('border-warning-custom');
                    addFeedbackText(btn, true, "Tidak ada studio. Akan tampil 'Unknown'.");
                }
            }

            // Sinopsis
            let summernoteEl = document.getElementById('summernote');
            if (summernoteEl) {
                let descContent = $(summernoteEl).summernote('code').replace(/<\/?[^>]+(>|$)/g, "").trim();
                if (descContent === '') {
                    let noteEditor = document.querySelector('.note-editor');
                    if(noteEditor) {
                        noteEditor.classList.add('border-warning-custom');
                        addFeedbackText(noteEditor, true, "Sinopsis kosong. Akan tampil 'Belum ada sinopsis'.");
                    }
                }
            }

            // --- D. CEK GAMBAR (Maks 2MB) ---
            const MAX_FILE_SIZE = 2 * 1024 * 1024; 
            
            let bgInput = document.getElementById('fileBackgroundCover');
            if (bgInput && bgInput.files.length > 0 && bgInput.files[0].size > MAX_FILE_SIZE) {
                let wrapperBg = document.getElementById('wrapperBgCover');
                wrapperBg.classList.add('border-danger-custom');
                let fbPlace = wrapperBg.querySelector('.feedback-placeholder');
                if(fbPlace) fbPlace.innerHTML = `<small class="text-danger font-weight-bold"><i class="fas fa-times-circle"></i> Ukuran Background Cover melebihi 2MB!</small>`;
                errorMessages.push("Ukuran <b>Background Cover</b> melebihi 2MB.");
                isFormValid = false;
            }

            let posterInput = document.getElementById('Poster');
            if (posterInput && posterInput.files.length > 0 && posterInput.files[0].size > MAX_FILE_SIZE) {
                let wrapperPoster = document.getElementById('wrapperPoster');
                wrapperPoster.classList.add('border-danger-custom');
                let fbPlace = wrapperPoster.querySelector('.feedback-placeholder');
                if(fbPlace) fbPlace.innerHTML = `<small class="text-danger font-weight-bold"><i class="fas fa-times-circle"></i> Ukuran Poster Utama melebihi 2MB!</small>`;
                errorMessages.push("Ukuran <b>Poster Utama</b> melebihi 2MB.");
                isFormValid = false;
            }

            // --- E. KESIMPULAN AKHIR ---
            if (!isFormValid) {
                e.preventDefault(); 
                
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
                // ==========================================
                // JIKA FORM VALID: TAMPILKAN KONFIRMASI
                // ==========================================
                e.preventDefault(); 

                Swal.fire({
                    title: 'Simpan Perubahan?',
                    text: "Pastikan data anime yang Anda ubah sudah benar.",
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
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        form.submit();
                    }
                });
            }
        });
    }
});

// ==========================================
    // INISIALISASI FLATPICKR + AUTO SELECT SEASON (VANILLA JS)
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            // Sesuaikan ID dengan halaman Anda (rilisEdit untuk Edit, Rilis untuk Tambah)
            const rilisInput = document.getElementById("rilisEdit"); 
            const seasonSelect = document.getElementById("seasonSelect");
            
            if (rilisInput) {
                if (rilisInput._flatpickr) {
                    rilisInput._flatpickr.destroy();
                }

                flatpickr(rilisInput, {
                    dateFormat: "Y-m-d", 
                    altInput: true,      
                    altFormat: "F j, Y", 
                    allowInput: true,    
                    minDate: "1960-01-01",
                    maxDate: "2040-12-31",
                    defaultDate: rilisInput.value ? rilisInput.value : null,
                    
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length > 0 && seasonSelect) {
                            
                            // 1. Ambil Bulan
                            const month = selectedDates[0].getMonth() + 1; 
                            let seasonValue = "Unknown";

                            // 2. Tentukan Season
                            if (month >= 1 && month <= 3) seasonValue = "winter";
                            else if (month >= 4 && month <= 6) seasonValue = "spring";
                            else if (month >= 7 && month <= 9) seasonValue = "summer";
                            else if (month >= 10 && month <= 12) seasonValue = "fall";

                            // 3. UBAH NILAI SELECT ASLI (Vanilla JS)
                            seasonSelect.value = seasonValue;

                            // 4. TRIGGER EVENT CHANGE (Sangat Penting!)
                            // Perintah ini akan "membangunkan" Selectpicker untuk menyadari bahwa
                            // nilai select aslinya sudah berubah secara diam-diam.
                            const event = new Event('change', { bubbles: true });
                            seasonSelect.dispatchEvent(event);

                            // 5. UPDATE UI SELECTPICKER (Jika Selectpicker masih bandel)
                            // Jika perintah di atas belum cukup, kita pakai metode ini:
                            if (window.jQuery && $.fn.selectpicker) {
                                $(seasonSelect).selectpicker('refresh');
                            }

                            // 6. Bersihkan peringatan kuning (jika ada)
                            const btn = seasonSelect.parentElement.querySelector('.btn.dropdown-toggle');
                            if (btn) btn.classList.remove('border-warning-custom');
                            const parent = seasonSelect.closest('.form-group') || seasonSelect.parentElement;
                            const feedback = parent.querySelector('.custom-feedback-msg');
                            if (feedback) feedback.remove();
                        }
                    }
                });
                
                console.log("✅ Flatpickr & Auto-Season (Vanilla) siap digunakan!");
            }
        }, 300);
    });

    // --- 1. FUNGSI TOGGLE SUMBER GAMBAR ---
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
        if(infoUpload) infoUpload.style.display = 'flex';
        if(infoUrl) infoUrl.style.display = 'none';
    } else {
        if(uploadArea) uploadArea.style.display = 'none';
        if(urlArea) urlArea.style.display = 'block';
        if(infoUpload) infoUpload.style.display = 'none';
        if(infoUrl) infoUrl.style.display = 'flex';
    }
};

// Memunculkan tombol X jika URL valid diketik
window.previewImgUrl = function(previewId, urlValue, defaultImg) {
    const preview = document.getElementById(previewId);
    if (!preview) return;
    
    if (urlValue.trim() !== '' && urlValue.startsWith('http')) {
        preview.src = urlValue; 
        
        // Munculkan tombol X
        if(previewId === 'img-preview') {
            document.getElementById('btn-reset-background-cover').classList.remove('d-none');
            document.getElementById('BackgroundCoverReset').value = '0'; // Batalkan status reset
        } else {
            document.getElementById('btn-reset-poster').classList.remove('d-none');
            document.getElementById('PosterReset').value = '0'; // Batalkan status reset
        }
    } else {
        preview.src = '<?= base_url('assets/images/') ?>' + defaultImg; 
        
        // Sembunyikan tombol X
        if(previewId === 'img-preview') {
            document.getElementById('btn-reset-background-cover').classList.add('d-none');
        } else {
            document.getElementById('btn-reset-poster').classList.add('d-none');
        }
    }
};

// Fungsi Preview File (Background)
window.previewImg = function(previewId, inputId, btnResetId) {
    const file = document.getElementById(inputId).files[0];
    if (file) {
        document.getElementById(previewId).src = URL.createObjectURL(file);
        document.getElementById(btnResetId).classList.remove('d-none');
        document.getElementById('BackgroundCoverReset').value = '0';
        
        // Update label
        document.querySelector(`label[for="${inputId}"]`).innerText = file.name;
    }
};

// Fungsi Preview File (Poster)
window.previewImgPoster = function() {
    const file = document.getElementById('Poster').files[0];
    if (file) {
        document.getElementById('img-preview-poster').src = URL.createObjectURL(file);
        document.getElementById('btn-reset-poster').classList.remove('d-none');
        document.getElementById('PosterReset').value = '0';
        
        // Update label
        document.querySelector(`label[for="Poster"]`).innerText = file.name;
    }
};

// --- FUNGSI UNTUK MERESET GAMBAR KE DEFAULT ---
window.resetImage = function(type) {
    if (type === 'bg') {
        // 1. Kembalikan gambar preview ke default
        document.getElementById('img-preview').src = '<?= base_url('assets/images/default3.jpg') ?>';
        
        // 2. Kosongkan input File dan URL
        document.getElementById('fileBackgroundCover').value = '';
        document.getElementById('urlBackgroundCover').value = '';
        
        // 3. Kembalikan label file input ke tulisan awal
        let fileLabel = document.querySelector('label[for="fileBackgroundCover"]');
        if(fileLabel) fileLabel.innerText = 'Pilih file...';
        
        // 4. Set input hidden agar Controller PHP tahu admin ingin mereset gambar ini
        document.getElementById('BackgroundCoverReset').value = '1';
        
        // 5. Sembunyikan tombol X ini karena sekarang gambarnya sudah default
        document.getElementById('btn-reset-background-cover').classList.add('d-none');
        
    } else if (type === 'poster') {
        // Lakukan hal yang sama untuk Poster
        document.getElementById('img-preview-poster').src = '<?= base_url('assets/images/default1.jpg') ?>';
        
        document.getElementById('Poster').value = '';
        document.getElementById('urlPoster').value = '';
        
        let fileLabel = document.querySelector('label[for="Poster"]');
        if(fileLabel) fileLabel.innerText = 'Pilih file...';
        
        document.getElementById('PosterReset').value = '1';
        
        document.getElementById('btn-reset-poster').classList.add('d-none');
    }
};

// --- 3. FUNGSI DRAG & DROP GAMBAR ---
function setupDragAndDrop(boxId, inputId) {
    const dropBox = document.getElementById(boxId);
    const fileInput = document.getElementById(inputId);

    if (!dropBox || !fileInput) return;

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropBox.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropBox.addEventListener(eventName, () => {
            // Hanya jalankan efek drag jika sedang di tab Upload File
            const isUploadTab = dropBox.querySelector('input[type="radio"][value="upload"]')?.checked;
            if (isUploadTab) dropBox.classList.add('dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropBox.addEventListener(eventName, () => {
            dropBox.classList.remove('dragover');
        }, false);
    });

    dropBox.addEventListener('drop', (e) => {
        const isUploadTab = dropBox.querySelector('input[type="radio"][value="upload"]')?.checked;
        if (!isUploadTab) return; // Abaikan drop jika sedang di tab URL

        let dt = e.dataTransfer;
        let files = dt.files;

        if (files.length > 0) {
            fileInput.files = files;
            // Panggil event change agar fungsi preview gambar CodeIgniter Anda terpicu
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    }, false);
}
</script>


<?= $this->endSection() ?>