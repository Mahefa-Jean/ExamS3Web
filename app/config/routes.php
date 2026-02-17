<?php

use app\controllers\DashboardControlleur;
use app\controllers\VilleController;
use app\controllers\BesoinController;
use app\controllers\DonController;
use app\controllers\DistributionController;
use app\controllers\AchatController;
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
	$VilleController = new VilleController($app);
	$BesoinController = new BesoinController($app);
	$DonController = new DonController($app);
	$DistributionController = new DistributionController($app);
	$AchatController = new AchatController($app);

	// Dashboard
	$router->get('/',[$DashboardControlleur,'dashboard']);

	// Récapitulation
	$router->get('/recapitulatif',[$DashboardControlleur,'recapitulatif']);
	$router->get('/recapitulatif/data',[$DashboardControlleur,'recapitulatifData']);

	// Villes
	$router->get('/villes',[$VilleController,'liste']);
	$router->get('/villes/besoins/@id',[$VilleController,'besoins']);
	$router->post('/villes/besoins/@id/create',[$VilleController,'createBesoinVille']);
	$router->get('/villes/besoins/@id_ville/edit/@id',[$VilleController,'editBesoinVille']);
	$router->post('/villes/besoins/@id_ville/update/@id',[$VilleController,'updateBesoinVille']);
	$router->get('/villes/besoins/@id_ville/delete/@id',[$VilleController,'deleteBesoinVille']);
	$router->get('/villes/edit/@id',[$VilleController,'edit']);
	$router->post('/villes/update/@id',[$VilleController,'update']);
	$router->get('/villes/delete/@id',[$VilleController,'delete']);
	$router->post('/villes/create',[$VilleController,'create']);

	// Besoins
	$router->get('/besoins',[$BesoinController,'liste']);
	$router->get('/besoins/edit/@id',[$BesoinController,'edit']);
	$router->post('/besoins/update/@id',[$BesoinController,'update']);
	$router->get('/besoins/delete/@id',[$BesoinController,'delete']);
	$router->post('/besoins/create',[$BesoinController,'create']);

	// Dons
	$router->get('/dons',[$DonController,'liste']);
	$router->get('/dons/restants',[$DonController,'restants']);
	$router->get('/dons/edit/@id',[$DonController,'edit']);
	$router->post('/dons/update/@id',[$DonController,'update']);
	$router->get('/dons/delete/@id',[$DonController,'delete']);
	$router->post('/dons/create',[$DonController,'create']);

	// Distributions
	$router->get('/distributions',[$DistributionController,'liste']);
	$router->post('/distributions/simuler',[$DistributionController,'simuler']);
	$router->post('/distributions/valider',[$DistributionController,'create']);
	$router->get('/distributions/edit/@id',[$DistributionController,'edit']);
	$router->post('/distributions/update/@id',[$DistributionController,'update']);
	$router->get('/distributions/delete/@id',[$DistributionController,'delete']);
	$router->post('/distributions/create',[$DistributionController,'create']);

	// Dispatch
	$router->get('/dispatch',[$DistributionController,'dispatch']);
	$router->post('/dispatch/executer',[$DistributionController,'executerDispatch']);

	// Achats
	$router->get('/achats',[$AchatController,'liste']);
	$router->post('/achats/simuler',[$AchatController,'simuler']);
	$router->post('/achats/valider',[$AchatController,'valider']);
	$router->get('/achats/delete/@id',[$AchatController,'delete']);


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