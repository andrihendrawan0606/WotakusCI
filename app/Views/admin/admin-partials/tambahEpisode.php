<?= $this->extend('admin/admin-partials/index') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .main-form-container { width: 100% !important; max-width: 1100px; margin: 30px auto; padding: 0 15px; }
    .anime-card { background: #ffffff; border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .anime-card-header { background: #ffffff; padding: 25px 30px; border-bottom: 1px solid #f0f0f0; }
    .form-section-title { font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: #8898aa; font-weight: 700; margin-bottom: 25px; display: block; border-bottom: 2px solid #5e72e4; width: fit-content; padding-bottom: 5px; }
    
    .custom-group label { font-weight: 600; font-size: 14px; color: #32325d; margin-bottom: 8px; }
    .custom-input-style { border-radius: 10px !important; border: 1px solid #dee2e6 !important; padding: 12px 15px !important; height: auto !important; font-size: 14px; }
    
    /* Media Styling */
    .upload-box { background: #f8f9fe; border: 2px dashed #dee2e6; border-radius: 15px; padding: 20px; margin-bottom: 20px; text-align: center; transition: all 0.3s; }
    .upload-box:hover { border-color: #5e72e4; background: #f0f2ff; }
    
    .drop-zone { cursor: pointer; padding: 30px 10px; color: #8898aa; font-weight: 600; font-size: 14px; }
    .drop-zone i { font-size: 2rem; color: #5e72e4; margin-bottom: 10px; display: block; }
    
    .img-preview-episode { width: 100%; border-radius: 12px; margin-top: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    
    /* Progress Bar */
    .progress { height: 12px; border-radius: 10px; background-color: #f1f3f9; margin-top: 15px; }
    .progress-bar { background: linear-gradient(90deg, #5e72e4, #825ee4); border-radius: 10px; }

    .btn-save { background: #5e72e4; color: white; font-weight: 700; padding: 15px; border-radius: 12px; border: none; transition: 0.3s; }
    .btn-save:hover { background: #4559d4; transform: translateY(-2px); box-shadow: 0 7px 14px rgba(50,50,93,.1), 0 3px 6px rgba(0,0,0,.08); }
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
    /* CSS Tambahan untuk Validasi Elegan */
    .custom-feedback-msg { margin-top: 5px; font-size: 0.8rem; }
    .border-danger-custom { border: 1px solid #dc3545 !important; }
    .is-invalid { border-color: #dc3545 !important; }
    .upload-box { transition: all 0.3s; }
    .upload-box.border-danger-custom { border: 2px dashed #dc3545 !important; background-color: rgba(220, 53, 69, 0.03); }

    /* Definisi Animasi Murni CSS */
    @keyframes fadeInUpModern {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Base class untuk elemen yang ingin dianimasikan */
    .animate-enter {
        opacity: 0; /* Sembunyikan di awal */
        /* fill-mode: forwards memastikan elemen tetap terlihat setelah animasi selesai */
        animation: fadeInUpModern 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Delay berurutan (Cascade Effect) */
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
</style>

<div class="main-form-container">
    <div class="anime-card animate-enter delay-1">
        <div class="anime-card-header d-flex justify-content-between align-items-center flex-wrap" style="background: #ffffff; padding: 25px 30px; border-bottom: 1px solid #f0f0f0;">
            <h4 class="m-0 font-weight-bold d-flex align-items-center" style="color: #32325d;">
                <i class="fas fa-film mr-3 text-primary"></i> 
                <div>
                    <span class="d-block">Tambah Episode Baru</span>
                    <!-- Menampilkan Judul Anime yang sedang ditambah episodenya -->
                    <small class="d-block text-muted mt-1" style="font-size: 0.9rem; font-weight: 500;">
                        <span class="text-primary font-weight-bold">"<?= esc($animeId['Judul']) ?>"</span>
                    </small>
                </div>
            </h4>
            
            <div class="header-badges mt-2 mt-sm-0">
                <!-- Badge ID Anime -->
                <span class="badge badge-primary-soft text-primary px-3 py-2 mr-2" style="border-radius: 10px;">Anime ID: #<?= $animeId['id'] ?></span>
                
                <!-- Badge Status Anime Saat Ini -->
                <?php if ($animeId['status'] === 'Completed'): ?>
                    <span class="badge badge-success px-3 py-2" style="border-radius: 10px;" title="Anime ini sudah tamat"><i class="fas fa-flag-checkered"></i> COMPLETED</span>
                <?php else: ?>
                    <span class="badge badge-warning px-3 py-2 text-dark" style="border-radius: 10px;" title="Anime ini sedang berjalan"><i class="fas fa-sync fa-spin"></i> ON-GOING</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body p-4">

            <!-- LEGENDA VALIDASI -->
            <div class="validation-legend mb-4" style="display: none; background-color: rgba(241, 245, 249, 0.5); padding: 10px 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <span class="text-danger font-weight-bold" style="font-size: 0.8rem;">
                    <i class="fas fa-times-circle"></i> Merah = Wajib Diisi (Form Gagal Simpan)
                </span>
            </div>

            <form id="episode-form" action="<?= url_to('prosesEpisode'); ?>" method="POST" enctype="multipart/form-data" novalidate>
                <?= csrf_field(); ?>
                <input type="hidden" name="anime_id" value="<?= $animeId['id'] ?>">

                <div class="row">
                    <!-- KOLOM KIRI: DATA TEKS -->
                    <div class="col-lg-6 pr-lg-5 border-right animate-enter delay-2">
                        <span class="form-section-title">Informasi Episode</span>

                        <div class="form-group custom-group">
                            <!-- UBAH LABEL INI -->
                            <label class="font-weight-bold" style="font-size: 14px;">Judul Episode <span class="label-optional">Opsional</span></label>
                            
                            <!-- HAPUS id="judul" DAN CLASS is-invalid/invalid-feedback -->
                            <input type="text" name="judul" class="form-control custom-input-style" placeholder="Contoh: Pertemuan Tak Terduga" value="<?= old('judul'); ?>" autofocus>
                        </div>

                        <div class="form-group custom-group">
                            <label class="font-weight-bold" style="font-size: 14px;">
                                Episode Ke-Berapa? <span class="text-danger-star">*</span>
                            </label>
                            
                            <?php 
                                $maxEps = ($totalEpisodeAnime > 0) ? $totalEpisodeAnime : 1000;
                                
                                // Cari episode terkecil berikutnya yang belum terunggah
                                $nextAvailable = null;
                                $semuaPenuh = true; // Flag untuk mengecek apakah sudah penuh

                                for ($i = 1; $i <= $maxEps; $i++) {
                                    if (!in_array($i, $episodeTerunggah)) {
                                        $nextAvailable = $i;
                                        $semuaPenuh = false; // Ternyata belum penuh
                                        break;
                                    }
                                }
                            ?>

                            <?php if ($semuaPenuh && $totalEpisodeAnime > 0): ?>
                                <!-- TAMPILAN JIKA EPISODE SUDAH FULL 12/12 -->
                                <div class="alert alert-success d-flex align-items-center mb-0 p-2" style="border-radius: 8px;">
                                    <i class="fas fa-check-circle fa-2x mr-3"></i>
                                    <div>
                                        <h6 class="m-0 font-weight-bold">Anime Sudah Tamat!</h6>
                                        <small>Seluruh <?= $totalEpisodeAnime ?> episode telah diunggah.</small>
                                    </div>
                                </div>
                                <!-- Input hidden kosong untuk mencegah error JS -->
                                <input type="hidden" name="episodeNumber" id="episodeNumber" value="">
                            
                            <?php else: ?>
                                <!-- TAMPILAN JIKA MASIH ADA EPISODE KOSONG -->
                                <select name="episodeNumber" id="episodeNumber" class="form-control custom-input-style" style="cursor: pointer;">
                                    <?php if ($maxEps == 1000): ?>
                                        <option value="" disabled selected>-- Pilih Episode (Total TBA) --</option>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $maxEps; $i++): ?>
                                        <?php if (in_array($i, $episodeTerunggah)): ?>
                                            <option value="<?= $i ?>" disabled style="color: #a0aec0; background: #f8f9fa;">
                                                Episode <?= $i ?> (Sudah Diunggah)
                                            </option>
                                        <?php else: ?>
                                            <option value="<?= $i ?>" <?= ($i == $nextAvailable) ? 'selected' : '' ?> style="font-weight: 600; color: #32325d;">
                                                Episode <?= $i ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </select>
                                
                                <?php if ($totalEpisodeAnime > 0): ?>
                                    <small class="text-muted mt-2 d-block">
                                        <i class="fas fa-info-circle text-primary"></i> Progress Upload: <strong><?= count($episodeTerunggah) ?> / <?= $totalEpisodeAnime ?></strong> Episode
                                    </small>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="form-group custom-group">
                            <!-- UBAH LABEL INI -->
                            <label class="font-weight-bold" style="font-size: 14px;">Deskripsi Ringkas <span class="label-optional">Opsional</span></label>
                            
                            <!-- HAPUS id="Desc" -->
                            <textarea name="Deskripsi" class="form-control custom-input-style" rows="5" placeholder="Tuliskan sedikit tentang isi episode ini..."><?= old('Deskripsi'); ?></textarea>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: MEDIA -->
                    <div class="col-lg-6 pl-lg-5 animate-enter delay-3">
                        <span class="form-section-title">Media Preview</span>

                        <!-- Preview Gambar (Hybrid) -->
                        <div class="upload-box p-3 mb-4" id="wrapperThumbnail" style="background:#f8f9fe; border-radius:15px; border:2px dashed #dee2e6; position: relative;">
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="font-weight-bold m-0 text-dark" style="font-size: 14px;">
                                    <i class="fas fa-image text-primary mr-1"></i> Gambar Preview
                                </label>
                                
                                <div class="file-info-badge m-0">
                                    <span class="file-info-item" style="padding: 2px 8px; font-size: 0.7rem;"><i class="fas fa-weight-hanging"></i> Maks 2 MB</span>
                                    <span class="file-info-item" style="padding: 2px 8px; font-size: 0.7rem;"><i class="fas fa-file-image"></i> JPG/PNG</span>
                                </div>
                            </div>

                            <div class="custom-file text-left mb-3">
                                <!-- TAMBAHKAN ATRIBUT ACCEPT -->
                                <input type="file" name="gambarPreview" id="gambarPreview" class="custom-file-input" accept="image/jpeg, image/png, image/webp" onchange="window.GambarPreview()">
                                <label class="custom-file-label" for="gambarPreview" id="labelGambarPreview" style="border-radius: 8px;">Pilih gambar manual...</label>
                            </div>
                            
                            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between p-2 mb-3" style="background: rgba(172, 17, 233, 0.05); border-radius: 8px; border: 1px solid rgba(172, 17, 233, 0.1);">
                                <button type="button" id="btn-auto-thumbnail" class="btn btn-sm btn-outline-primary mb-2 mb-sm-0" disabled onclick="window.generateThumbnailFromVideo()" style="border-radius: 6px; font-weight: 600; white-space: nowrap;">
                                    <i class="fas fa-camera retro-camera mr-1"></i> Potret dari Video
                                </button>
                                <small id="auto-thumb-help" class="text-muted text-center text-sm-right w-100 ml-sm-2" style="font-size: 0.75rem; line-height: 1.2;">
                                    (Unggah/putar video lokal terlebih dahulu)
                                </small>
                            </div>

                            <div class="position-relative text-center mt-2">
                                <!-- Gambar -->
                                <img src="/assets/images/default.jpg" class="img-preview-episode shadow-sm" id="img-preview-episode" style="width: 100%; border-radius: 12px; object-fit: cover; aspect-ratio: 16/9; border: 1px solid rgba(0,0,0,0.1); cursor: pointer;" onclick="window.zoomThumbnail(this.src)" title="Klik untuk memperbesar">
                                
                                <!-- Tombol Hapus (Pastikan ID ini ada) -->
                                <button type="button" class="btn btn-danger btn-sm position-absolute d-none" style="top: 10px; right: 10px; border-radius: 50%; width: 32px; height: 32px; z-index: 10; box-shadow: 0 4px 8px rgba(0,0,0,0.3);" id="btn-reset-thumbnail" onclick="window.resetThumbnail()" title="Hapus Thumbnail">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <!-- INPUT HIDDEN -->
                            <input type="hidden" name="auto_generated_thumbnail" id="auto_generated_thumbnail" value="">
                            <!-- Penanda hapus agar Controller PHP tahu (di Edit Form) -->
                            <input type="hidden" name="ThumbnailReset" id="ThumbnailReset" value="0">
                        </div>

                        <!-- UPLOAD BOX: VIDEO EPISODE -->
                        <div class="upload-box" id="wrapperVideo">
                            <label class="font-weight-bold mb-2 d-block text-dark text-left" style="font-size: 14px;">
                                <i class="fas fa-video text-primary mr-1"></i> Video Episode <span class="text-danger">*</span>
                            </label>

                            <div class="img-source-toggle mb-3">
                                <input type="radio" name="video_source_type" id="videoTypeUpload" value="upload" checked onchange="toggleVideoSource()">
                                <label for="videoTypeUpload"><i class="fas fa-file-upload mr-1"></i> Upload File Local</label>
                                
                                <input type="radio" name="video_source_type" id="videoTypeEmbed" value="embed" onchange="toggleVideoSource()">
                                <label for="videoTypeEmbed"><i class="fas fa-code mr-1"></i> Gunakan Link Embed</label>
                            </div>

                            <!-- AREA 1: UPLOAD LOCAL -->
                            <div id="videoUploadArea">
                                <small class="text-muted d-block text-left mb-2">Maks 100MB (MP4, AVI, MKV)</small>
                                
                                <div id="drop-zone-video" class="drop-zone">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Tarik Video Ke Sini atau Klik untuk Memilih</span>
                                </div>
                                <input type="file" name="video_path_dummy" id="video_path_input" accept="video/*" style="display: none;">
                                <input type="hidden" name="uploaded_temp_video" id="uploaded_temp_video" value="">
                                
                                <!-- PROGRESS BAR LOKAL (Gaya Modern Clean & Soft Purple) -->
                                <div id="local-progress-container" class="mt-3" style="display: none; background: #fdfafr; /* Putih dengan sedikit rona ungu */ padding: 18px; border-radius: 15px; border: 1px solid rgba(172, 17, 233, 0.2); box-shadow: 0 5px 15px rgba(172, 17, 233, 0.05);">
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Ikon Kotak Ungu (Dibuat sedikit lebih mencolok) -->
                                            <div class="file-icon-box d-flex align-items-center justify-content-center" style="background: rgba(172, 17, 233, 0.15); color: #ac11e9; width: 45px; height: 45px; border-radius: 12px; box-shadow: inset 0 0 10px rgba(255,255,255,0.5);">
                                                <i class="fas fa-file-video fa-lg"></i>
                                            </div>
                                            <div class="text-left">
                                                <!-- Teks nama file diubah menjadi gelap agar terbaca di background terang -->
                                                <span id="upload-filename" class="d-block font-weight-bold text-truncate" style="color: #32325d; font-size: 0.95rem; margin-bottom: 2px; max-width: 250px;">video_name.mp4</span>
                                                <small id="upload-filesize" class="text-muted font-weight-bold" style="font-size: 0.75rem;">0 MB • MP4</small>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Persentase Ungu -->
                                            <span id="upload-percentage" class="font-weight-bold" style="color: #ac11e9; font-size: 1rem;">0%</span>
                                            
                                            <!-- Tombol Silang -->
                                            <button type="button" class="btn btn-sm btn-link p-0 text-muted" onclick="window.removeVideo()" title="Batalkan Upload" style="text-decoration: none; font-size: 1.2rem; transition: color 0.3s;" onmouseover="this.style.color='#dc3545'" onmouseout="this.style.color='#a0aec0'">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Garis Progress Background (Abu-abu sangat terang) -->
                                    <div class="progress" style="height: 6px; border-radius: 6px; background: #e2e8f0; overflow: visible;">
                                        <!-- Background Gradient Ungu Neon untuk Progress yang Berjalan -->
                                        <div id="local-progress-bar" class="progress-bar" role="progressbar" style="width: 0%; background: linear-gradient(90deg, #d384fa, #ac11e9); border-radius: 6px; position: relative; transition: width 0.2s ease;">
                                            
                                            <!-- Cahaya Ungu (Glow Dot) di Ujung Bar -->
                                            <div style="position: absolute; right: -4px; top: -1px; width: 8px; height: 8px; background: #fff; border-radius: 50%; box-shadow: 0 0 8px 2px rgba(172, 17, 233, 0.6);"></div>
                                        </div>
                                    </div>
                                </div>

                                <div id="video-preview-container" class="mt-3" style="display: none;">
                                    <div class="position-relative bg-dark rounded-lg overflow-hidden shadow-sm" style="border: 1px solid rgba(255,255,255,0.1);">
                                        <video id="video-display" width="100%" height="auto" controls style="display: block; max-height: 300px; outline: none;"></video>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3 p-3" style="background: rgba(45, 206, 137, 0.1); border: 1px solid rgba(45, 206, 137, 0.2); border-radius: 10px;">
                                        <div id="video-file-info" class="text-success font-weight-bold" style="font-size: 0.85rem;">
                                            <i class="fas fa-check-circle mr-1"></i> Video Siap Disimpan
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center" onclick="removeVideo()" title="Hapus Video Ini" style="border-radius: 8px; font-weight: 600; padding: 6px 12px; font-size: 0.8rem;">
                                            <i class="fas fa-trash-alt mr-2"></i> Ganti Video
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- AREA 2: EMBED URL -->
                            <div id="videoEmbedArea" class="text-left" style="display: none;">
                                <small class="text-muted d-block mb-2">Masukkan link iFrame atau URL Direct Video (Server ke-3).</small>
                                <textarea name="video_embed_link" id="video_embed_input" class="form-control custom-input-style" rows="4" placeholder="Contoh: <iframe src='https://doodstream.com/...' frameborder='0' allowfullscreen></iframe>" oninput="previewEmbed()"></textarea>
                                
                                <div id="embed-preview-container" class="mt-3 bg-dark rounded overflow-hidden shadow-sm" style="display: none; aspect-ratio: 16/9; position: relative;">
                                    <div id="embed-display" style="width: 100%; height: 100%;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 animate-enter delay-4">
                            <?php if ($semuaPenuh && $totalEpisodeAnime > 0): ?>
                                <!-- Tombol Terkunci jika sudah 12/12 -->
                                <button type="button" class="btn btn-secondary btn-block" disabled style="border-radius: 12px; font-weight: bold; padding: 15px;">
                                    <i class="fas fa-lock mr-2"></i> Semua Episode Telah Diunggah
                                </button>
                            <?php else: ?>
                                <!-- Tombol Aktif -->
                                <button type="submit" class="btn btn-save btn-block shadow-primary">
                                    <i class="fas fa-upload mr-2"></i> Unggah Episode
                                </button>
                            <?php endif; ?>
                            
                            <a href="<?= url_to('viewDetail',  $animeId['slug']); ?>" class="btn btn-light btn-block text-muted mt-2" style="border-radius: 12px; font-weight: 600;">Batal & Kembali</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    // =====================================================================
    // 1. VARIABEL GLOBAL (Agar bisa diakses oleh semua fungsi)
    // =====================================================================
    let currentUploadRequest = null; // Variabel untuk menyimpan proses AJAX upload

    // =====================================================================
    // 2. FUNGSI GLOBAL & VANILLA JS
    // =====================================================================

    // --- 1. FUNGSI TOGGLE SWITCH (Upload vs Embed) ---
    window.toggleVideoSource = function() {
        const isUpload = document.getElementById('videoTypeUpload').checked;
        const uploadArea = document.getElementById('videoUploadArea');
        const embedArea = document.getElementById('videoEmbedArea');
        
        // Elemen khusus fitur Thumbnail
        const btnAutoThumb = document.getElementById('btn-auto-thumbnail');
        const helpTextThumb = document.getElementById('auto-thumb-help');

        if (isUpload) {
            // JIKA PINDAH KE TAB UPLOAD LOCAL
            if(uploadArea) uploadArea.style.display = 'block';
            if(embedArea) embedArea.style.display = 'none';
            
            // Cek apakah video sudah sempat terupload (misal: admin bolak-balik tab)
            const tempVideo = document.getElementById('uploaded_temp_video');
            if (btnAutoThumb && helpTextThumb) {
                if (tempVideo && tempVideo.value.trim() !== '') {
                    // Video sudah ada, aktifkan tombol jepret!
                    btnAutoThumb.disabled = false;
                    btnAutoThumb.classList.remove('btn-outline-primary');
                    btnAutoThumb.classList.add('btn-primary');
                    helpTextThumb.innerHTML = "Geser video ke scene favorit, lalu klik tombol ini.";
                    helpTextThumb.className = "text-success font-weight-bold ml-2 text-center text-sm-right w-100";
                } else {
                    // Video belum ada, kunci tombol
                    btnAutoThumb.disabled = true;
                    btnAutoThumb.classList.remove('btn-primary');
                    btnAutoThumb.classList.add('btn-outline-primary');
                    helpTextThumb.innerHTML = "(Unggah/putar video lokal terlebih dahulu)";
                    helpTextThumb.className = "text-muted text-center text-sm-right w-100 ml-sm-2";
                }
            }
        } else {
            // JIKA PINDAH KE TAB EMBED URL
            if(uploadArea) uploadArea.style.display = 'none';
            if(embedArea) embedArea.style.display = 'block';
            
            // ==========================================
            // KUNCI TOMBOL JEPRET (KARENA CORS IFRAME)
            // ==========================================
            if (btnAutoThumb && helpTextThumb) {
                btnAutoThumb.disabled = true;
                btnAutoThumb.classList.remove('btn-primary');
                btnAutoThumb.classList.add('btn-outline-primary');
                
                // Beritahu Admin kenapa tombolnya mati!
                helpTextThumb.innerHTML = '<i class="fas fa-info-circle text-warning"></i> Fitur potret layar tidak tersedia untuk video Embed/Iframe.';
                helpTextThumb.className = "text-muted text-center text-sm-right w-100 ml-sm-2";
            }

            // ==========================================
            // KUNCI PENGAMANAN: HAPUS VIDEO LOKAL (JIKA ADA)
            // ==========================================
            const tempInputEl = document.querySelector('input[name="uploaded_temp_video"]');
            if (tempInputEl && tempInputEl.value.trim() !== '') {
                const tempFilename = tempInputEl.value.trim();
                
                // Tembak AJAX hapus file
                const formData = new FormData();
                formData.append('filename', tempFilename);
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) formData.append('<?= csrf_token() ?>', csrfToken.getAttribute('content'));

                fetch('<?= base_url('dashboard/detail/deleteTempVideo') ?>', {
                    method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' }
                }).catch(err => console.error("Error hapus file temp otomatis:", err));

                // Reset UI Upload Area
                tempInputEl.value = ''; 
                const videoInputEl = document.querySelector('input[type="file"][name="video_path_dummy"]');
                if (videoInputEl) videoInputEl.value = ''; 
                
                const videoPreview = document.getElementById('video-display');
                if (videoPreview) { videoPreview.pause(); videoPreview.removeAttribute('src'); videoPreview.load(); }
                
                const containerEl = document.getElementById('video-preview-container');
                if (containerEl) containerEl.style.display = 'none';
                
                const dropZoneEl = document.getElementById('drop-zone-video');
                if (dropZoneEl) dropZoneEl.style.display = 'flex';
                
                const progContainer = document.getElementById('local-progress-container');
                if (progContainer) progContainer.style.display = 'none';
            }
        }
    };

    window.previewEmbed = function() {
        const embedInput = document.getElementById('video_embed_input').value.trim();
        const embedContainer = document.getElementById('embed-preview-container');
        const embedDisplay = document.getElementById('embed-display');

        if (!embedContainer || !embedDisplay) return;

        if (embedInput !== '') {
            // Regex ketat: Harus ada <iframe, harus ada src="http...", dan harus ada </iframe>
            const isStrictIframe = /^<iframe[^>]+src=["'](https?:\/\/[^"']+)["'][^>]*>.*?<\/iframe>$/is.test(embedInput);

            if (isStrictIframe) {
                embedContainer.style.display = 'block';
                embedDisplay.innerHTML = embedInput;
                const iframe = embedDisplay.querySelector('iframe');
                if (iframe) {
                    iframe.style.width = '100%';
                    iframe.style.height = '100%';
                }
            } else {
                // Jika belum lengkap, sembunyikan preview (Jangan render setengah-setengah)
                embedContainer.style.display = 'none';
                embedDisplay.innerHTML = '';
            }
        } else {
            embedContainer.style.display = 'none';
            embedDisplay.innerHTML = '';
        }
    };

    // --- FUNGSI PREVIEW THUMBNAIL MANUAL (Dari File Lokal) ---
    window.GambarPreview = function() {
        const gambar = document.getElementById('gambarPreview');
        const imgPreview = document.getElementById('img-preview-episode');
        
        // Kita gunakan ID yang sudah Anda buat di HTML: id="labelGambarPreview"
        const fileLabel = document.getElementById('labelGambarPreview');
        
        const btnReset = document.getElementById('btn-reset-thumbnail');
        const hiddenInput = document.getElementById('auto_generated_thumbnail');
        const inputResetFlag = document.getElementById('ThumbnailReset');

        if(gambar && gambar.files.length > 0 && imgPreview) {
            const file = gambar.files[0];
            const fileGambar = new FileReader();
            
            // 1. MENGUBAH TEKS LABEL DENGAN AMAN
            if (fileLabel) {
                // Kita ganti isinya dengan teks biasa, dan tambahkan sedikit padding agar tidak nabrak tombol Browse
                fileLabel.innerHTML = `<span style="color: #ac11e9; font-weight: 800; display: inline-block; max-width: 70%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${file.name}</span>`;
            }

            fileGambar.readAsDataURL(file);
            fileGambar.onload = function(e) { 
                // 2. Ganti sumber gambar preview
                imgPreview.src = e.target.result; 
                
                // 3. Munculkan tombol X (Hapus)
                if (btnReset) btnReset.classList.remove('d-none');
                
                // 4. Kosongkan data base64 jepretan sebelumnya
                if (hiddenInput) hiddenInput.value = '';
                
                // 5. (Khusus Form Edit) Jika ada flag reset
                if(inputResetFlag) inputResetFlag.value = '0';
            }
        }
    };


    // --- FUNGSI 3: ZOOM GAMBAR DENGAN SWEETALERT ---
    window.zoomThumbnail = function(imgSrc) {
        // Jangan zoom jika gambarnya masih default
        if (imgSrc.includes('default.jpg')) return;

        Swal.fire({
            imageUrl: imgSrc,
            imageAlt: 'Thumbnail Preview',
            showConfirmButton: false,
            showCloseButton: true,
            background: 'rgba(20,20,30,0.9)', // Tema gelap
            backdrop: 'rgba(0,0,0,0.8)', // Blur background
            customClass: {
                image: 'rounded-lg shadow-lg w-100', // Paksa gambar fullscreen
                popup: 'p-2'
            },
            width: '80%' // Ukuran pop-up 80% layar
        });
    };

    // --- GARBAGE COLLECTOR (AUTO-DELETE SAAT HALAMAN DITUTUP/RELOAD) ---
    window.addEventListener('beforeunload', function (e) {
        const tempInput = document.getElementById('uploaded_temp_video');
        
        if (tempInput) {
            const tempFilename = tempInput.value.trim();
            if (tempFilename !== '') {
                const formData = new FormData();
                formData.append('filename', tempFilename);
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (csrfToken) {
                    formData.append('<?= csrf_token() ?>', csrfToken);
                }

                navigator.sendBeacon('<?= base_url('dashboard/detail/deleteTempVideo') ?>', formData);
            }
        }
    });

    // --- FUNGSI BARU: AUTO-GENERATE THUMBNAIL DARI VIDEO ---
    
    // Fungsi ini dipanggil dari dalam logika Upload Video jika sukses
    window.unlockAutoThumbnail = function() {
        const btnAuto = document.getElementById('btn-auto-thumbnail');
        const helpText = document.getElementById('auto-thumb-help');
        
        if (btnAuto) {
            btnAuto.disabled = false; // Buka kunci tombol
            btnAuto.classList.remove('btn-outline-primary');
            btnAuto.classList.add('btn-primary'); // Ubah warna jadi solid
        }
        if (helpText) {
            helpText.innerHTML = "Geser video ke scene favorit, lalu klik tombol ini.";
            helpText.classList.remove('text-muted');
            helpText.classList.add('text-success', 'font-weight-bold');
        }
    };

    // --- FUNGSI UTAMA JEPRET LAYAR VIDEO (SMART SCREENSHOT) ---
    window.generateThumbnailFromVideo = function() {
        const videoElement = document.getElementById('video-display');
        const imgPreview = document.getElementById('img-preview-episode');
        const hiddenInput = document.getElementById('auto_generated_thumbnail');
        const fileInput = document.getElementById('gambarPreview');
        const fileLabel = document.getElementById('labelGambarPreview');

        // PASTIKAN VIDEO ADA DAN SUDAH BISA DIBACA BROWSER
        if (!videoElement || videoElement.readyState < 2) {
            Swal.fire({
                icon: 'warning',
                title: 'Video Belum Siap',
                text: 'Harap tunggu video selesai dimuat atau putar video sebentar.',
                confirmButtonColor: '#ac11e9'
            });
            return;
        }

        // Tampilkan loading kecil
        Swal.fire({
            toast: true, position: 'top-end', showConfirmButton: false,
            title: '<i class="fas fa-spinner fa-spin text-primary"></i> Memotret frame...',
            didOpen: () => {
                
                // BUAT KANVAS BAYANGAN
                const canvas = document.createElement('canvas');
                // Samakan rasio kanvas dengan resolusi asli video (Bukan ukuran tampilannya)
                canvas.width = videoElement.videoWidth;
                canvas.height = videoElement.videoHeight;
                const ctx = canvas.getContext('2d');

                // LUKIS FRAME SAAT INI (Tepat di detik admin mem-pause video)
                ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

                try {
                    const dataURL = canvas.toDataURL('image/jpeg', 0.85);

                    if (imgPreview) imgPreview.src = dataURL;
                    if (hiddenInput) hiddenInput.value = dataURL;
                    
                    // Reset indikator hapus jika ada (untuk form edit)
                    const inputResetFlag = document.getElementById('ThumbnailReset');
                    if (inputResetFlag) inputResetFlag.value = '0';

                    if (fileInput) fileInput.value = '';
                    
                    // 1. Munculkan tombol X
                    const btnReset = document.getElementById('btn-reset-thumbnail');
                    if (btnReset) btnReset.classList.remove('d-none');

                    // 2. Beri teks Auto-Generated
                    if (fileLabel) {
                        fileLabel.innerHTML = '<span class="text-success" id="autoGenLabel"><i class="fas fa-check-circle"></i> Auto-Generated (Dari Video)</span>';
                        
                        // 3. SET TIMER 5 DETIK UNTUK MENGHAPUS TEKS
                        setTimeout(() => {
                            const autoLabel = document.getElementById('autoGenLabel');
                            if (autoLabel) {
                                fileLabel.innerHTML = 'Pilih gambar manual...'; // Kembalikan ke asal
                            }
                        }, 5000);
                    }

                    Swal.fire({
                        toast: true, position: 'top-end', icon: 'success',
                        title: 'Frame berhasil dipotret!',
                        showConfirmButton: false, timer: 2000
                    });

                } catch (e) {
                    console.error("Gagal membuat thumbnail:", e);
                    Swal.fire({
                        toast: true, position: 'top-end', icon: 'error',
                        title: 'Gagal memotret frame. Terjadi kesalahan teknis.',
                        showConfirmButton: false, timer: 3000
                    });
                }
            }
        });
    };

    // --- FUNGSI RESET THUMBNAIL ---
    window.resetThumbnail = function() {
        const imgPreview = document.getElementById('img-preview-episode');
        const fileInput = document.getElementById('gambarPreview');
        const fileLabel = document.getElementById('labelGambarPreview');
        const btnReset = document.getElementById('btn-reset-thumbnail');
        const hiddenInput = document.getElementById('auto_generated_thumbnail');
        const inputResetFlag = document.getElementById('ThumbnailReset');

        if (imgPreview) imgPreview.src = '<?= base_url('assets/images/default.jpg') ?>';
        
        if (fileInput) fileInput.value = ''; 
        
        // KEMBALIKAN LABEL KE TEKS AWAL
        if (fileLabel) {
            fileLabel.innerHTML = 'Pilih gambar manual...';
        }
        
        if (hiddenInput) hiddenInput.value = '';
        if (inputResetFlag) inputResetFlag.value = '1';
        if (btnReset) btnReset.classList.add('d-none');
    };

    // --- FUNGSI TOMBOL "X" / BATAL UPLOAD (Diperbaiki & Tahan Banting) ---
    window.removeVideo = function() {
        console.log("Menjalankan removeVideo...");
        try {
            // 1. BATALKAN PROSES UPLOAD JIKA SEDANG BERJALAN
            if (currentUploadRequest) {
                currentUploadRequest.abort(); 
                console.log("Koneksi upload diputus secara paksa.");
                currentUploadRequest = null;
            }

            // 2. AMBIL DAN KOSONGKAN HIDDEN INPUT
            const $tempInput = $('#uploaded_temp_video');
            const tempFilename = $tempInput.val();
            const btnAuto = document.getElementById('btn-auto-thumbnail');
            const helpText = document.getElementById('auto-thumb-help');
            if (btnAuto) {
                btnAuto.disabled = true;
                btnAuto.classList.remove('btn-primary');
                btnAuto.classList.add('btn-outline-primary');
            }
            if (helpText) {
                helpText.innerHTML = "(Unggah/putar video lokal terlebih dahulu)";
                helpText.className = "text-muted ml-2";
            }
            // Kosongkan hidden input jepretan
            const hiddenThumb = document.getElementById('auto_generated_thumbnail');
            if(hiddenThumb) hiddenThumb.value = '';

            $tempInput.val(''); // Langsung kosongkan agar tidak ter-submit

            // 3. HAPUS FILE DI SERVER (JIKA ADA)
            if (tempFilename && tempFilename.trim() !== '') {
                const formData = new FormData();
                formData.append('filename', tempFilename);
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) formData.append('<?= csrf_token() ?>', csrfToken.getAttribute('content'));

                fetch('<?= base_url('dashboard/detail/deleteTempVideo') ?>', {
                    method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' }
                }).catch(err => console.error(err));
            }

            // 4. RESET DOM & INPUT
            $('#video_path_input').val('');
            
            // 5. RESET UI VIDEO PLAYER
            const videoPreview = document.getElementById('video-display');
            if (videoPreview) {
                videoPreview.pause();
                videoPreview.removeAttribute('src');
                videoPreview.load();
            }

            // 6. ATUR ULANG VISIBILITAS CONTAINER
            $('#video-preview-container').hide();
            $('#local-progress-container').hide();
            $('#drop-zone-video').css('display', 'flex'); 
            
            // 7. KEMBALIKAN PROGRESS BAR KE 0
            $('#local-progress-bar').css('width', '0%');
            $('#upload-percentage').text('0%');

            // 8. BUKA KUNCI SUBMIT
            $('button[type="submit"]').prop('disabled', false);

            console.log("UI berhasil di-reset!");

        } catch (e) {
            console.error("Terjadi error saat membatalkan video:", e);
        }
    };

    // =====================================================================
    // 3. LOGIKA JQUERY (Drag & Drop, Upload, Submit)
    // =====================================================================
    $(document).ready(function() {
        const dropZone = $('#drop-zone-video');
        const videoInput = $('#video_path_input'); 
        const videoPreview = document.getElementById('video-display');
        const container = $('#video-preview-container');

        if (dropZone.length === 0) return; 

        dropZone.on('click', function() { videoInput.click(); });
        videoInput.on('change', function() { displayFileDetailsAndUpload(); });

        dropZone.on('dragover', function(e) {
            e.preventDefault();
            $(this).css({'border-color': '#ac11e9', 'background': 'rgba(172, 17, 233, 0.05)'}); 
        });

        dropZone.on('dragleave', function(e) {
            e.preventDefault();
            $(this).css({'border-color': '#dee2e6', 'background': '#f8f9fe'});
        });

        dropZone.on('drop', function(e) {
            e.preventDefault();
            $(this).css({'border-color': '#dee2e6', 'background': '#f8f9fe'});
            const files = e.originalEvent.dataTransfer.files;
            if(files.length > 0) {
                videoInput[0].files = files; 
                displayFileDetailsAndUpload(); 
            }
        });

        function displayFileDetailsAndUpload() {
            if (!videoInput[0].files || videoInput[0].files.length === 0) return;
            const file = videoInput[0].files[0];
            
            if (file.size > 100 * 1024 * 1024) {
                Swal.fire('Terlalu Besar', 'Maksimal ukuran video adalah 100MB', 'error');
                videoInput.val('');
                return;
            }

            // --- INJEKSI DATA FILE KE UI PROGRESS BAR ---
            const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
            const fileExt = file.name.split('.').pop().toUpperCase();
            
            document.getElementById('upload-filename').innerText = file.name;
            document.getElementById('upload-filesize').innerText = `${fileSizeMB} MB • ${fileExt}`;
            // --------------------------------------------

            dropZone.hide();
            $('#local-progress-container').show();
            $('button[type="submit"]').prop('disabled', true); 

            let formData = new FormData();
            formData.append('video_path', file);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            // SIMPAN REQUEST KE VARIABEL GLOBAL
            currentUploadRequest = $.ajax({
                url: '<?= base_url('dashboard/detail/uploadTempVideo') ?>', 
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percent = parseInt((evt.loaded / evt.total) * 100);
                            $('#local-progress-bar').css('width', percent + '%');
                            $('#upload-percentage').text(percent + '%'); 
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    currentUploadRequest = null; 
                    
                    $('#local-progress-container').hide();
                    $('#uploaded_temp_video').val(response.filename); 
                    
                    const fileURL = URL.createObjectURL(file);
                    if(videoPreview) {
                        videoPreview.src = fileURL;
                        videoPreview.load();
                    }
                    container.show();
                    $('button[type="submit"]').prop('disabled', false); 

                    // --- TAMBAHKAN BARIS INI: Buka kunci tombol kamera ---
                    window.unlockAutoThumbnail(); 

                    const videoWrapper = document.getElementById('wrapperVideo');
                    if (videoWrapper) {
                        // Hapus kotak putus-putus merah
                        videoWrapper.classList.remove('border-danger-custom');
                        
                        // Hapus teks pesan merah di bawah kotak video
                        const feedback = videoWrapper.querySelector('.custom-feedback-msg');
                        if (feedback) feedback.remove();
                    }
                    // ==========================================
                },
                error: function(xhr, status, error) {
                    currentUploadRequest = null; 
                    
                    // Jika dibatalkan oleh user (abort), jangan tampilkan error alert
                    if (status === 'abort') {
                        console.log('Upload dibatalkan.');
                        return; 
                    }

                    $('#local-progress-container').hide();
                    dropZone.show();
                    videoInput.val('');
                    let errMsg = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Gagal mengunggah video ke server.';
                    Swal.fire('Gagal!', errMsg, 'error');
                    $('button[type="submit"]').prop('disabled', false); 
                }
            });
        }

        // --- FUNGSI HELPER VALIDASI ---
        function addFeedbackText(element, customText) {
            let parent = element.parentElement;
            if (element.classList.contains('border-left-0')) {
                parent = parent.parentElement;
            }
            if(!parent) return;

            let oldFeedback = parent.querySelector('.custom-feedback-msg');
            if (oldFeedback) oldFeedback.remove();

            let msg = document.createElement('small');
            msg.className = 'custom-feedback-msg text-danger mt-1 font-weight-bold d-block text-left';
            msg.innerHTML = `<i class="fas fa-times-circle"></i> ${customText}`;
            parent.appendChild(msg);
        }

        function removeFeedbackOnInput() {
            document.querySelectorAll('#episode-form input, #episode-form textarea').forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                    let parent = this.parentElement;
                    if (this.classList.contains('border-left-0')) parent = parent.parentElement;
                    
                    const feedback = parent.querySelector('.custom-feedback-msg');
                    if (feedback) feedback.remove();
                });
            });
        }
        removeFeedbackOnInput();

        $('#episode-form').on('submit', function(e) {
            e.preventDefault();
            
            let isFormValid = true;
            let errorMessages = [];

            // Bersihkan error lama (Merah & Kuning)
            $('.is-invalid, .is-warning, .border-danger-custom, .border-warning-custom').removeClass('is-invalid is-warning border-danger-custom border-warning-custom');
            $('.custom-feedback-msg').remove();

            // ==========================================
            // 1. CEK FIELD WAJIB (MERAH)
            // ==========================================
            // HANYA Episode Number yang wajib sekarang!
            const reqFields = [
                { id: 'episodeNumber', name: 'Episode Ke-Berapa' }
            ];

            reqFields.forEach(field => {
                const el = document.getElementById(field.id);
                if (el && el.value.trim() === '') {
                    el.classList.add('is-invalid');
                    addFeedbackText(el, false, `${field.name} Wajib Diisi!`);
                    errorMessages.push(`<b>${field.name}</b> masih kosong.`);
                    isFormValid = false;
                }
            });

            // ==========================================
            // 2. CEK FIELD OPSIONAL (KUNING)
            // ==========================================
            // Judul dan Deskripsi masuk ke sini agar diwarnai kuning jika kosong
            const optionalFields = [
                { id: 'judul', name: 'Judul Episode' },
                { id: 'Desc', name: 'Deskripsi Ringkas' }
            ];

            optionalFields.forEach(field => {
                const el = document.getElementById(field.id);
                if (el && el.value.trim() === '') {
                    el.classList.add('is-warning'); // Beri warna kuning
                    // Beri pesan bahwa sistem akan mengisi otomatis
                    addFeedbackText(el, true, "Belum diisi. Sistem akan mengisinya otomatis."); 
                }
            });

            // ==========================================
            // 3. CEK VIDEO & MEDIA (Sisi Kanan)
            // ==========================================
            const isUpload = document.getElementById('videoTypeUpload').checked;
            const videoWrapper = document.getElementById('wrapperVideo');
            
            if (isUpload) {
                const tempVideoName = $('#uploaded_temp_video').val();
                if (!tempVideoName || tempVideoName.trim() === '') {
                    if (videoWrapper) {
                        videoWrapper.classList.add('border-danger-custom');
                        
                        let oldFeedback = videoWrapper.querySelector('.custom-feedback-msg');
                        if (oldFeedback) oldFeedback.remove(); 

                        let msg = document.createElement('small');
                        msg.className = 'custom-feedback-msg text-danger mt-2 font-weight-bold d-block text-center';
                        msg.innerHTML = `<i class="fas fa-times-circle"></i> Anda belum mengunggah Video Local!`;
                        videoWrapper.appendChild(msg); 
                    }
                    errorMessages.push("<b>Video Episode Local</b> belum diunggah.");
                    isFormValid = false;
                }
            } else {
                const embedEl = document.getElementById('video_embed_input');
                const embedText = embedEl ? embedEl.value.trim() : '';
                
                if (embedText === '') {
                    embedEl.classList.add('is-invalid');
                    addFeedbackText(embedEl, false, "Link Embed tidak boleh kosong!");
                    errorMessages.push("<b>Link Embed Video</b> masih kosong.");
                    isFormValid = false; // Gunakan isFormValid (jangan isValid agar konsisten)
                } 
                else {
                    const forbiddenExts = ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.svg'];
                    const lowerLink = embedText.toLowerCase();
                    const isImage = forbiddenExts.some(ext => lowerLink.endsWith(ext) || lowerLink.includes(ext + '?'));

                    const isIframeValid = /^<iframe[^>]+src=["'](https?:\/\/[^"']+)["'][^>]*>.*?<\/iframe>$/is.test(embedText);

                    if (isImage) {
                        embedEl.classList.add('is-invalid');
                        addFeedbackText(embedEl, false, "Harap masukkan link Video, bukan Gambar!");
                        errorMessages.push("Link Embed berisi format <b>Gambar</b>.");
                        isFormValid = false;
                    } else if (!isIframeValid) {
                        embedEl.classList.add('is-invalid');
                        addFeedbackText(embedEl, false, "Format Salah! Masukkan kode lengkap: &lt;iframe src='...'&gt;&lt;/iframe&gt;");
                        errorMessages.push("Format <b>Link Embed</b> bukan tag Iframe yang valid.");
                        isFormValid = false;
                    }
                }
            }

            // ==========================================
            // KESIMPULAN AKHIR
            // ==========================================
            if (!isFormValid) {
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
                    }
                });
                return false; // Hentikan proses simpan
            }

            // JIKA SEMUA VALID (Yang merah tidak ada, kuning diabaikan)
            let embedInput = document.getElementById('video_embed_input');
            let originalEmbedValue = embedInput ? embedInput.value : '';

            if (!isUpload && embedInput && embedInput.value.trim() !== '') {
                embedInput.value = btoa(unescape(encodeURIComponent(embedInput.value))); 
            }

            Swal.fire({
                title: isUpload ? 'Memproses...' : 'Menyimpan...',
                html: '<small class="text-muted">Menyimpan data episode...</small>',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            const formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const tempInput = document.getElementById('uploaded_temp_video');
                    if(tempInput) tempInput.value = '';

                    Swal.fire('Sukses!', 'Episode berhasil ditambahkan.', 'success')
                    .then(() => { window.location.href = '<?= url_to('viewDetail', $animeId['slug']) ?>'; });
                },
                error: function(xhr) {
                    if(embedInput) embedInput.value = originalEmbedValue;
                    let errMsg = 'Terjadi kesalahan saat menyimpan.';
                    if(xhr.responseJSON && xhr.responseJSON.error) {
                        errMsg = Object.values(xhr.responseJSON.error).join("<br>");
                    }
                    Swal.fire('Gagal!', errMsg, 'error');
                }
            });
        });

    });
</script>
<?= $this->endSection() ?>