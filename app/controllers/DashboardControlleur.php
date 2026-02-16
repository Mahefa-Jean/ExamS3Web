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
        $besoins = Besoin::all();
        $besoins_ville = BesoinVille::getBesoinVilleById();
        $villes = Ville::getAllVilles();
        $distributions = Distribution::all();
        $dons = Don::getAllDons();

        $this->app->render('Dashboard', [
            'besoins' => $besoins,
            'besoins_ville' => $besoins_ville,
            'villes' => $villes,
            'distributions' => $distributions,
            'dons' => $dons
        ]);
    }
}