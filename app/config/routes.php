<?php

use app\controllers\DashboardControlleur;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	$DashboardControlleur = new DashboardControlleur($app);

	$router->get('/',[$DashboardControlleur,'dashboard']);
	$router->get('/besoins/ville/@idVille',[$DashboardControlleur,'besoinsVille']);

	// Pages principales (liens de navigation)
	$router->get('/villes', function() use ($app) {
		$VilleModel = new \app\model\Ville(\Flight::db());
		$villes = $VilleModel->getAllVilles();
		$app->render('villes/index', ['villes' => $villes]);
	});

	$router->get('/besoins', function() use ($app) {
		$BesoinModel = new \app\model\Besoin(\Flight::db());
		$besoins = $BesoinModel->getAllBesoins();
		$app->render('besoins/index', ['besoins' => $besoins]);
	});

	$router->get('/dons', function() use ($app) {
		$DonModel = new \app\model\Don(\Flight::db());
		$dons = $DonModel->getAllDon();
		$app->render('dons/index', ['dons' => $dons]);
	});

	$router->get('/distribution', function() use ($app) {
		$DistributionModel = new \app\model\Distribution(\Flight::db());
		$distributions = $DistributionModel->getDistributionDetaillee();
		$app->render('distribution/index', ['distributions' => $distributions]);
	});

	$router->get('/recapitulatif', function() use ($app) {
		$app->render('recapitulatif/index');
	});

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