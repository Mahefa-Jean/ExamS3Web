<?php 

namespace app\controllers;
use app\model\Ville;
<<<<<<< HEAD
use app\model\Distribution;
use app\model\Don;
use Flight\engine;
=======
use app\model\Besoin;
use Flight;
use flight\Engine;
>>>>>>> 230ac4383daa2c5699daa9c921491c6ff54b58fe    

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