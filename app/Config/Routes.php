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
$routes->get('/animesHome', 'Page::animesHome');
$routes->get('/animesHome/searchAnimePage', 'Page::searchAnimePage');
$routes->get('/animesHome/animeinfo/(:segment)/(:segment)', 'Page::AnimesDetail/$1/$2');
$routes->get('/recentAnime', 'Page::recent');
$routes->get('/animesHome/animeinfo/(:segment)', 'Page::showEpisodes/$1');
$routes->get('/animesHome/animeinfo/PreviewVideo/(:segment)/(:any)', 'Page::showPreviewVideo/$1/$2');
$routes->post('/animesHome/animeinfo/incrementView/(:num)', 'Page::incrementView/$1');
$routes->get('/animesHome/animeinfo/(:segment)', 'Page::showGenre/$1');
$routes->get('/dashboard', 'adminController::dashboard');
$routes->get('/dashboard/searchAnime', 'adminController::searchAnime');
$routes->get('/genreList', 'adminController::genreList');
$routes->get('/dashboard/detail/createEpisode/(:segment)/(:any)', 'adminController::createEpisode/$1/$2');
$routes->post('/dashboard/detail/prosesEpisode', 'adminController::prosesEpisode');
$routes->get('/dashboard/detail/(:any)/(:any)', 'adminController::Lihat/$1/$2');
$routes->get('/dashboard/delete/(:num)/(:any)', 'adminController::delete/$1/$2');
$routes->get('/dashboard/HapusEpisode/(:num)/(:any)', 'adminController::deleteEpisode/$1/$2');
$routes->get('/dashboard/tampilTambah', 'adminController::tampilTambah');
$routes->get('/dashboard/edit/(:segment)/(:any)', 'adminController::edit/$1/$2');
$routes->post('/dashboard/edit/ProsesEdit/(:segment)', 'adminController::ProsesEdit/$1');
$routes->post('/dashboard/prosesTambah', 'adminController::prosesTambah');
$routes->post('/dashboard/create', 'adminController::create');
// $routes->get('/anime', 'page::index');
$routes->get('/anime/(:any)', 'page::viewAnimes/$1');
$routes->group('admin', function($routes){
	$routes->get('animes', 'animesAdmin::index');
	$routes->get('animes/(:segment)/preview', 'animesAdmin::preview/$1');
    $routes->add('animes/new', 'animesAdmin::create');
	$routes->add('animes/(:segment)/edit', 'animesAdmin::edit/$1');
	$routes->get('animes/(:segment)/delete', 'animesAdmin::delete/$1');
});
