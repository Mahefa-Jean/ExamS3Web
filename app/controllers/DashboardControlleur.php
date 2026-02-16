<?php 

namespace app\controllers;
use app\model\Ville;
use app\model\Besoin;
use Flight;
use flight\Engine;

class DashboardControlleur {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function dashboard() {

        $VilleModel = new Ville(Flight::db());

        $villes = $VilleModel->getAllVilles();

        $this->app->render('dashboard', [
            'villes' => $villes
        ]);
    }

    public function besoinsVille($idVille) {
        $VilleModel = new Ville(Flight::db());
        $BesoinModel = new Besoin(Flight::db());

        $ville = $VilleModel->getVilleById($idVille);
        $besoins = $BesoinModel->getBesoinsParVille($idVille);

        $this->app->render('besoins/ville', [
            'ville' => $ville,
            'besoins' => $besoins
        ]);
    }
}