   <!--    HEADER    -->
<script>
    const BASE_URL = "<?= base_url() ?>";
</script>
<meta name="csrf-token" content="<?= csrf_hash() ?>">
   <div class="header">
        <div class="logo">
            <h1><a href="<?= url_to('animesHome') ?>">Wotakus</a></h1>
        </div>
        <div class="nav">
            <!-- <diV class="search">
                <div class="icon"></div>
                <div class="input">
                    <input type="text" id="mysearch" placeholder="Cari...">
                </div>
                <span class="clear" onclick="document.getElementById('mysearch').value = '';"></sp>
            </diV> -->
            <div class="nav-list">
                <ul>
                <li class="<?= (current_url() == url_to('recentAnime')) ? 'active' : '' ?>" ><a href="<?= url_to('recentAnime'); ?>">Recent</a></li>
                <li class="<?= (current_url() == url_to('animesHome')) ? 'active' : '' ?>" ><a href="<?= url_to('animesHome'); ?>">Animes</a></li>
                <li class="<?= (current_url() == url_to('jadwalRilis')) ? 'active' : '' ?>"><a href="<?= url_to('jadwalRilis'); ?>">Jadwal Rilis</a></li>
                <li class="<?= (current_url() == url_to('genres')) ? 'active' : '' ?>" ><a href="<?= url_to('genres'); ?>">Genre</a></li>
                <li class="<?= (current_url() == url_to('news')) ? 'active' : '' ?>"><a href="<?= url_to('news'); ?>">News</a></li>
                </ul>
            </div>
        </div>
    </div>