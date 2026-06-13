<?= $this->extend('user/pageLayoutInfo') ?>

<?= $this->section('Judul') ?>
<?= $title ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<style>

</style>
    <!-- VIDEO -->
    <section class="theater-section">
    <div class="theater-container">
        <div class="video-header mb-4">
            <h1 class="episode-title">
                <span class="text-primary-neon">Preview:</span> <?= $episode['judul'] ?>
            </h1>
            <p class="anime-breadcrumb text-muted">
                <!-- Link kembali ke detail anime -->
                <a href="<?= url_to('animeDetail', $anime['slug']) ?>" class="breadcrumb-link">
                    <?= $anime['Judul'] ?>
                </a> 
                &nbsp;•&nbsp; Episode <?= $episode['episode_number'] ?>
            </p>
    </div>

    <div class="video-player-wrapper shadow-lg" style="position: relative; width: 100%; aspect-ratio: 16/9; background: #000; border-radius: 12px; overflow: hidden;">
            <?php if (!empty($episode['video_path'])): ?>
                <?php 
                    $videoData = $episode['video_path'];
                    $thumbnailPath = 'assets/thumbnails/thumbnail_' . pathinfo($videoData, PATHINFO_FILENAME) . '.jpg';
                    $hasThumbnail = file_exists(FCPATH . $thumbnailPath);
                    $posterAttr = $hasThumbnail ? 'poster="'.base_url($thumbnailPath).'"' : '';
                ?>
                
                <!-- 1. JIKA VIDEO ADALAH IFRAME EMBED ATAU LINK EKSTERNAL -->
                <?php if (strpos($videoData, '<iframe') !== false || filter_var($videoData, FILTER_VALIDATE_URL)): ?>
                    
                    <?php 
                        $cleanIframe = "";
                        $embedUrl = "";
                        
                        // KASUS A: Jika data yang tersimpan adalah tag <iframe ...>
                        if (strpos($videoData, '<iframe') !== false) {
                            $iframeHtml = htmlspecialchars_decode($videoData);
                            
                            // CARI HANYA ISI DARI ATRIBUT src="..."
                            // Menggunakan regex untuk mengekstrak URL saja, mengabaikan atribut sampah lainnya
                            if (preg_match('/src=["\']([^"\']+)["\']/i', $iframeHtml, $matches)) {
                                $embedUrl = $matches[1];
                            }
                        } 
                        // KASUS B: Jika Admin mem-paste URL biasa (https://...)
                        else if (filter_var($videoData, FILTER_VALIDATE_URL) && strpos($videoData, '.mp4') === false) {
                            $embedUrl = $videoData;
                        }

                        // JIKA URL DITEMUKAN, BANGUN ULANG TAG IFRAME DARI AWAL! (Sangat Aman)
                        if (!empty($embedUrl)) {
                            // Sanitasi URL untuk keamanan ekstra
                            $embedUrl = esc($embedUrl);
                            
                            // Buat iframe baru yang 100% bersih, responsif, dan standar
                            $cleanIframe = '<iframe src="' . $embedUrl . '" width="100%" height="100%" style="position:absolute; top:0; left:0; border:none;" allowfullscreen allow="autoplay; fullscreen; picture-in-picture"></iframe>';
                        }
                    ?>
                    
                    <!-- BUNGKUS IFRAME -->
                    <?php if (!empty($cleanIframe)): ?>
                        <div id="embed-wrapper" style="width: 100%; height: 100%; display: block;" data-episode-id="<?= $episode['id'] ?>">
                            <?= $cleanIframe ?>
                        </div>
                    <?php else: ?>
                        <!-- Fallback jika gagal mengekstrak URL -->
                        <div class="video-placeholder d-flex flex-column align-items-center justify-content-center h-100 text-white">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3 text-warning"></i>
                            <h5 class="text-muted">Gagal memuat Iframe. Format URL tidak valid.</h5>
                        </div>
                    <?php endif; ?>

                <!-- 2. JIKA VIDEO ADALAH FILE LOKAL (.mp4) -->
                <?php else: ?>
                    <?php 
                        $videoUrl = filter_var($videoData, FILTER_VALIDATE_URL) ? $videoData : base_url('assets/videos/' . $videoData); 
                    ?>
                    <video id="video-player" class="video-js vjs-big-play-centered vjs-theme-city" controls preload="auto" <?= $posterAttr ?> data-setup="{}" data-episode-id="<?= $episode['id'] ?>" style="width: 100%; height: 100%; outline: none;">
                        <source src="<?= esc($videoUrl) ?>" type="video/mp4">
                        Maaf, browser Anda tidak mendukung pemutar video.
                    </video>
                <?php endif; ?>

            <?php else: ?>
                <!-- JIKA VIDEO KOSONG -->
                <div class="video-placeholder d-flex flex-column align-items-center justify-content-center h-100 text-white">
                    <i class="fas fa-video-slash fa-3x mb-3 text-muted"></i>
                    <h2>Video tidak tersedia saat ini.</h2>
                </div>
            <?php endif; ?>
        </div>

        <!-- Navigation Buttons -->
        <div class="video-nav-controls mt-4">
            <div class="nav-btn-group">
                <?php if ($EpisodeSebelumnya): ?>
                    <a href="<?= url_to('showPreviewVideo', $anime['slug'], $EpisodeSebelumnya['slug-episode']); ?>" class="nav-btn prev">
                        <i class="fas fa-chevron-left"></i> <span>Episode Sebelumnya</span>
                    </a>
                <?php endif; ?>
                
                <?php if ($EpisodeSelanjutnya): ?>
                    <a href="<?= url_to('showPreviewVideo', $anime['slug'], $EpisodeSelanjutnya['slug-episode']); ?>" class="nav-btn next">
                        <span>Episode Selanjutnya</span> <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="episode-list-section">
    <div class="container-fluid px-lg-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <h3 class="m-0"><i class="fas fa-layer-group text-primary-neon mr-2"></i> DAFTAR EPISODE</h3>
            
            <!-- EPISODE CONTROLS -->
            <div class="ep-controls-wrapper d-flex align-items-center gap-3">
                <div class="ep-search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="epSearchInput" placeholder="Cari episode..." autocomplete="off">
                </div>

                <div class="ep-sort-pills">
                    <button class="sort-pill active" id="sortNewest" title="Terbaru"><i class="fas fa-sort-numeric-down-alt"></i></button>
                    <button class="sort-pill" id="sortOldest" title="Terlama"><i class="fas fa-sort-numeric-up"></i></button>
                </div>
            </div>
        </div>

        <!-- 1. KONTEN BAYANGAN (SKELETON) -->
        <div id="epSearchSkeleton" class="episode-modern-grid mt-4" style="display: none;">
            <?php for($i=0; $i<6; $i++): ?>
                <div class="skeleton-card-ep">
                    <div class="skeleton-img"></div>
                    <div class="skeleton-text-row"></div>
                </div>
            <?php endfor; ?>
        </div>

        <!-- 2. GRID EPISODE ASLI -->
        <div class="episode-modern-grid mt-4" id="episodeContainer">
            <?php if (!empty($allEpisodes)) : ?>
                <?php foreach ($allEpisodes as $animeEpisode) : ?>
                    <?php 
                        $isActive = ($animeEpisode['id'] == $episode['id']);
                        $viewCount = formatViews($animeEpisode['view_count']); 
                    ?>
                    
                    <div class="episode-item" 
                         data-number="<?= $animeEpisode['episode_number'] ?>" 
                         data-title="<?= strtolower($animeEpisode['judul'] ?? '') ?>">
                        
                        <div class="episode-card-modern <?= $isActive ? 'active' : '' ?>">
                            <a href="<?= $isActive ? 'javascript:void(0);' : url_to('showPreviewVideo', $anime['slug'], $animeEpisode['slug-episode']); ?>">
                                <div class="ep-img-box" style="background-image: url(<?= base_url('assets/imgPreview/' . $animeEpisode['GambarPreview']); ?>);">
                                    <?php if (isNew($animeEpisode['created_at'])) : ?>
                                        <div class="badge-new-episode"><span>NEW</span></div>
                                    <?php endif; ?>
                                    
                                    <?php if ($isActive): ?>
                                        <div class="watching-badge"><i class="fas fa-play"></i> Sedang Ditonton</div>
                                    <?php else: ?>
                                        <div class="ep-play-icon"><i class="fas fa-play"></i></div>
                                    <?php endif; ?>
                                </div>
                                <div class="ep-text">
                                    <span class="ep-label">Episode <?= $animeEpisode['episode_number'] ?></span>
                                    <span class="ep-views"><i class="fas fa-eye"></i> <?= $viewCount ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <p class="text-muted w-100 text-center py-5">Belum ada episode yang tersedia.</p>
            <?php endif ?>
        </div>

        <!-- 3. PAGINATION -->
        <div id="epPagination" class="ep-pagination-wrapper mt-5"></div>

        <!-- 4. NOT FOUND MESSAGE -->
        <div id="epNotFound" class="text-center py-5" style="display: none;">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <p class="text-muted">Episode tidak ditemukan...</p>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const WATCH_API_URL = "<?= rtrim(base_url(), '/') ?>/api/watchEpisodeAndIncrementView";

    document.addEventListener('DOMContentLoaded', function() {
        
        // ==========================================
        // 1. LOGIKA VIDEO PLAYER & VIEW COUNTER
        // ==========================================
        
        // KITA BUNGKUS DENGAN TRY-CATCH SUPER AMAN
        try {
            // Fungsi untuk menembak API View Counter
            const triggerViewCounter = (episodeId, sessionKey, playerInst) => {
                if (!sessionStorage.getItem(sessionKey)) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    fetch(WATCH_API_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ episodeId: episodeId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            sessionStorage.setItem(sessionKey, 'true');
                            console.log('Analytics: View recorded.');
                        } else if (data.status === 'limit_reached') {
                            if (playerInst) playerInst.pause(); 
                            Swal.fire({
                                icon: 'warning',
                                title: 'Batas Tontonan',
                                text: 'User Basic dibatasi 5 episode per hari. Upgrade ke PRO!',
                                confirmButtonColor: '#ac11e9'
                            }).then(() => {
                                if (!playerInst) window.location.href = "<?= url_to('dashboard') ?>"; 
                            });
                        }
                    })
                    .catch(err => console.error('Failed view count:', err));
                }
            };

            // CEK ELEMEN: Apakah halaman ini pakai Video.js atau IFrame?
            const videoElement = document.getElementById('video-player');
            const embedElement = document.getElementById('embed-wrapper');

            // KONDISI A: LOKAL (Video.js)
            if (videoElement && typeof videojs !== 'undefined') {
                const playerInstance = videojs(videoElement);
                const epId = videoElement.getAttribute('data-episode-id');
                if (epId) {
                    const sKey = `ep_${epId}_viewed_today`;
                    playerInstance.on('play', function() {
                        triggerViewCounter(epId, sKey, playerInstance);
                    });
                }
            } 
            // KONDISI B: EMBED (Iframe)
            else if (embedElement) {
                const epId = embedElement.getAttribute('data-episode-id');
                if (epId) {
                    const sKey = `ep_${epId}_viewed_today`;
                    // Catat view saat mouse masuk ke area video pertama kali
                    embedElement.addEventListener('mouseenter', function() {
                        triggerViewCounter(epId, sKey, null);
                    }, { once: true });
                }
            }

        } catch (error) {
            // Jika Video Player error, cetak di console, TAPI JANGAN HENTIKAN SCRIPT BAWAH!
            console.warn("Peringatan Video Player:", error);
        }


        // ==========================================
        // 2. LOGIKA DAFTAR EPISODE (SEARCH, SORT, PAGINATION)
        // ==========================================
        
        // Kita bungkus juga agar 100% aman
        try {
            const epSearch = document.getElementById('epSearchInput');
            const container = document.getElementById('episodeContainer');
            const skeleton = document.getElementById('epSearchSkeleton');
            const paginationBox = document.getElementById('epPagination');
            const noResult = document.getElementById('epNotFound');
            const btnNewest = document.getElementById('sortNewest');
            const btnOldest = document.getElementById('sortOldest');
            
            if (!container) return; // Jika tidak ada container episode, berhenti di sini

            const itemsPerPage = 12;
            let currentPage = 1;
            let searchTimeout;
            const items = Array.from(document.querySelectorAll('.episode-item'));

            function updateDisplay(withSkeleton = true) {
                if (withSkeleton) {
                    container.style.display = 'none';
                    if (skeleton) skeleton.style.display = 'grid';
                    if(paginationBox) paginationBox.style.opacity = '0.3';
                }

                const visibleItems = items.filter(item => item.getAttribute('data-search-match') !== 'false');
                const totalPages = Math.ceil(visibleItems.length / itemsPerPage);

                setTimeout(() => {
                    if (withSkeleton) {
                        if (skeleton) skeleton.style.display = 'none';
                        container.style.display = 'grid';
                        if(paginationBox) paginationBox.style.opacity = '1';
                    }

                    items.forEach(item => item.style.display = 'none');

                    const start = (currentPage - 1) * itemsPerPage;
                    const end = start + itemsPerPage;
                    const currentItems = visibleItems.slice(start, end);

                    currentItems.forEach(item => {
                        item.style.display = 'block';
                        if (withSkeleton) item.classList.add('fade-in-smooth');
                    });

                    renderPagination(totalPages);
                    if(noResult) noResult.style.display = (visibleItems.length === 0) ? 'block' : 'none';
                }, withSkeleton ? 400 : 0);
            }

            function performSort(isAscending) {
                items.sort((a, b) => {
                    const valA = parseInt(a.getAttribute('data-number'));
                    const valB = parseInt(b.getAttribute('data-number'));
                    return isAscending ? valA - valB : valB - valA;
                });
                items.forEach(el => container.appendChild(el));
                
                if(btnOldest) btnOldest.classList.toggle('active', isAscending);
                if(btnNewest) btnNewest.classList.toggle('active', !isAscending);
                
                currentPage = 1;
                updateDisplay(true);
            }

            function renderPagination(totalPages) {
                if(!paginationBox) return;
                paginationBox.innerHTML = '';
                if (totalPages <= 1) return;

                const createPill = (content, target, isDisabled, isActive = false) => {
                    const pill = document.createElement('div');
                    const isArrow = (typeof content === 'string' && content.includes('fas'));
                    pill.className = isArrow ? 'page-nav-pill' : `page-pill ${isActive ? 'active' : ''}`;
                    if (isDisabled) { pill.style.opacity = '0.2'; pill.style.pointerEvents = 'none'; }
                    pill.innerHTML = content;
                    pill.onclick = () => {
                        currentPage = target;
                        updateDisplay(true);
                        const section = document.querySelector('.episode-list-section');
                        if (section) window.scrollTo({ top: section.offsetTop - 100, behavior: 'smooth' });
                    };
                    return pill;
                };

                paginationBox.appendChild(createPill('<i class="fas fa-chevron-left"></i>', currentPage - 1, currentPage === 1));
                for (let i = 1; i <= totalPages; i++) {
                    paginationBox.appendChild(createPill(i, i, false, i === currentPage));
                }
                paginationBox.appendChild(createPill('<i class="fas fa-chevron-right"></i>', currentPage + 1, currentPage === totalPages));
            }

            if (epSearch) {
                epSearch.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();
                    clearTimeout(searchTimeout);
                    container.style.display = 'none';
                    if (skeleton) skeleton.style.display = 'grid';

                    searchTimeout = setTimeout(() => {
                        const isNumber = !isNaN(query) && query !== "";
                        items.forEach(item => {
                            const title = item.getAttribute('data-title');
                            const num = item.getAttribute('data-number');
                            let isMatch = (query === "") ? true : (isNumber ? (num === query) : title.includes(query));
                            item.setAttribute('data-search-match', isMatch);
                        });
                        currentPage = 1;
                        updateDisplay(true);
                    }, 500);
                });
            }

            if(btnNewest) btnNewest.addEventListener('click', () => performSort(false));
            if(btnOldest) btnOldest.addEventListener('click', () => performSort(true));

            performSort(false); 

        } catch (error) {
            console.error("Daftar Episode Init Error:", error);
        }

    });
</script>

<?= $this->endSection() ?>
