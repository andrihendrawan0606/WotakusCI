        function previewImg(imgId, inputId, btnId) {
            const fileInput = document.querySelector(`#${inputId}`);
            const imgPreview = document.querySelector(`#${imgId}`);
            const btnReset = document.querySelector(`#${btnId}`);

            const fileReader = new FileReader();
            fileReader.readAsDataURL(fileInput.files[0]);

            fileReader.onload = function (e) {
                imgPreview.src = e.target.result;
                btnReset.classList.remove('d-none');
            };
        }

        function previewImgPoster() {
            const filePoster = document.getElementById('Poster');
            const imgPreviewPoster = document.getElementById('img-preview-poster');
            const btnReset = document.getElementById('btn-reset-poster');
            
            const fileReader = new FileReader();
            fileReader.readAsDataURL(filePoster.files[0]);
            
            fileReader.onload = function(e) {
                imgPreviewPoster.src = e.target.result;
                btnReset.classList.remove('d-none');
            }
        }

        function resetImageBackgroundCover() {
            const imgPreview = document.querySelector('#img-preview');
            const inputFile = document.querySelector('#fileBackgroundCover');
            const btnReset = document.querySelector('#btn-reset-background-cover');
            const resetStatus = document.querySelector('#BackgroundCoverReset');

            imgPreview.src = '/assets/images/default.jpg';
            inputFile.value = '';
            btnReset.classList.add('d-none');
            resetStatus.value = '1';
        }

        function resetImagePoster() {
            const imgPreview = document.querySelector('#img-preview-poster');
            const inputFile = document.querySelector('#Poster');
            const btnReset = document.querySelector('#btn-reset-poster');
            const resetStatus = document.querySelector('#PosterReset');

            imgPreview.src = '/assets/images/default1.jpg';
            inputFile.value = '';
            btnReset.classList.add('d-none');
            resetStatus.value = '1';
        }
        function GambarPreview() {
            const GambarPreview = document.querySelector('#gambarPreview');
            const GambarPreviewLabel = document.querySelector('#custom-file-label-episode');
            const GambarPreviewPreview = document.querySelector('#img-preview-episode');

            GambarPreviewLabel.textContent = GambarPreview.files[0].name;

            const fileGambarPreview = new FileReader();
            fileGambarPreview.readAsDataURL(GambarPreview.files[0]);

            fileGambarPreview.onload = function (e) {
                GambarPreviewPreview.src = e.target.result;
            }
        }

        function GambarPreviewNews() {
            const GambarPreview = document.querySelector('#newsimg');
            const GambarPreviewLabel = document.querySelector('#newsimglabel');
            const GambarPreviewPreview = document.querySelector('#img-preview-news');

            GambarPreviewLabel.textContent = GambarPreview.files[0].name;

            const fileGambarPreview = new FileReader();
            fileGambarPreview.readAsDataURL(GambarPreview.files[0]);

            fileGambarPreview.onload = function (e) {
                GambarPreviewPreview.src = e.target.result;
            }
        }

        // function displayFileDetails() {
        //     var input = document.getElementById('video_path');
        //     if (input.files.length > 0) {
        //         var file = input.files[0];
        //         var fileName = file.name;
        //         document.getElementById('file-name').textContent = 'Selected file: ' + fileName;

        //         var videoPreview = document.getElementById('video-preview');
        //         var videoSource = document.getElementById('video-source');
                
        //         var reader = new FileReader();
        //         reader.onload = function(e) {
        //             videoSource.src = e.target.result;
        //             videoPreview.load();
        //             videoPreview.style.display = 'block';
        //         };
        //         reader.readAsDataURL(file);
        //     } else {
        //         document.getElementById('file-name').textContent = 'No file selected.';
        //         var videoPreview = document.getElementById('video-preview');
        //         videoPreview.style.display = 'none';
        //         videoPreview.pause();
        //         videoPreview.removeAttribute('src'); // Clear the video src
        //     }
        // }

        function GambarPreview() {
            const gambarPreview = document.querySelector('#gambarPreview');
            const imgPreview = document.querySelector('#img-preview-episode');
    
            const fileGambar = new FileReader();
            fileGambar.readAsDataURL(gambarPreview.files[0]);
    
            fileGambar.onload = function(e) {
                imgPreview.src = e.target.result;
            };
        }
    
        function displayFileDetails() {
            const videoPath = document.querySelector('#video_path');
            const videoPreview = document.querySelector('#video-preview');
            const videoSource = document.querySelector('#video-source');
    
            const file = videoPath.files[0];
            if (file) {
                const objectURL = URL.createObjectURL(file);
                videoSource.src = objectURL;
                videoPreview.style.display = 'block';
                videoPreview.load();
            } else {
                videoPreview.style.display = 'none';
            }
        }

        setTimeout(function() {
            var alert = document.getElementById('flash-alert');
            if (alert) {
                alert.style.transition = "opacity 0.5s ease-out"; // Tambahkan efek transisi
                alert.style.opacity = 0; // Mengubah opacity untuk animasi fade out
    
                // Hapus elemen setelah transisi selesai
                setTimeout(function() {
                    alert.remove();
                }, 500); // Durasi yang sama dengan transisi
            }
        }, 3000); // 3000 milidetik = 3 detik
    