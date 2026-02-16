<?php

use app\controllers\loginControlleur;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	$loginControlleur = new loginControlleur($app);
	$DashboardControlleur = new DashboardControlleur($app);

	$router->get('/',[$DashboardControlleur,'home']);

	// $router->get('/benefice',[$controller,'benefice']);
	// $router->get('/livraison',[$controller,'livraison']);
	// $router->get('/colis',[$controller,'colis']);
	// $router->get('/details',[$controller,'detailColis']);
	// $router->get('/create/colis',[$controller,'createColis']);
	// $router->post('/colis/save',[$controller,'saveColis']);
	// $router->get('/enAttente',[$controller,'enAttente']);
	// $router->get('/dejaAnnuler',[$controller,'dejaAnnuler']);
	// $router->get('/create/livraison',[$controller,'createLivraison']);
	// $router->get('/zone',[$controller,'zone']);
	// $router->get('/delete/zone',[$controller,'deleteZone']);
	// $router->post('/create/save/livraison',[$controller,'saveLivraison']);
	
	// $router->get('/livrer',[$controller,'livrer']);
	// $router->get('/annuler',[$controller,'annuler']);


}, [ SecurityHeadersMiddleware::class ]);