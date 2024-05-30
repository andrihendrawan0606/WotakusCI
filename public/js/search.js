const icon = document.querySelector('.icon');
const search = document.querySelector('.search');
icon.onclick = function () {
    search.classList.toggle('active');
}

document.addEventListener('DOMContentLoaded', function() {
const searchInput = document.getElementById('mysearch');

searchInput.addEventListener('input', function() {
const query = searchInput.value.trim().toLowerCase();

if (query.length > 2) { // Minimal 3 Huruf buat search
    fetch(`/animesHome/searchAnimePage?query=${query}`)
        .then(response => response.json())
        .then(data => {
            const imgBox = document.querySelector('.img-box');
            imgBox.innerHTML = ''; // Clear current content Hapus susuan card anime sekarang

            if (data.length > 0) {
                data.forEach(anime => {
                    const slug = anime.Judul.toLowerCase().replace(/\s+/g, '-');
                    const animeCard = `
                        <a href='/animesHome/animeinfo/${anime.id}/${slug}' data-judul="${anime.Judul.toLowerCase()}" class="animeCard">
                            <img src="${BASE_URL}/assets/images/${anime.Poster}" alt="">
                            <p>${anime.Judul}</p>
                        </a>
                    `;
                    imgBox.innerHTML += animeCard;
                });
            } else {
                imgBox.innerHTML = '<p>Gak ada njir</p>';
            }
        })
        .catch(error => console.error('Error fetching data:', error));
} else {
    // Restore the original content if the query is less than 3 characters
    // Balikin susunan anime ke awal kalo kata kurang dari 3 
    fetch('/animesHome')
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const originalContent = doc.querySelector('.img-box').innerHTML;
            document.querySelector('.img-box').innerHTML = originalContent;
        })
        .catch(error => console.error('Error restoring content:', error));
}
});
});