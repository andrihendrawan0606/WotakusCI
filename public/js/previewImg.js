        function previewImg() {
            const file = document.querySelector('#fileBackgroundCover').files[0];
            const preview = document.querySelector('#img-preview');
            const reader = new FileReader();
    
            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);
    
            if (file) {
                reader.readAsDataURL(file);
            }
        }
    
        function previewImgPoster() {
            const file = document.querySelector('#Poster').files[0];
            const preview = document.querySelector('#img-preview-poster');
            const reader = new FileReader();
    
            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);
    
            if (file) {
                reader.readAsDataURL(file);
            }
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

        function displayFileDetails() {
            var input = document.getElementById('video_path');
            if (input.files.length > 0) {
                var file = input.files[0];
                var fileName = file.name;
                document.getElementById('file-name').textContent = 'Selected file: ' + fileName;

                var videoPreview = document.getElementById('video-preview');
                var videoSource = document.getElementById('video-source');
                
                var reader = new FileReader();
                reader.onload = function(e) {
                    videoSource.src = e.target.result;
                    videoPreview.load();
                    videoPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('file-name').textContent = 'No file selected.';
                var videoPreview = document.getElementById('video-preview');
                videoPreview.style.display = 'none';
                videoPreview.pause();
                videoPreview.removeAttribute('src'); // Clear the video src
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
    