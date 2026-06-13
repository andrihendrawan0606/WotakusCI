<?= $this->extend('animesLayout/pageLayout') ?>
<?= $this->section('content') ?>

<script src="https://cdn.tailwindcss.com"></script>

<main class="content-grow min-h-screen pb-20 bg-[#0a0a0a]"> 
    <div class="max-w-[1500px] mx-auto px-4 py-8 text-white min-h-screen">
        
        <!-- MOBILE ACTION BAR -->
        <div class="lg:hidden flex flex-col gap-3 mb-8">
            <div class="flex items-center justify-between bg-[#141414] p-3 rounded-[24px] border border-white/5 shadow-2xl">
                <div class="flex items-center gap-3 ml-2">
                    <i class="fas fa-th-large text-purple-500"></i>
                    <span class="text-xs font-black uppercase italic tracking-tighter">Explore <span class="text-purple-500">Anime</span></span>
                </div>
                <button onclick="toggleMobileFilter()" class="w-10 h-10 flex items-center justify-center bg-purple-600 text-white rounded-xl shadow-lg shadow-purple-500/20">
                    <i class="fas fa-filter text-sm"></i>
                </button>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- SIDEBAR FILTER -->
            <aside id="sidebarFilter" class="hidden lg:block w-full lg:w-80 flex-shrink-0 lg:sticky lg:top-24 z-50">
                <div class="glass-sidebar rounded-[32px] p-8 shadow-2xl border border-white/5 relative overflow-hidden">
                    <!-- Glow effect decoration -->
                    <div class="absolute -top-10 -left-10 w-24 h-24 bg-purple-600/20 blur-3xl"></div>

                    <form id="advancedFilterForm">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-black uppercase italic tracking-tighter text-purple-500">Refine <span class="text-white">Search</span></h3>
                            <button type="button" onclick="toggleMobileFilter()" class="lg:hidden text-gray-500"><i class="fas fa-times"></i></button>
                        </div>

                        <!-- Search Input -->
                        <div class="mb-6">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-[2px] ml-1">Keyword</label>
                            <div class="relative mt-2">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 text-xs"></i>
                                <input type="text" name="q" placeholder="Judul anime..." class="w-full bg-white/[0.03] border border-white/10 rounded-2xl pl-11 pr-4 py-3.5 text-sm outline-none focus:border-purple-500 transition-all filter-input-focus">
                            </div>
                        </div>

                        <!-- Status & Season Row -->
                        <div class="grid grid-cols-1 gap-5 mb-6">
                            <div>
                                <label class="text-[10px] font-black text-gray-500 uppercase tracking-[2px] ml-1">Status</label>
                                <div class="relative">
                                    <select name="status" class="w-full mt-2 bg-white/[0.03] border border-white/10 rounded-2xl px-4 py-3.5 text-sm outline-none cursor-pointer appearance-none filter-input-focus">
                                        <option value="">Semua Status</option>
                                        <option value="On-Going">On-Going</option>
                                        <option value="Completed">Finished</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-4 top-[65%] -translate-y-1/2 text-gray-600 pointer-events-none text-[10px]"></i>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-500 uppercase tracking-[2px] ml-1">Release Season</label>
                                <div class="relative">
                                    <select name="season" class="w-full mt-2 bg-white/[0.03] border border-white/10 rounded-2xl px-4 py-3.5 text-sm outline-none cursor-pointer appearance-none filter-input-focus">
                                        <option value="">Semua Musim</option>
                                        <option value="winter">Winter</option>
                                        <option value="spring">Spring</option>
                                        <option value="summer">Summer</option>
                                        <option value="fall">Fall</option>
                                    </select>
                                    <i class="fas fa-calendar-alt absolute right-4 top-[65%] -translate-y-1/2 text-gray-600 pointer-events-none text-[10px]"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Studio Selection -->
                        <div class="mb-6">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-[2px] ml-1">Studio</label>
                            <div class="relative">
                                <select name="studio" class="w-full mt-2 bg-white/[0.03] border border-white/10 rounded-2xl px-4 py-3.5 text-sm outline-none cursor-pointer appearance-none filter-input-focus">
                                    <option value="">Semua Studio</option>
                                    <?php foreach($studios as $s): ?>
                                        <option value="<?= $s['id'] ?>"><?= $s['nama_studio'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <i class="fas fa-building absolute right-4 top-[65%] -translate-y-1/2 text-gray-600 pointer-events-none text-[10px]"></i>
                            </div>
                        </div>

                        <!-- Genre Grid -->
                        <div class="mb-8">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-[2px] ml-1">Genres</label>
                            <div class="grid grid-cols-2 gap-2 mt-3 max-h-56 overflow-y-auto pr-2 custom-scrollbar">
                                <?php foreach($genres as $g): ?>
                                    <label class="cursor-pointer group">
                                        <input type="checkbox" name="genres[]" value="<?= $g['id'] ?>" class="hidden peer">
                                        <div class="text-[10px] font-bold text-center py-2 border border-white/5 rounded-xl peer-checked:bg-purple-600 peer-checked:border-purple-400 peer-checked:text-white text-gray-500 bg-white/[0.02] transition-all hover:bg-white/[0.05]">
                                            <?= $g['genre'] ?>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 bg-purple-600 hover:bg-purple-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-purple-500/30 active:scale-95 transition-all">
                            <i class="fas fa-check-circle mr-2"></i> Apply Filters
                        </button>
                        
                        <!-- Reset Button AJAX -->
                        <button type="button" onclick="resetAllFilters()" class="w-full mt-4 text-[10px] font-black text-gray-600 hover:text-white uppercase tracking-[3px] transition-all">
                            <i class="fas fa-undo-alt mr-1"></i> Reset All
                        </button>
                    </form>
                </div>
            </aside>

            <!-- RESULTS -->
            <main class="flex-1 min-w-0">
                <div id="resultContainer" class="relative z-10">
                    <?= view('user/anime_grid') ?>
                </div>
            </main>
        </div>
    </div>
</main>



<script>
        // Toggle Filter Mobile
    function toggleMobileFilter() {
        const sidebar = document.getElementById('sidebarFilter');
        sidebar.classList.toggle('hidden');
        if(!sidebar.classList.contains('hidden')) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    const filterForm = document.getElementById('advancedFilterForm');
    const resultContainer = document.getElementById('resultContainer');

    // FUNGSI UTAMA FETCH DATA
    function fetchFilteredData(params = '') {
        // Efek loading
        resultContainer.style.opacity = '0.5';
        resultContainer.style.pointerEvents = 'none'; // Matikan klik saat loading

        const url = `<?= current_url() ?>${params ? '?' + params : ''}`;

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            resultContainer.innerHTML = html;
            resultContainer.style.opacity = '1';
            resultContainer.style.pointerEvents = 'auto'; // AKTIFKAN KEMBALI KLIK

            // Update URL browser tanpa reload
            window.history.pushState({}, '', url);

            // Scroll ke atas grid jika di mobile
            if (window.innerWidth < 1024) {
                window.scrollTo({
                    top: resultContainer.offsetTop - 120,
                    behavior: 'smooth'
                });
            }
        })
        .catch(err => {
            console.error(err);
            resultContainer.style.opacity = '1';
            resultContainer.style.pointerEvents = 'auto';
        });
    }

    // EVENT: Submit Form
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const searchParams = new URLSearchParams(formData).toString();
        fetchFilteredData(searchParams);
    });

    // EVENT: Reset All (Tanpa Reload Halaman)
    function resetAllFilters() {
        filterForm.reset(); // Kosongkan input teks & select
        
        // Uncheck semua genre checkbox secara manual
        const checkboxes = filterForm.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = false);

        // Ambil data awal kembali via AJAX
        fetchFilteredData('');
    }
</script>

<style>
    /* Fix untuk Dropdown Putih */
    select option {
        background-color: #1a1a1a !important; /* Warna gelap solid */
        color: white !important;
        padding: 10px;
    }

    
    /* Custom Scrollbar untuk list genre */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #3b3b3b; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #ac11e9; }

    /* Animasi Input */
    .filter-input-focus:focus {
        border-color: #ac11e9 !important;
        box-shadow: 0 0 15px rgba(172, 17, 233, 0.2);
        background: rgba(255, 255, 255, 0.08) !important;
    }

    /* Glassmorphism Effect */
    .glass-sidebar {
        background: linear-gradient(145deg, rgba(20, 20, 20, 0.9), rgba(10, 10, 10, 0.95));
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* Memaksa footer berada di paling bawah dan tidak melayang */
    .footer-modern {
        position: relative !important;
        z-index: 50; /* Pastikan di bawah dropdown profil tapi di atas background */
        margin-top: auto; /* Mendorong footer ke bawah jika konten sedikit */
        clear: both;
    }

    /* Fix agar Sidebar tidak menabrak footer saat discroll habis */
    @media (min-width: 1024px) {
        aside.sticky {
            max-height: calc(100vh - 120px);
            overflow-y: auto;
        }
    }

    /* Memastikan Pagination berada di atas background tapi di bawah footer */
    .ep-pagination-wrapper {
        position: relative;
        z-index: 10;
        margin-bottom: 40px; /* Beri jarak aman dari footer */
    }

    /* Animasi munculnya grid agar tidak kaku */
    #resultContainer {
        transition: opacity 0.3s ease;
        min-height: 500px;
    }
    @media (max-width: 1023px) {
        aside {
            position: relative !important; /* Matikan sticky di mobile */
            top: 0 !important;
        }
        
        /* Memberikan jarak agar grid tidak menempel ke sidebar */
        main {
            margin-top: 20px;
        }
    }
        /* 3 KOLOM GRID MOBILE */
    @media (max-width: 767px) {
        #resultContainer .grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 8px !important;
            padding: 0 4px;
        }
        /* Perkecil teks untuk 3 kolom */
        #resultContainer h4 {
            font-size: 10px !important;
            margin-top: 5px !important;
        }
    }


    /* Pastikan dropdown select tidak tertutup kartu anime */
    /* .glass-sidebar {
        z-index: 50;
        position: relative;
    } */

    /* Memperbaiki z-index kartu anime agar berada di bawah dropdown filter */
    .group {
        position: relative;
        z-index: 10;
    }
    #resultContainer {
        position: relative;
        z-index: 20; /* Lebih tinggi dari background, lebih rendah dari dropdown */
        pointer-events: auto !important; /* Paksa agar bisa diklik */
    }

    /* Pastikan link kartu memanjang penuh */
    .group.block {
        cursor: pointer;
        position: relative;
        z-index: 30;
    }
    .animeCard {
        pointer-events: auto !important;
    }
    @keyframes fadeInCustom {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    
    .animate-fade-in {
        animation: fadeInCustom 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
</style>

<?= $this->endSection() ?>