<?php 

namespace app\controllers;
use app\model\Distribution;
use app\model\Ville;
use app\model\Besoin;

use Flight;
use flight\Engine;

class DistributionController {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function liste(){
        $DistributionModel = new Distribution(Flight::db());
        $VilleModel = new Ville(Flight::db());
        $BesoinModel = new Besoin(Flight::db());
        $distributions = $DistributionModel->getAllDistributions();
        $villes = $VilleModel->getAllVilles();
        $besoins = $BesoinModel->getAllBesoins();
        $this->app->render('distribution', ['distributions' => $distributions, 'villes' => $villes, 'besoins' => $besoins]);
    }

    public function create() {
        $id_ville = Flight::request()->data->id_ville;
        $id_besoin = Flight::request()->data->id_besoin;
        $quantite = Flight::request()->data->quantite;

        $DistributionModel = new Distribution(Flight::db());
        $DistributionModel->createDistribution($id_ville, $id_besoin, $quantite);

        $this->liste();
    }

    public function delete($id) {
        $DistributionModel = new Distribution(Flight::db());
        $DistributionModel->delete($id);

        $this->liste();
    }

    public function edit($id) {
        $DistributionModel = new Distribution(Flight::db());
        $VilleModel = new Ville(Flight::db());
        $BesoinModel = new Besoin(Flight::db());
        $distribution = $DistributionModel->getById($id);
        $villes = $VilleModel->getAllVilles();
        $besoins = $BesoinModel->getAllBesoins();
        $this->app->render('editDistribution', ['distribution' => $distribution, 'villes' => $villes, 'besoins' => $besoins]);
    }

    public function update($id) {
        $id_ville = Flight::request()->data->id_ville;
        $id_besoin = Flight::request()->data->id_besoin;
        $quantite = Flight::request()->data->quantite;

        $DistributionModel = new Distribution(Flight::db());
        $DistributionModel->update($id, $id_ville, $id_besoin, $quantite);

        $this->liste();
    }
}
