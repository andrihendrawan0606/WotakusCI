<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);
$routes->get('/', 'Home::index');
// $routes->set404Override(function () {
//     echo view('errors/html/404_custom');
// });
$routes->get('/auth/checkSession', 'AuthController::checkSession');

$routes->group('auth', function ($routes) {
    $routes->get('login', 'AuthController::login', ['as' => 'login']);
    $routes->post('attemptLogin', 'AuthController::attemptLogin', ['as' => 'prosesLogin']);
    $routes->get('logout', 'AuthController::logout', ['as' => 'logout']); // Pastikan rute logout
    $routes->get('register', 'AuthController::register', ['as' => 'register']);
    $routes->post('attemptRegister', 'AuthController::attemptRegister', ['as' => 'prosesRegister']);
});

$routes->group('dashboard', ['filter' => 'adminCheck'], function($routes) {
    $routes->get('/', 'adminController::dashboard', ['as' => 'dashboard']);
    $routes->get('admin/chartData', 'adminController::chartDataAjax');
    $routes->get('profile', 'DashboardController::profile');
    $routes->get('searchAnime', 'adminController::search', ['as' => 'dashboardSearchAnime']);
    $routes->get('detail/(:segment)', 'adminController::lihat/$1', ['as' => 'viewDetail']);
    $routes->get('fetchEpisodes/(:num)', 'adminController::fetchEpisodes/$1');
    $routes->post('delete/(:any)', 'adminController::delete/$1', ['as' => 'delete']);
    $routes->get('HapusEpisode/(:any)', 'adminController::deleteEpisode/$1', ['as' => 'deleteEpisode']);
    $routes->delete('delete-all-episodes/(:num)', 'adminController::deleteAllEpisodes/$1', ['as' => 'deleteAllEpisodes']);
    $routes->get('tampilTambah', 'adminController::tampilTambah', ['as' => 'tampilTambah']);
    $routes->get('edit/(:segment)', 'adminController::edit/$1/$2', ['as' => 'edit']);
    $routes->post('edit/ProsesEdit/(:segment)', 'adminController::ProsesEdit/$1', ['as' => 'prosesEdit']);
    $routes->post('prosesTambah', 'adminController::prosesTambah', ['as' => 'prosesTambah']);
    $routes->get('checkDuplicateTitle', 'adminController::checkDuplicateTitle',['as' => 'checkDuplicateTitle']);
    $routes->get('checkDuplicateMalId', 'adminController::checkDuplicateMalId',['as' => 'checkDuplicateMalId']);
    $routes->get('Logs','adminController::adminLogsPage',['as' => 'Logs']);
    $routes->get('downloadLogsPdf', 'adminController::downloadLogsPdf', ['as' => 'downloadLogsPdf']);
    $routes->post('purgeOldLogs', 'adminController::purgeOldLogs', ['as' => 'purgeOldLogs']);
    $routes->get('JadwalRilis','adminController::jadwalRilis',['as' => 'JadwalRilis']);
    $routes->post('saveJadwalRilis', 'adminController::saveJadwalRilis', ['as' => 'saveJadwalRilis']);
    $routes->post('HapusAnimeJadwal/(:num)', 'adminController::deleteAnimeJadwal/$1',['as' => 'deleteAnimeJadwal']);
    $routes->get('profileAdmin', 'adminController::profileAdmin', ['as' => 'profileAdmin']);
    $routes->get('fetchAnimeData/(:any)/(:num)', 'adminController::fetchAnimeData/$1/$2');

    $routes->post('studios/update/(:num)', 'StudioController::update/$1', ['as' => 'updateStudio']);
    $routes->post('studios/delete/(:num)', 'StudioController::delete/$1', ['as' => 'deleteStudio']);
    $routes->get('studios/', 'StudioController::index', ['as' => 'Studios']);
    $routes->get('studios/fetchGlobal/(:num)', 'StudioController::fetchGlobalStudios/$1', ['as' => 'syncGlobalStudio']);

    // --- Routes Baru: User Management ---

    $routes->get('users', 'adminController::manajemenUsers', ['as' => 'manageUsers']);
    $routes->get('users/tambah', 'adminController::tampilTambahUserAdmin', ['as' => 'tampilTambahUser']);
    $routes->post('users/prosesTambah', 'adminController::prosesTambahUserAdmin', ['as' => 'prosesTambahUser']);
    $routes->get('users/edit/(:any)', 'adminController::tampilEditUserAdmin/$1', ['as' => 'editUser']);
    $routes->post('users/update/(:any)', 'adminController::prosesEditUserAdmin/$1', ['as' => 'prosesEditUser']);
    $routes->post('users/delete/(:any)', 'adminController::hapusUserAdmin/$1', ['as' => 'hapusUser']);

    $routes->group('detail', function($routes) {
        $routes->get('createEpisode/(:segment)', 'adminController::createEpisode/$1/$2', ['as' => 'createEpisode']);
        $routes->post('prosesEpisode', 'adminController::prosesEpisode', ['as' => 'prosesEpisode']);
        $routes->post('updateEpisode', 'adminController::updateEpisode', ['as' => 'updateEpisode']);
        $routes->post('uploadTempVideo', 'adminController::uploadTempVideo', ['as' => 'uploadTempVideo']);
        $routes->post('deleteTempVideo', 'adminController::deleteTempVideo', ['as' => 'deleteTempVideo']);
    });
});

$routes->group('genreList', ['filter' => 'adminCheck'], function($routes) {
    $routes->get('/', 'adminController::genreList', ['as' => 'genreList']);
    $routes->get('tambahGenre', 'adminController::genreTambah', ['as' => 'genreTambah']);
    $routes->post('tambahGenre/prosesGenre', 'adminController::genreProses', ['as' => 'prosesGenre']);
    $routes->post('editGenre/updateGenre/(:any)', 'AdminController::updateGenre/$1', ['as' => 'updateGenre']);
    $routes->post('deleteGenre/(:any)', 'adminController::deleteGenre/$1', ['as' => 'deleteGenre']);
});

// $routes->group('', function($routes) {
//     $routes->get('animesHome', 'Page::animesHome', ['as' => 'animesHome']);
//     $routes->get('animesHome/searchAnimePage', 'Page::searchAnimePage', ['as' => 'searchAnimePage']);
//     $routes->get('anime/(:segment)', 'Page::AnimesDetail/$1', ['as' => 'animeDetail']);
//     $routes->get('recentAnime', 'Page::recent', ['as' => 'recentAnime']);
//     $routes->get('genre', 'Page::genres', ['as' => 'genres']);
//     $routes->get('news', 'Page::news', ['as' => 'news']);
//     $routes->get('news/(:segment)', 'Page::newsDetail/$1', ['as' => 'newsDetail']);
//     $routes->get('jadwalRilis/', 'Page::animesByGenre/$1/$2', ['as' => 'jadwalRilis']);
//     $routes->get('genre/(:segment)', 'Page::animesByGenre/$1/$2', ['as' => 'animesbyGenre']);
//     $routes->get('anime/(:segment)', 'Page::showEpisodes/$1', ['as' => 'showEpisodes']);
//     $routes->get('anime/(:segment)/(:segment)', 'Page::showPreviewVideo/$1/$2/$3', ['as' => 'showPreviewVideo']);
//     $routes->post('anime/incrementView/(:num)', 'Page::incrementView/$1', ['as' => 'incrementView']);
//     $routes->get('anime(:segment)', 'Page::showGenre/$1', ['as' => 'showGenre']);
// });

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('anime/(:segment)/(:segment)', 'Page::showPreviewVideo/$1/$2', ['as' => 'showPreviewVideo']);
});
$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes) {
    $routes->post('watchEpisodeAndIncrementView', 'EpisodeApiController::watchEpisodeAndIncrementView');
    $routes->get('checkWatchLimit', 'EpisodeApiController::checkWatchLimit');
});


$routes->group('', function($routes) {
    // $routes->get('/fetch-anime-data', 'Page::fetchAnimeData');
    $routes->get('/getProgress', 'Page::getProgress');
    $routes->get('animes/updateMalId/(:num)', 'Page::updateMalId/$1');
    $routes->get('animes/updateAnimeDetails/(:num)', 'Page::updateAnimeDetails/$1');
    $routes->get('animes-home', 'Page::animesHome', ['as' => 'animes-home']);
    $routes->get('animes-home/searchAnimePage', 'Page::searchAnimePage', ['as' => 'searchAnimePage']);
    $routes->get('anime/(:segment)', 'Page::AnimesDetail/$1', ['as' => 'animeDetail']);
    $routes->get('recent-anime', 'Page::recent', ['as' => 'recent-anime']);
    $routes->get('genre', 'Page::genres', ['as' => 'genres']);
    $routes->get('news', 'Page::news', ['as' => 'news']);
    $routes->get('news/(:segment)', 'Page::newsDetail/$1', ['as' => 'newsDetail']);
    $routes->get('jadwal-rilis/', 'Page::jadwalRilis', ['as' => 'jadwal-rilis']);
    $routes->get('genre/(:segment)', 'Page::animesByGenre/$1/$2', ['as' => 'animesbyGenre']);
    $routes->get('anime/(:segment)', 'Page::showEpisodes/$1', ['as' => 'showEpisodes']);
    // $routes->post('anime/trackUserWatch/(:num)', 'Page::trackUserWatch/$1', ['as' => 'trackUserWatch']);
    $routes->post('anime/incrementView/(:num)', 'Page::incrementView/$1', ['as' => 'incrementView']);
    $routes->get('anime(:segment)', 'Page::showGenre/$1', ['as' => 'showGenre']);
    $routes->get('profileUser', 'Page::profileUser', ['as' => 'profileUser']);
    $routes->post('profileUser/update', 'Page::updateProfileUser', ['as' => 'updateProfileUser']);
    $routes->get('my-favorites', 'Page::myFavorites', ['as' => 'myFavorites']);
    $routes->group('api', function($routes) {
        $routes->post('toggleFavorite', 'Page::toggleFavorite', ['as' => 'api-toggle-favorite']);
        $routes->post('saveRating', 'Page::saveRating'); // Pastikan 'Page' adalah nama Controller tempat Anda menaruh fungsi saveRating
    });
    $routes->post('api/deleteRating', 'Page::deleteRating');
    $routes->post('api/deleteFavoriteBatch', 'Page::deleteFavoriteBatch');

    $routes->get('/api/ai-search', 'Page::aiSearch');
});

$routes->group('newsList', ['filter' => 'adminCheck'], function($routes) {
    $routes->get('/', 'adminController::NewsList', ['as' => 'NewsList']);
    $routes->get('tambahNews', 'adminController::TambahNews', ['as' => 'TambahNews']);
    $routes->post('tambahNews/saveNews', 'adminController::SaveNews', ['as' => 'SaveNews']);
});

$routes->group('api', function($routes) {
    $routes->get('anime', 'AnimeApiController::index');         
    $routes->get('anime/(:num)', 'AnimeApiController::show/$1');
    $routes->post('anime', 'AnimeApiController::create');
    $routes->put('anime/(:num)', 'AnimeApiController::update/$1');
    $routes->delete('anime/(:num)', 'AnimeApiController::delete/$1');
});

// $routes->resource('anime-api');

// $routes->post('/dashboard/create', 'adminController::create', ['as' => 'create']);
// $routes->get('/anime', 'page::index');
// $routes->get('/anime/(:any)', 'page::viewAnimes/$1');
// $routes->group('admin', function($routes){
// 	$routes->get('animes', 'animesAdmin::index');
// 	$routes->get('animes/(:segment)/preview', 'animesAdmin::preview/$1');
//     $routes->add('animes/new', 'animesAdmin::create');
// 	$routes->add('animes/(:segment)/edit', 'animesAdmin::edit/$1');
// 	$routes->get('animes/(:segment)/delete', 'animesAdmin::delete/$1');
// });
