<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);
$routes->get('/', 'Home::index');
$routes->get('/testTambah', 'adminController::testTambah');
// $routes->get('/about', 'Page::about');
// $routes->get('/contact', 'Page::contact');
// $routes->get('/faqs', 'Page::faqs');
$routes->get('/animesHome', 'Page::animesHome', ['as' => 'animesHome']);
$routes->get('/animesHome/searchAnimePage', 'Page::searchAnimePage', ['as' => 'searchAnimePage']);
$routes->get('/animesHome/animeinfo/(:segment)/(:segment)', 'Page::AnimesDetail/$1/$2', ['as' => 'animeDetail']);
$routes->get('/recentAnime', 'Page::recent', ['as' => 'recentAnime']);
$routes->get('/animesHome/animeinfo/(:segment)', 'Page::showEpisodes/$1', ['as' => 'showEpisodes']);
$routes->get('/animesHome/animeinfo/PreviewVideo/(:segment)/(:any)', 'Page::showPreviewVideo/$1/$2', ['as' => 'showPreviewVideo']);
$routes->post('/animesHome/animeinfo/incrementView/(:num)', 'Page::incrementView/$1', ['as' => 'incrementView']);
$routes->get('/animesHome/animeinfo/(:segment)', 'Page::showGenre/$1', ['as' => 'showGenre']);
$routes->get('/dashboard', 'adminController::dashboard', ['as' => 'dashboard']);
$routes->get('/dashboard/searchAnime', 'adminController::searchAnime', ['as' => 'dashboardSearchAnime']);
$routes->get('/genreList', 'adminController::genreList', ['as' => 'genreList']);
$routes->get('/genreList/tambahGenre', 'adminController::genreTambah', ['as' => 'genreTambah']);
$routes->post('/genreList/tambahGenre/prosesGenre', 'adminController::genreProses', ['as' => 'prosesGenre']);
$routes->get('/genreList/deleteGenre/(:num)', 'adminController::deleteGenre/$1', ['as' => 'deleteGenre']);
$routes->get('/dashboard/detail/createEpisode/(:segment)/(:any)', 'adminController::createEpisode/$1/$2', ['as' => 'createEpisode']);
$routes->post('/dashboard/detail/prosesEpisode', 'adminController::prosesEpisode', ['as' => 'prosesEpisode']);
$routes->get('/dashboard/detail/(:any)/(:any)', 'adminController::Lihat/$1/$2', ['as' => 'viewDetail']);
$routes->get('/dashboard/delete/(:num)/(:any)', 'adminController::delete/$1/$2', ['as' => 'delete']);
$routes->get('/dashboard/HapusEpisode/(:num)/(:any)', 'adminController::deleteEpisode/$1/$2', ['as' => 'deleteEpisode']);
$routes->get('/dashboard/tampilTambah', 'adminController::tampilTambah', ['as' => 'tampilTambah']);
$routes->get('/dashboard/edit/(:segment)/(:any)', 'adminController::edit/$1/$2', ['as' => 'edit']);
$routes->post('/dashboard/edit/ProsesEdit/(:segment)', 'adminController::ProsesEdit/$1', ['as' => 'prosesEdit']);
$routes->post('/dashboard/prosesTambah', 'adminController::prosesTambah', ['as' => 'prosesTambah']);
$routes->post('/dashboard/create', 'adminController::create', ['as' => 'create']);
// $routes->get('/anime', 'page::index');
$routes->get('/anime/(:any)', 'page::viewAnimes/$1');
$routes->group('admin', function($routes){
	$routes->get('animes', 'animesAdmin::index');
	$routes->get('animes/(:segment)/preview', 'animesAdmin::preview/$1');
    $routes->add('animes/new', 'animesAdmin::create');
	$routes->add('animes/(:segment)/edit', 'animesAdmin::edit/$1');
	$routes->get('animes/(:segment)/delete', 'animesAdmin::delete/$1');
});
