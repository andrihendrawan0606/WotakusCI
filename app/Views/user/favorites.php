<?= $this->extend('animesLayout/pageLayout') ?>
<?= $this->section('content') ?>
<style>
.favorites-wrapper {
    width: 100% !important;
    max-width: 1450px; /* Gunakan lebar maksimal yang lega */
    margin: 0 auto;
    padding: 0 40px;
    display: block; /* Hindari flex pada level ini agar header & grid tidak berebutan ruang */
}

.fav-header .row {
    width: 100%;
    margin: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.fav-header h1 {
    white-space: nowrap; /* Mencegah tulisan Koleksi Favorit pecah jadi 2 baris */
    font-size: 26px;
}

/* Container Empty State */
.empty-fav-container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 50px 0;
}

.empty-fav-glass {
    text-align: center;
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 60px 40px;
    border-radius: 30px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
}

.empty-icon-glow {
    font-size: 4rem;
    color: rgba(255, 255, 255, 0.1);
    filter: drop-shadow(0 0 15px rgba(172, 17, 233, 0.3));
    animation: pulseHeart 2s infinite;
}

@keyframes pulseHeart {
    0% { transform: scale(1); opacity: 0.1; }
    50% { transform: scale(1.1); opacity: 0.3; }
    100% { transform: scale(1); opacity: 0.1; }
}

.empty-fav-glass h2 {
    letter-spacing: 1px;
    font-size: 24px;
}

.empty-fav-glass p {
    font-size: 14px;
    line-height: 1.6;
}

.glow-heart {
    filter: drop-shadow(0 0 10px rgba(255, 51, 0, 0.5));
}

/* Search Box Modern */
.fav-search-box {
    position: relative;
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 50px;
    padding: 10px 25px;
    width: 100%;
    max-width: 350px;
    transition: 0.3s;
}

.fav-search-box:focus-within {
    border-color: #ac11e9;
    box-shadow: 0 0 15px rgba(172, 17, 233, 0.3);
}

.fav-search-box i { color: #555; margin-right: 15px; }
.fav-search-box input {
    background: transparent;
    border: none;
    outline: none;
    color: #fff;
    width: 100%;
    font-size: 14px;
}

/* Empty State Styling */
.empty-icon-box {
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 3rem;
    color: #333;
}

.btn-browse-modern {
    display: inline-block;
    background: #ac11e9;
    color: #fff !important;
    padding: 12px 30px;
    border-radius: 15px;
    font-weight: 700;
    text-decoration: none !important;
    transition: 0.3s;
    box-shadow: 0 10px 20px rgba(172, 17, 233, 0.3);
}

.btn-browse-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(172, 17, 233, 0.5);
    filter: brightness(1.1);
}

/* Grid Anime Fav */
.img-box {
    display: grid;
    /* Gunakan minmax yang tetap (misal 200px) agar ukuran kartu konsisten */
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 30px;
    width: 100%;
    justify-content: start; /* Tetap di kiri jika hanya ada satu */
}

.anime-fav-item {
    width: 100%;
    max-width: 250px; /* Sesuaikan dengan selera lebar kartu Anda */
    animation: fadeIn 0.5s ease-out;
}
.btn-edit-mode, .btn-cancel-edit {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: #fff;
    padding: 8px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-hapus-massal {
    background: #ff3e3e;
    color: #fff;
    border: none;
    padding: 8px 25px;
    border-radius: 10px;
    font-weight: 700;
    margin-right: 10px;
    box-shadow: 0 4px 15px rgba(255, 62, 62, 0.3);
}

.edit-controls-group {
    display: flex;
    align-items: center;
    animation: fadeIn 0.3s;
}

.animeCard-wrapper {
    width: 100%;
    cursor: pointer;
    transition: transform 0.2s;
}

.animeCard-wrapper:hover:not(.selected) {
    transform: scale(1.00);
}

/* Saat mode edit, kursor tetap pointer tapi warna outline lebih dominan */
.edit-mode .animeCard-wrapper:hover {
    transform: none;
}

/* State: Mode Edit Aktif */
.edit-mode .animeCard-wrapper {
    cursor: pointer;
}

/* Outline Ungu Saat Dipilih */
.animeCard-wrapper.selected .poster-wrapper {
    outline: 4px solid #ac11e9;
    outline-offset: -4px;
    transform: scale(0.99);
    
}

/* Icon Checkmark */
.select-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #ac11e9;
    font-size: 1.5rem;
    z-index: 10;
    opacity: 0;
    transition: 0.2s;
    background: white;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.selected .select-overlay {
    opacity: 1;
}

/* Sembunyikan Link asli saat edit agar tidak pindah halaman */
.edit-mode .animeCard {
    pointer-events: none;
}

.gap-3 { gap: 1rem; }

.ep-pagination-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 12px;
  margin-top: 50px;
  margin-bottom: 50px;
  background: transparent !important; /* Paksa agar tidak ada warna latar */
  border: none !important;
  box-shadow: none !important;
  width: 100%;
  clear: both; /* Memastikan tidak ada float di sekitarnya */
}

/* Tombol Angka Halaman */
.page-pill, .page-nav-pill {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: #888;
  width: 42px; /* Ukuran kotak seragam */
  height: 42px;
  border-radius: 12px;
  display: flex; /* Gunakan flex untuk centering */
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
  font-size: 14px;
  font-weight: 700;
}

.page-pill:hover {
  color: #fff;
  border-color: var(--primary-neon);
  background: rgba(255, 255, 255, 0.08);
}

.page-pill.active {
  background: var(--primary-neon);
  color: #fff;
  border-color: var(--primary-neon);
  box-shadow: 0 0 20px rgba(172, 17, 233, 0.4);
}

/* Tombol Prev/Next (Icon) */
.page-nav-pill {
  background: rgba(255, 255, 255, 0.03);
  border: 1px solid rgba(255, 255, 255, 0.05);
  color: #666;
  padding: 0 15px;
  height: 40px;
  border-radius: 12px;
  cursor: pointer;
  transition: 0.3s;
  font-size: 12px;
  font-weight: 800;
  text-transform: uppercase;
}

.page-nav-pill i {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px; /* Perkecil ikon sedikit agar proporsional */
  pointer-events: none;
}

.page-pill:hover, .page-nav-pill:hover {
  color: #fff;
  border-color: var(--primary-neon);
  background: rgba(172, 17, 233, 0.1);
  transform: translateY(-2px);
}

.page-nav-pill:not(:disabled):hover {
  color: #fff;
  border-color: var(--primary-neon);
}

.page-nav-pill:disabled {
  opacity: 0.2;
  cursor: not-allowed;
  transform: none !important;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .favorites-wrapper { padding: 0 20px; }
    .img-box { grid-template-columns: repeat(2, 1fr); gap: 15px; }
    .fav-header { text-align: center; }
    .fav-search-box { margin-top: 20px; }
}
</style>

<div class="favorites-wrapper py-5" id="favWrapper">
    
    <?php if (empty($favorites)): ?>
        <!-- TAMPILAN JIKA KOSONG -->
        <div class="empty-fav-container">
            <div class="empty-fav-glass">
                <div class="empty-icon-glow">
                    <i class="fas fa-heart-broken"></i>
                </div>
                <h2 class="text-white font-weight-bold mt-4">Koleksi Masih Kosong</h2>
                <p class="text-muted">Sepertinya kamu belum menandai anime favoritmu.<br>Ayo jelajahi ribuan anime seru lainnya!</p>
                
                <div class="mt-4">
                    <a href="<?= url_to('animes-home') ?>" class="btn-browse-modern">
                        <i class="fas fa-search mr-2"></i> Mulai Menjelajah
                    </a>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- TAMPILAN JIKA ADA DATA (HEADER ASLI) -->
        <div class="fav-header mb-4">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <h1 class="font-weight-bold text-white m-0">
                        <i class="fas fa-heart text-danger"></i> Koleksi Favorit
                    </h1>
                </div>
                
                <div class="col-md-7 text-md-right d-flex justify-content-end align-items-center gap-3">
                    <button type="button" id="btnMainEdit" class="btn-edit-mode" onclick="enterEditMode()">
                        <i class="fas fa-edit"></i> Edit
                    </button>

                    <div id="editControls" class="edit-controls-group" style="display: none;">
                        <div class="custom-control custom-checkbox mr-4 select-all-wrapper">
                            <input type="checkbox" class="custom-control-input" id="selectAll" onclick="toggleSelectAll(this)">
                            <label class="custom-control-label text-white" for="selectAll">Pilih Semua</label>
                        </div>
                        <button type="button" class="btn-hapus-massal" onclick="deleteSelected()">Hapus</button>
                        <button type="button" class="btn-cancel-edit" onclick="exitEditMode()">Cancel</button>
                    </div>

                    <div id="favSearchWrapper" class="fav-search-box ml-3">
                        <i class="fas fa-search"></i>
                        <input type="text" id="favSearch" placeholder="Cari..." onkeyup="filterFav()">
                    </div>
                </div>
            </div>
        </div>

    <!-- Grid Container -->
    <form id="formDeleteBatch">
        <?= csrf_field() ?>
        <div class="img-box" id="favContainer">
            <?php foreach ($favorites as $anime) : ?>
                <div class="anime-fav-item" data-title="<?= strtolower($anime['Judul']) ?>">
                    <!-- TAMBAHKAN data-url DI SINI -->
                    <div class="animeCard-wrapper" 
                        data-id="<?= $anime['id'] ?>" 
                        data-url="<?= url_to('animeDetail', $anime['slug']) ?>" 
                        onclick="handleCardClick(this, event)">
                        
                        <div class="animeCard">
                            <div class="poster-wrapper">
                                <?php 
                                $imgSrc = (filter_var($anime['Poster'], FILTER_VALIDATE_URL)) ? $anime['Poster'] : base_url('assets/images/' . $anime['Poster']);
                                ?>
                                <img src="<?= $imgSrc ?>" class="poster">
                                
                                <div class="select-overlay">
                                    <i class="fas fa-check-circle"></i>
                                </div>

                                <div class="card-overlay">
                                    <div class="animeType"><?= $anime['tipeAnime'] ?? 'TV' ?></div>
                                </div>
                            </div>
                            <div class="anime-info">
                                <p class="anime-title"><?= esc($anime['Judul']) ?></p>
                            </div>
                        </div>
                        <input type="checkbox" name="anime_ids[]" value="<?= $anime['id'] ?>" class="hidden-check d-none">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </form>
    <!-- KONTEN PAGINASI (TAMBAHKAN INI) -->
    <div id="favPagination" class="ep-pagination-wrapper mt-5"></div>
<?php endif; ?>
</div>
<script>
// --- KONFIGURASI GLOBAL ---
const itemsPerPage = 12; // Batas tampil per halaman
let currentPage = 1;
let isEditMode = false;
let allItems = [];

document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi daftar item saat pertama kali load
    allItems = Array.from(document.querySelectorAll('.anime-fav-item'));
    renderFavorites(); // Jalankan fungsi render utama
});

// --- FUNGSI UTAMA RENDER (SEARCH + PAGINATION) ---
function renderFavorites() {
    const searchInput = document.getElementById('favSearch');
    const filter = searchInput.value.toLowerCase();
    const paginationBox = document.getElementById('favPagination');
    const noResult = document.getElementById('favNotFound');

    // 1. Filter items berdasarkan search input
    const filteredItems = allItems.filter(item => {
        const title = item.getAttribute('data-title');
        return title.includes(filter);
    });

    // 2. Hitung Total Halaman
    const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
    
    // 3. Reset tampilan: Sembunyikan semua item dahulu
    allItems.forEach(item => {
        item.style.display = "none";
        item.classList.remove('fade-in-smooth');
    });

    // 4. Ambil potongan data (slice) untuk halaman aktif
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedItems = filteredItems.slice(start, end);

    // 5. Tampilkan item yang masuk dalam range pagination
    paginatedItems.forEach(item => {
        item.style.display = "block";
        item.classList.add('fade-in-smooth');
    });

    // 6. Tampilkan pesan jika kosong
    if (noResult) {
        noResult.style.display = (filteredItems.length === 0) ? 'block' : 'none';
    }

    // 7. Render tombol navigasi halaman
    renderPaginationControls(totalPages);
}

// --- FUNGSI RENDER TOMBOL PAGINASI ---
function renderPaginationControls(totalPages) {
    const paginationBox = document.getElementById('favPagination');
    if (!paginationBox) return;

    paginationBox.innerHTML = '';
    if (totalPages <= 1) return; // Sembunyikan jika hanya 1 halaman

    // Helper membuat tombol
    const createPill = (content, target, isActive = false, isDisabled = false) => {
        const pill = document.createElement('div');
        const isArrow = (typeof content === 'string' && content.includes('fas'));
        pill.className = isArrow ? 'page-nav-pill' : `page-pill ${isActive ? 'active' : ''}`;
        
        if (isDisabled) {
            pill.style.opacity = '0.2';
            pill.style.pointerEvents = 'none';
        }

        pill.innerHTML = content;
        pill.onclick = (e) => {
            e.preventDefault();
            currentPage = target;
            renderFavorites();
            // Scroll otomatis ke atas daftar favorit
            window.scrollTo({
                top: document.getElementById('favWrapper').offsetTop - 100,
                behavior: 'smooth'
            });
        };
        return pill;
    };

    // Tombol Previous
    paginationBox.appendChild(createPill('<i class="fas fa-chevron-left"></i>', currentPage - 1, false, currentPage === 1));

    // Angka Halaman
    for (let i = 1; i <= totalPages; i++) {
        paginationBox.appendChild(createPill(i, i, i === currentPage));
    }

    // Tombol Next
    paginationBox.appendChild(createPill('<i class="fas fa-chevron-right"></i>', currentPage + 1, false, currentPage === totalPages));
}

// Trigger saat mengetik di pencarian
function filterFav() {
    currentPage = 1; // Reset ke halaman 1 setiap kali mencari
    renderFavorites();
}

// --- LOGIKA EDIT MODE ---
function enterEditMode() {
    isEditMode = true;
    document.getElementById('favWrapper').classList.add('edit-mode');
    document.getElementById('btnMainEdit').style.display = 'none';
    document.getElementById('favSearchWrapper').style.display = 'none';
    document.getElementById('editControls').style.display = 'flex';
    document.getElementById('favPagination').style.display = 'none'; // Sembunyikan paginasi saat edit
}

function exitEditMode() {
    isEditMode = false;
    document.getElementById('favWrapper').classList.remove('edit-mode');
    document.getElementById('btnMainEdit').style.display = 'block';
    document.getElementById('favSearchWrapper').style.display = 'flex';
    document.getElementById('editControls').style.display = 'none';
    document.getElementById('favPagination').style.display = 'flex';

    // Reset seleksi
    document.querySelectorAll('.animeCard-wrapper').forEach(el => {
        el.classList.remove('selected');
        el.querySelector('input').checked = false;
    });
    document.getElementById('selectAll').checked = false;
    renderFavorites();
}

// Menangani klik pada kartu
function handleCardClick(element, event) {
    if (!isEditMode) {
        const targetUrl = element.getAttribute('data-url');
        if (targetUrl) window.location.href = targetUrl;
        return;
    }
    
    event.preventDefault();
    const checkbox = element.querySelector('input[type="checkbox"]');
    element.classList.toggle('selected');
    checkbox.checked = !checkbox.checked;

    updateSelectAllStatus();
}

function updateSelectAllStatus() {
    const total = document.querySelectorAll('.animeCard-wrapper').length;
    const selected = document.querySelectorAll('.animeCard-wrapper.selected').length;
    document.getElementById('selectAll').checked = (total === selected && total > 0);
}

function toggleSelectAll(master) {
    const wrappers = document.querySelectorAll('.animeCard-wrapper');
    wrappers.forEach(el => {
        const checkbox = el.querySelector('input');
        if (master.checked) {
            el.classList.add('selected');
            checkbox.checked = true;
        } else {
            el.classList.remove('selected');
            checkbox.checked = false;
        }
    });
}

// Eksekusi Hapus Massal
function deleteSelected() {
    const checkedBoxes = document.querySelectorAll('input[name="anime_ids[]"]:checked');
    if (checkedBoxes.length === 0) {
        Swal.fire('Pilih Anime', 'Silakan pilih minimal satu anime untuk dihapus.', 'info');
        return;
    }

    Swal.fire({
        title: 'Hapus ' + checkedBoxes.length + ' Favorit?',
        text: "Anime yang dipilih akan dihapus dari koleksi Anda.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff3e3e',
        confirmButtonText: 'Ya, Hapus Semua',
        background: '#1a1a1a',
        color: '#fff'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData(document.getElementById('formDeleteBatch'));
            fetch('<?= base_url('api/deleteFavoriteBatch') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
                }
            });
        }
    });
}
</script>

<?= $this->endSection() ?>