// const searchInput = document.getElementById('mysearch');
// const resultsDropdown = document.getElementById('search-results');
// const clearBtn = document.getElementById('clear-btn');

// document.addEventListener('DOMContentLoaded', function() {
//     searchInput.addEventListener('input', function() {
//         const query = searchInput.value.trim();

//         clearBtn.style.display = query.length > 0 ? 'block' : 'none';

//         if (query.length > 2) {
//             resultsDropdown.style.display = 'block';
//             resultsDropdown.innerHTML = '<div style="padding:20px; text-align:center; color:#888;">Mencari...</div>';

//             fetch(`/animes-home/searchAnimePage?query=${query}`)
//                 .then(response => response.json())
//                 .then(data => {
//                     resultsDropdown.innerHTML = ''; 

//                     if (data.length > 0) {
//                         data.forEach(anime => {
//                             const imgSrc = anime.Poster.startsWith('http') 
//                                 ? anime.Poster 
//                                 : `${BASE_URL}/assets/images/${anime.Poster}`;

//                             const type = anime.tipeAnime || 'Anime'; 
//                             const status = anime.status || 'Unknown';

//                             const animeRow = `
//                                 <a href='/anime/${anime.slug}' class="result-item">
//                                     <img src="${imgSrc}" alt="${anime.Judul}">
//                                     <div class="result-info">
//                                         <span class="res-title">${anime.Judul}</span>
//                                         <span class="res-meta">${type} • ${status}</span>
//                                     </div>
//                                 </a>
//                             `;
//                             resultsDropdown.innerHTML += animeRow;
//                         });
//                     } else {
//                         resultsDropdown.innerHTML = '<div style="padding:20px; text-align:center; color:#888;">Gak ada hasil, nih...</div>';
//                     }
//                 })
//                 .catch(error => console.error('Error:', error));
//         } else {
//             resultsDropdown.style.display = 'none';
//         }
//     });
// });

// function clearSearch() {
//     searchInput.value = '';
//     clearBtn.style.display = 'none';
//     resultsDropdown.style.display = 'none';
//     searchInput.focus();
// }

// // Tutup kalo klik di luar
// document.addEventListener('click', (e) => {
//     if (!e.target.closest('.search-wrapper')) {
//         resultsDropdown.style.display = 'none';
//     }
// });