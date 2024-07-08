<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);
$routes->get('/', 'Home::index');
$routes->set404Override(function () {
    echo view('errors/html/404_custom');
});


$routes->group('auth', function($routes) {
    $routes->get('login', 'AuthController::login', ['as' => 'login']);
    $routes->post('attemptLogin', 'AuthController::attemptLogin', ['as' => 'prosesLogin']);
    $routes->get('logout', 'AuthController::logout');
});

$routes->group('dashboard', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'adminController::dashboard', ['as' => 'dashboard']);
    $routes->get('profile', 'DashboardController::profile');
    $routes->get('searchAnime', 'adminController::searchAnime', ['as' => 'dashboardSearchAnime']);
    $routes->get('detail/(:segment)', 'AdminController::Lihat/$1', ['as' => 'viewDetail']);
    $routes->get('fetchEpisodes/(:num)', 'AdminController::fetchEpisodes/$1');
    $routes->post('delete/(:any)', 'adminController::delete/$1', ['as' => 'delete']);
    $routes->get('HapusEpisode/(:any)', 'adminController::deleteEpisode/$1', ['as' => 'deleteEpisode']);
    $routes->get('tampilTambah', 'adminController::tampilTambah', ['as' => 'tampilTambah']);
    $routes->get('edit/(:segment)', 'adminController::edit/$1/$2', ['as' => 'edit']);
    $routes->post('edit/ProsesEdit/(:segment)', 'adminController::ProsesEdit/$1', ['as' => 'prosesEdit']);
    $routes->post('prosesTambah', 'adminController::prosesTambah', ['as' => 'prosesTambah']);
    $routes->group('detail', function($routes) {
        $routes->get('createEpisode/(:segment)', 'adminController::createEpisode/$1/$2', ['as' => 'createEpisode']);
        $routes->post('prosesEpisode', 'adminController::prosesEpisode', ['as' => 'prosesEpisode']);
        $routes->post('updateEpisode', 'adminController::updateEpisode', ['as' => 'updateEpisode']);
    });
});

$routes->group('genreList', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'adminController::genreList', ['as' => 'genreList']);
    $routes->get('tambahGenre', 'adminController::genreTambah', ['as' => 'genreTambah']);
    $routes->post('tambahGenre/prosesGenre', 'adminController::genreProses', ['as' => 'prosesGenre']);
    $routes->post('editGenre/updateGenre/(:any)', 'AdminController::updateGenre/$1', ['as' => 'updateGenre']);
    $routes->post('deleteGenre/(:any)', 'adminController::deleteGenre/$1', ['as' => 'deleteGenre']);
});

$routes->group('', function($routes) {
    $routes->get('animesHome', 'Page::animesHome', ['as' => 'animesHome']);
    $routes->get('animesHome/searchAnimePage', 'Page::searchAnimePage', ['as' => 'searchAnimePage']);
    $routes->get('anime/(:segment)', 'Page::AnimesDetail/$1', ['as' => 'animeDetail']);
    $routes->get('recentAnime', 'Page::recent', ['as' => 'recentAnime']);
    $routes->get('Genre', 'Page::genres', ['as' => 'genres']);
    $routes->get('News', 'Page::news', ['as' => 'news']);
    $routes->get('News/(:segment)', 'Page::newsDetail/$1', ['as' => 'newsDetail']);
    $routes->get('jadwalRilis/', 'Page::animesByGenre/$1/$2', ['as' => 'jadwalRilis']);
    $routes->get('Genre/(:segment)', 'Page::animesByGenre/$1/$2', ['as' => 'animesbyGenre']);
    $routes->get('anime/(:segment)', 'Page::showEpisodes/$1', ['as' => 'showEpisodes']);
    $routes->get('anime/(:segment)/(:segment)', 'Page::showPreviewVideo/$1/$2/$3', ['as' => 'showPreviewVideo']);
    $routes->post('anime/incrementView/(:num)', 'Page::incrementView/$1', ['as' => 'incrementView']);
    $routes->get('anime(:segment)', 'Page::showGenre/$1', ['as' => 'showGenre']);
});

$routes->group('newsList', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'adminController::NewsList', ['as' => 'NewsList']);
    $routes->get('tambahNews', 'adminController::TambahNews', ['as' => 'TambahNews']);
    $routes->post('tambahNews/saveNews', 'adminController::SaveNews', ['as' => 'SaveNews']);
});

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
