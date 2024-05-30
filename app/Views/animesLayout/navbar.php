<script>
    const BASE_URL = "<?= base_url() ?>";
</script>
<div class="header">
    <div class="logo">
        <h1><a href="/animesHome">WOTAKUS</a></h1>
    </div>
    <div class="nav">
        <div class="search">
            <div class="icon"></div>
            <div class="input">
                <input type="text" id="mysearch" placeholder="Cari...">
            </div>
            <span class="clear" onclick="document.getElementById('mysearch').value = '';"></span>
        </div>
        <div class="nav-list">
            <ul>
                <li><a href="/recentAnime">Recent</a></li>
                <li><a href="/animesHome">Animes</a></li>
                <li><a href="#">On going Anime</a></li>
            </ul>
        </div>
    </div>
</div>