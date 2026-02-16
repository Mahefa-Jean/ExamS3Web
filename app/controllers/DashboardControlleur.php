<?php 

namespace app\controllers;
use app\model\Ville;
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
}