<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
*/

// testing
// $routes->get('/db-test', 'DatabaseTest::index');

// Api route
$routes->get('api/get-address-suggestions', 'GooglePlacesController::getAddressSuggestions');

// // homepage routes
// $routes->get('/', 'Home::index');

// // Restaurant routes
// $routes->get('/restaurants', 'Restaurants::index');
// $routes->get('/restaurant', 'Restaurant::index');

// // Order process routes
// $routes->get('/order', 'Order::index');
// $routes->get('/userinfo', 'UserInfo::index');
// $routes->get('/paymentselection', 'Payment::index');