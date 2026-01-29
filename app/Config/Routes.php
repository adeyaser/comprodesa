<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('dbcheck', 'DbCheck2::index');
$routes->get('sitemap.xml', 'PortalController::sitemap');

$routes->get('probe', 'ProbeScrape::index');
$routes->get('news', 'PortalController::news');
$routes->get('news/(:segment)', 'PortalController::newsDetail/$1');
$routes->get('cron/scrape', 'Admin\Scraper::runAutoScrape');
$routes->get('tourism', 'PortalController::tourism');
$routes->get('tourism/(:segment)', 'PortalController::tourismDetail/$1');
$routes->get('profile', 'PortalController::profile');
$routes->get('services', 'PortalController::services');

// Auth Routes
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');

// Admin Routes
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('config', 'Admin\Config::index');
    $routes->post('config/update', 'Admin\Config::update');
    
    // News Routes
    $routes->get('news', 'Admin\News::index');
    $routes->get('news/create', 'Admin\News::create');
    $routes->post('news/store', 'Admin\News::store');
    $routes->get('news/edit/(:num)', 'Admin\News::edit/$1');
    $routes->post('news/update/(:num)', 'Admin\News::update/$1');
    $routes->get('news/delete/(:num)', 'Admin\News::delete/$1');

    // Tourism Routes
    $routes->get('tourism', 'Admin\Tourism::index');
    $routes->get('tourism/create', 'Admin\Tourism::create');
    $routes->post('tourism/store', 'Admin\Tourism::store');
    $routes->get('tourism/edit/(:num)', 'Admin\Tourism::edit/$1');
    $routes->post('tourism/update/(:num)', 'Admin\Tourism::update/$1');
    $routes->get('tourism/delete/(:num)', 'Admin\Tourism::delete/$1');
    $routes->post('tourism/gallery/upload/(:num)', 'Admin\Tourism::uploadGallery/$1');
    $routes->get('tourism/gallery/delete/(:num)', 'Admin\Tourism::deleteGallery/$1');

    // Services Routes
    $routes->get('services', 'Admin\Services::index');
    $routes->post('services/store', 'Admin\Services::store');
    $routes->post('services/update/(:num)', 'Admin\Services::update/$1');
    $routes->get('services/delete/(:num)', 'Admin\Services::delete/$1');

    // Scraper Routes
    $routes->get('scraper', 'Admin\Scraper::index');
    $routes->post('scraper/create', 'Admin\Scraper::create');
    $routes->get('scraper/delete/(:num)', 'Admin\Scraper::delete/$1');
    $routes->get('scraper/toggle/(:num)', 'Admin\Scraper::toggle/$1');
    $routes->get('scraper/refresh', 'Admin\Scraper::refresh');
});
