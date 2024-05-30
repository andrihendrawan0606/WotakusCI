document.addEventListener('DOMContentLoaded', (event) => {
    const videoPlayer = document.getElementById('video-player');
    const episodeId = document.getElementById('video-player').dataset.episodeId;
    const sessionKey = `episode_${episodeId}_viewed`;

    videoPlayer.addEventListener('play', function() {
        if (!sessionStorage.getItem(sessionKey)) {
            sessionStorage.setItem(sessionKey, 'true');
            fetch(BASE_URL + '/animesHome/animeinfo/incrementView/' + episodeId, {
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
                    console.log('View count updated successfully.');
                } else {
                    console.error('Failed to update view count:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});