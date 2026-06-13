    <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-6">
        <?php if(!empty($animes)): ?>
            <?php foreach($animes as $anime): ?>
                <a href="<?= url_to('animeDetail', $anime['slug']) ?>" class="group block relative z-10 ">
                    <div class="relative aspect-[2/3] rounded-xl md:rounded-[17px] overflow-hidden shadow-xl border border-white/1 bg-[#1a1a1a]">
                        <?php $imgSrc = (filter_var($anime['Poster'], FILTER_VALIDATE_URL)) ? $anime['Poster'] : base_url('assets/images/' . $anime['Poster']); ?>
                        <img src="<?= $imgSrc ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        
                        <!-- Type Badge -->
                        <div class="absolute top-2 left-2 md:top-3 md:left-3 px-2 py-0.5 md:py-1 bg-black/70 backdrop-blur-md rounded-lg text-[8px] md:text-[10px] font-black uppercase text-white border border-white/10">
                            <?= $anime['tipeAnime'] ?>
                        </div>

                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>
                        
                        <!-- Rating Dinamis & Status -->
                        <div class="absolute bottom-2 left-2 right-2 md:bottom-4 md:left-4 md:right-4 flex justify-between items-end">
                            <div class="flex flex-col">
                                <span class="text-[7px] md:text-[10px] font-black text-purple-400 uppercase tracking-tighter"><?= $anime['status'] ?></span>
                            </div>
                            <div class="flex items-center gap-1 bg-black/40 px-1.5 py-0.5 rounded-md backdrop-blur-sm ">
                                <i class="fas fa-star text-yellow-500 text-[7px] md:text-[10px]"></i> 
                                <!-- GANTI DISINI AGAR DINAMIS -->
                                <span class="text-[8px] md:text-[11px] font-black text-white">
                                    <?= ($anime['rating_user'] > 0) ? number_format($anime['rating_user'], 1) : 'N/A' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <h4 class="mt-3 text-[11px] md:text-[14px] font-bold leading-tight text-gray-200 group-hover:text-purple-500 transition-colors line-clamp-1 md:line-clamp-2">
                        <?= $anime['Judul'] ?>
                    </h4>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
        <!-- ========================================== -->
        <!-- MODERN EMPTY STATE (Jika anime kosong) -->
        <!-- ========================================== -->
        <div class="col-span-full flex flex-col items-center justify-center py-24 px-6 text-center animate-fade-in">
            <div class="relative mb-8">
                <!-- Ikon utama dengan efek glow -->
                <div class="w-24 h-24 bg-purple-600/10 rounded-full flex items-center justify-center border border-purple-500/20 shadow-[0_0_50px_rgba(172,17,233,0.1)]">
                    <i class="fas fa-search-minus text-4xl text-purple-500"></i>
                </div>
                <!-- Ikon hantu kecil dekoratif -->
                <i class="fas fa-ghost absolute -top-2 -right-2 text-purple-400 text-xl animate-bounce"></i>
            </div>

            <h3 class="text-2xl font-black italic uppercase tracking-tighter text-white mb-3">
                Anime <span class="text-purple-500">Not Found</span>
            </h3>
            
            <p class="text-gray-500 max-w-sm mx-auto leading-relaxed text-sm mb-10">
                Maaf, kami tidak menemukan anime yang sesuai dengan kriteria filter Anda. Coba kurangi atau ubah pilihan filter Anda.
            </p>

            <button type="button" onclick="resetAllFilters()" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white/5 border border-white/10 hover:border-purple-500 hover:bg-purple-600/10 text-white rounded-2xl font-bold text-xs uppercase tracking-widest transition-all hover:-translate-y-1 active:scale-95">
                <i class="fas fa-sync-alt text-[10px]"></i> Clear All Filters
            </button>
        </div>
        <!-- ========================================== -->
    <?php endif; ?>
</div>
<!-- Pagination (Hanya tampil jika ada data) -->
<?php if(!empty($animes)): ?>
<div class="mt-10 flex justify-center scale-90 md:scale-100">
    <?= $pager->links('animes', 'anime_pagination') ?>
</div>
<?php endif; ?>