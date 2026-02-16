<?php 

namespace app\controllers;
use app\model\Besoin;
use app\model\BesoinVille;
use app\model\Ville;
use app\model\Distribution;
use app\model\Don;
use Flight\engine;

class DashboardControlleur {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function dashboard() {
        $villes = Ville::getAllVilles();

        $this->app->render('Dashboard', [
            'villes' => $villes
        ]);
    }
}