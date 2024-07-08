<?= $this->extend('user/pageLayoutInfo') ?>

<?= $this->section('Judul') ?>
<?= $title ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

    <!-- VIDEO -->
    <section class="video">
        <h1>Preview <?= $episode['judul'] ?></h1>
        <div class="video-container">
            <?php if ($episode['video_path']): ?>
            <video id="video-player" class="video-js vjs-default-skin" controls preload="auto" width="1000" height="420" poster="URL_THUMBNAIL" data-setup="{}" data-episode-id="<?= $episode['id'] ?>">
                <source src="<?= base_url('assets/videos/' . $episode['video_path']) ?>" type="video/mp4">
            </video>
            <?php else: ?>
                <h2 class="h2">Video tidak tersedia.</h2>
            <?php endif; ?>
        </div>
        <div class="ab">
            <ul>
                <?php if ($EpisodeSebelumnya): ?>
                <li>
                    <a href="<?= url_to('showPreviewVideo', $anime['slug'], $EpisodeSebelumnya['slug-episode']); ?>">
                        <img src="<?= base_url('assets/images/before-arrow.png'); ?>"> Episode Sebelumnya
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($EpisodeSelanjutnya): ?>
                <li>
                    <a href="<?= url_to('showPreviewVideo', $anime['slug'], $EpisodeSelanjutnya['slug-episode']); ?>">
                        Episode Selanjutnya <img src="<?= base_url('assets/images/next-arrow.png'); ?>">
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </section>

<!--    Episode    -->
<div class="episode">
    <h1><i class="fad fa-chevron-double-right"></i> EPISODE</h1>
    <div class="grid-episode">
        <?php if (isset($allEpisodes) && is_array($allEpisodes) && !empty($allEpisodes)) : ?>
            <?php foreach ($allEpisodes as $animeEpisode) : ?>
                <?php if ($animeEpisode['id'] == $episode['id']): ?>
                    <!-- Episode sedang ditonton -->
                    <div class="anime-section">
                        <div class="anime-img-current-episode" style="background-image: url(<?= base_url('assets/imgPreview/' . $animeEpisode['GambarPreview']); ?>);" ></div>
                        <div class="watching">
                            <h1>Sedang<br>ditonton</h1>
                            <img src="<?= base_url('assets/images/show.png'); ?>">
                        </div>
                        <div class="anime-description">
                            <h2><?= $anime['Judul'] ?> | <?= $animeEpisode['judul'] ?></h2>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Episode lainnya -->
                    <a href="<?= url_to('showPreviewVideo', $anime['slug'], $animeEpisode['slug-episode']); ?>" class="anime-section">
                        <div class="anime-img-1" style="background-image: url(<?= base_url('assets/imgPreview/' . $animeEpisode['GambarPreview']); ?>);" ></div>
                        <div class="anime-description">
                            <h2><?= $anime['Judul'] ?> | <?= $animeEpisode['judul'] ?></h2>
                        </div>
                    </a>
                <?php endif; ?>
            <?php endforeach ?>
        <?php else : ?>
            <p>Belum ada Episode yang tayang</p>
        <?php endif ?>
    </div>
</div>

<script>

// document.addEventListener('DOMContentLoaded', () => {
//     const video = document.getElementById('video-player');
//     const playPauseButton = document.getElementById('play-pause');
//     const skipBackButton = document.getElementById('skip-back');
//     const skipForwardButton = document.getElementById('skip-forward');
//     const progressBar = document.getElementById('progress-bar');
//     const volumeControl = document.getElementById('volume-control');
//     const muteUnmuteButton = document.getElementById('mute-unmute');
//     const fullscreenButton = document.getElementById('fullscreen');

//     playPauseButton.addEventListener('click', () => {
//         if (video.paused) {
//             video.play();
//             playPauseButton.textContent = 'Pause';
//         } else {
//             video.pause();
//             playPauseButton.textContent = 'Play';
//         }
//     });

//     skipBackButton.addEventListener('click', () => {
//         video.currentTime -= 5;
//     });

//     skipForwardButton.addEventListener('click', () => {
//         video.currentTime += 5;
//     });

//     video.addEventListener('timeupdate', () => {
//         const progress = (video.currentTime / video.duration) * 100;
//         progressBar.value = progress;
//     });

//     progressBar.addEventListener('input', () => {
//         const newTime = (progressBar.value / 100) * video.duration;
//         video.currentTime = newTime;
//     });

//     volumeControl.addEventListener('input', () => {
//         video.volume = volumeControl.value;
//     });

//     muteUnmuteButton.addEventListener('click', () => {
//         video.muted = !video.muted;
//         muteUnmuteButton.textContent = video.muted ? 'Unmute' : 'Mute';
//     });

//     fullscreenButton.addEventListener('click', () => {
//         if (!document.fullscreenElement) {
//             video.requestFullscreen().catch(err => {
//                 alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
//             });
//         } else {
//             document.exitFullscreen();
//         }
//     });

//     document.addEventListener('fullscreenchange', () => {
//         fullscreenButton.textContent = document.fullscreenElement ? 'Exit Fullscreen' : 'Fullscreen';
//     });
// });
document.addEventListener('DOMContentLoaded', (event) => {
    const videoPlayer = videojs('video-player');
    const episodeId = videoPlayer.el().getAttribute('data-episode-id');
    const sessionKey = `episode_${episodeId}_viewed`;

    videoPlayer.on('play', function() {
        if (!sessionStorage.getItem(sessionKey)) {
            sessionStorage.setItem(sessionKey, 'true');
            fetch('<?= base_url() ?>/anime/incrementView/' + episodeId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ episodeId: episodeId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('View count berhasil ditambah.');
                } else {
                    console.error('View count gagal ditambah', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});
</script>

<?= $this->endSection() ?>
