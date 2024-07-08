const video = document.querySelector(".video");
const toggleButton = document.querySelector(".toggleButton");
function togglePlay() {
  if (video.paused || video.ended) {
    video.play();
  } else {
    video.pause();
  }
}
function updateToggleButton() {
  toggleButton.innerHTML = video.paused ? "►" : "❚❚";
}
toggleButton.addEventListener("click", togglePlay);
video.addEventListener("click", togglePlay);
video.addEventListener("play", updateToggleButton);
video.addEventListener("pause", updateToggleButton);



















// document.addEventListener('DOMContentLoaded', (event) => {
//     const video = document.getElementById('video-player');
//     const playPauseButton = document.getElementById('play-pause');
//     const skipBackButton = document.getElementById('skip-back');
//     const skipForwardButton = document.getElementById('skip-forward');
//     const progressBar = document.getElementById('progress-bar');
//     const volumeControl = document.getElementById('volume-control');
//     const muteUnmuteButton = document.getElementById('mute-unmute');
//     const resolutionSelect = document.getElementById('resolution');

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

//     resolutionSelect.addEventListener('change', () => {
//         const currentTime = video.currentTime;
//         const selectedResolution = resolutionSelect.value;
//         const videoSrc = `path/to/video_${selectedResolution}.mp4`; // Update this path accordingly
//         video.src = videoSrc;
//         video.currentTime = currentTime;
//         video.play();
//     });
// });