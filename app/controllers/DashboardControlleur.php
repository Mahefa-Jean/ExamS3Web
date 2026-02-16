<?php 

namespace app\controllers;
use app\model\Ville;
use app\model\Don;
use app\model\BesoinVille;
use Flight;
use flight\Engine;

class DashboardControlleur {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function dashboard() {

        $VilleModel = new Ville(Flight::db());
        $donVilleModel = new Don(Flight::db());
        $besoinVilleModel = new BesoinVille(Flight::db());

        $villes = $VilleModel->getAllVilles();
        $data = array();

        foreach ($villes as $ville) {

            $idVille = $ville['id'];
            $montantTotalDon = $donVilleModel->getDonOneVille($idVille);
            $montantTotalBesoin = $besoinVilleModel->getBesoinOneVille($idVille);

            $data[] = array(
                'nom' => $ville['nom'],
                'don' => $montantTotalDon,
                'besoin' => $montantTotalBesoin
            );

            
        }

        $this->app->render('dashboard', ['villes' => $data]);
    }

}