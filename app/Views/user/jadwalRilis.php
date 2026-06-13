<?= $this->extend('animesLayout/pageLayout') ?>

<?= $this->section('content') ?>

<html>

<head>
    <title>
        Jadwal Rilis
    </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
    :root {
        --primary-neon: #bf5af2; /* Ungu Neon */
        --secondary-neon: #0a84ff; /* Biru Neon */
        --dark-bg: #121212;
        --card-bg: rgba(255, 255, 255, 0.05);
        --glass-border: rgba(255, 255, 255, 0.1);
    }

    body {
        background-color: var(--dark-bg);
        color: #efefef;
        font-family: 'Poppins', sans-serif;
        background: radial-gradient(circle at top right, #1a1a2e, #121212);
    }

    .container {
        width: 95%;
        max-width: 1400px;
        margin: 50px auto;
        padding: 40px;
        background: rgba(20, 20, 20, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }

    .header-jadwal {
        font-size: 2rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 40px;
        background: linear-gradient(to right, #fff, var(--primary-neon));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 1px;
    }

    /* Modern Tabs Layout */
    .tabs {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 40px;
        overflow-x: auto;
        padding-bottom: 10px;
        scrollbar-width: none; /* Hide scrollbar Firefox */
    }
    
    .tabs::-webkit-scrollbar { display: none; } /* Hide scrollbar Chrome/Safari */

    .tab {
        background: transparent;
        padding: 12px 25px;
        cursor: pointer;
        border: 1px solid var(--glass-border);
        color: #888;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .tab:hover {
        border-color: var(--primary-neon);
        color: #fff;
    }

    .tab.active {
        background: var(--primary-neon);
        color: #fff;
        border-color: var(--primary-neon);
        box-shadow: 0 0 20px rgba(191, 90, 242, 0.4);
    }

    /* Grid Layout */
    .content {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 25px;
    }

    /* Modern Card */
    .card {
        background: var(--card-bg);
        border: 1px solid var(--glass-border);
        border-radius: 18px;
        padding: 12px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        flex-direction: column;
    }

    .card:hover {
        transform: translateY(-10px);
        border-color: var(--primary-neon);
        box-shadow: 0 15px 30px rgba(0,0,0,0.4);
        background: rgba(255, 255, 255, 0.08);
    }

    .poster-wrapper {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 2/3;
    }

    .card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card .play-icon {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,0.4);
        opacity: 0;
        transition: 0.3s;
        font-size: 3rem;
    }

    .card:hover .play-icon {
        opacity: 1;
    }

    .info {
        padding: 15px 5px;
    }

    .title-link {
        font-size: 1.05rem;
        font-weight: 700;
        color: #fff;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .title-link:hover {
        color: var(--primary-neon);
    }

    .description {
        font-size: 0.85rem;
        color: #aaa;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-footer-info {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.8rem;
        color: #666;
    }

    .time-badge {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Loading Animation */
    .loading {
        text-align: center;
        padding: 50px;
        display: none;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid rgba(255,255,255,0.1);
        border-left-color: var(--primary-neon);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    /* ==========================================================
       RESPONSIVE MOBILE (KHUSUS HP)
       ========================================================== */
       @media (max-width: 768px) {
        .container { 
            padding: 20px 15px; 
            margin: 15px auto; 
            border-radius: 0; /* Full width look di HP */
            background: transparent;
            border: none;
            backdrop-filter: none;
        }
        
        .header-jadwal { font-size: 1.3rem; margin-bottom: 20px; }

        .tabs { justify-content: flex-start; padding-left: 10px; }
        .tab { padding: 8px 18px; font-size: 0.85rem; }

        .content { 
            grid-template-columns: repeat(2, 1fr); 
            gap: 12px; 
        }

        .card { border-radius: 15px; }
        
        /* Sembunyikan Deskripsi agar Grid tidak berantakan di HP */
        .description { display: none; }

        .info { padding: 10px; }
        .title-link { font-size: 0.85rem; margin-bottom: 6px; }
        
        .card-footer-info { font-size: 0.7rem; }

        /* Empty State */
        .empty-state { padding: 40px 10px !important; }
        .empty-state i { font-size: 2.5rem !important; }
    }
</style>
</head>

<body>
<div class="container">
    <div class="header-jadwal">
        Jadwal Rilis Anime Fall 2024
    </div>
    
    <div class="tabs">
        <?php foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $dayName): ?>
            <button class="tab <?= $dayName === 'Senin' ? 'active' : '' ?>" onclick="showContent('<?= $dayName ?>')"><?= $dayName ?></button>
        <?php endforeach; ?>
    </div>
    
    <div class="loading" id="loading">
        <div class="spinner"></div>
        <p style="margin-top: 15px; font-size: 14px; color: #888;">Mencari Jadwal...</p>
    </div>

    <?php
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    foreach ($days as $day): ?>
        <div class="content" id="<?= $day ?>" style="<?= $day === 'Senin' ? 'display:grid;' : 'display:none;' ?>">
            <?php if (isset($jadwal[$day])): ?>
                <?php foreach ($jadwal[$day] as $anime): ?>
                    <div class="card">
                        <div class="poster-wrapper">
                            <a href="<?= url_to('animeDetail', $anime['slug']) ?>">
                                <?php 
                                $imgSrc = (strpos($anime['Poster'], 'http') === 0) ? $anime['Poster'] : base_url('assets/images/' . $anime['Poster']);
                                ?>
                                <img src="<?= $imgSrc ?>" alt="<?= $anime['Judul'] ?>">
                                <div class="play-icon">
                                    <i class="fas fa-play"></i>
                                </div>
                            </a>
                        </div>
                        <div class="info">
                            <a class="title-link" href="<?= url_to('animeDetail', $anime['slug']) ?>">
                                <?= $anime['Judul'] ?>
                            </a>
                            <div class="description">
                                <?= strip_tags($anime['Desc']) ?>
                            </div>
                            <div class="card-footer-info">
                                <div class="time-badge">
                                    <i class="far fa-clock"></i> <?= $anime['Eps'] ?> Episodes
                                </div>
                                <div class="rating">
                                    <i class="fas fa-star" style="color: #ffcc00;"></i> 4.8
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state" style="grid-column: 1/-1; text-align: center; padding: 80px 20px; color: #555;">
                        <i class="fas fa-calendar-times" style="font-size: 4rem; margin-bottom: 20px; color: var(--primary-neon); opacity: 0.3; display: block;"></i>
                        <p style="font-weight: 600;">Opps! Tidak ada anime yang tayang hari ini.</p>
                    </div>
                <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function showContent(day) {
        // Handle Active Tab
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => tab.classList.remove('active'));
        event.target.classList.add('active');

        const contents = document.querySelectorAll('.content');
        const loading = document.getElementById('loading');
        
        // Hide all with fade effect logic
        contents.forEach(content => {
            content.style.display = 'none';
            content.style.opacity = '0';
        });

        loading.style.display = 'block';

        setTimeout(() => {
            loading.style.display = 'none';
            const activeContent = document.getElementById(day);
            activeContent.style.display = 'grid';
            
            // Simple Fade In
            setTimeout(() => {
                activeContent.style.transition = 'opacity 0.5s ease';
                activeContent.style.opacity = '1';
            }, 50);
        }, 600);
    }

    function showTooltip(event, title, description, episodes) {
        var tooltip = document.getElementById('tooltip');
        tooltip.innerHTML = '<strong>' + title + '</strong><hr>' + description + '<br><br><strong>' + episodes + '</strong>';
        tooltip.style.display = 'block';
        tooltip.style.left = event.pageX + 10 + 'px';
        tooltip.style.top = event.pageY + 10 + 'px';
    }

    function hideTooltip() {
        var tooltip = document.getElementById('tooltip');
        tooltip.style.display = 'none';
    }

    function toggleReadMore(button) {
        var shortDesc = button.previousElementSibling.previousElementSibling;
        var fullDesc = button.previousElementSibling;
        
        if (fullDesc.style.display === 'none') {
            shortDesc.style.display = 'none';
            fullDesc.style.display = 'inline';
            button.innerText = 'Read Less';
        } else {
            shortDesc.style.display = 'inline';
            fullDesc.style.display = 'none';
            button.innerText = 'Read More';
        }
    }
</script>
</body>

</html>

<?= $this->endSection() ?>