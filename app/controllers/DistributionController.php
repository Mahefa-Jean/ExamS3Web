<?php 

namespace app\controllers;
use app\model\Distribution;
use app\model\Ville;
use app\model\Besoin;
use app\model\Don;

use Flight;
use flight\Engine;

class DistributionController {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function liste($error = null, $simulation = null, $form_data = null){
        $DistributionModel = new Distribution(Flight::db());
        $VilleModel = new Ville(Flight::db());
        $BesoinModel = new Besoin(Flight::db());
        $DonModel = new Don(Flight::db());
        $distributions = $DistributionModel->getAllDistributions();
        $villes = $VilleModel->getAllVilles();
        $besoins = $BesoinModel->getAllBesoins();

        // Récupérer la quantité restante pour chaque besoin
        $quantites_restantes = [];
        foreach ($besoins as $besoin) {
            $quantites_restantes[$besoin['id']] = $DonModel->getQuantiteRestante($besoin['id']);
        }

        $this->app->render('distribution', [
            'distributions' => $distributions, 
            'villes' => $villes, 
            'besoins' => $besoins,
            'quantites_restantes' => $quantites_restantes,
            'error' => $error,
            'simulation' => $simulation,
            'form_data' => $form_data
        ]);
    }

    public function simuler() {
        $id_ville = Flight::request()->data->id_ville;
        $id_besoin = Flight::request()->data->id_besoin;
        $quantite = Flight::request()->data->quantite;

        $DonModel = new Don(Flight::db());
        $BesoinModel = new Besoin(Flight::db());
        $VilleModel = new Ville(Flight::db());

        $besoin = $BesoinModel->getById($id_besoin);
        $ville = $VilleModel->getById($id_ville);
        $quantite_restante = $DonModel->getQuantiteRestante($id_besoin);

        $form_data = [
            'id_ville' => $id_ville,
            'id_besoin' => $id_besoin,
            'quantite' => $quantite
        ];

        // Vérifications
        if ($quantite_restante <= 0) {
            $error = "Distribution impossible : aucun don restant pour le besoin \"" . $besoin['nom'] . "\". Quantité disponible : 0.";
            $this->liste($error, null, $form_data);
            return;
        }

        if ($quantite > $quantite_restante) {
            $error = "Distribution impossible : quantité demandée (" . $quantite . ") supérieure aux dons restants pour \"" . $besoin['nom'] . "\". Quantité disponible : " . $quantite_restante . ".";
            $this->liste($error, null, $form_data);
            return;
        }

        // Simulation réussie
        $montant_total = $quantite * $besoin['prix_unitaire'];
        $simulation = [
            'ville' => $ville,
            'besoin' => $besoin,
            'quantite' => $quantite,
            'prix_unitaire' => $besoin['prix_unitaire'],
            'montant_total' => $montant_total,
            'stock_disponible' => $quantite_restante,
            'stock_apres' => $quantite_restante - $quantite,
            'possible' => true
        ];

        $this->liste(null, $simulation, $form_data);
    }

    public function create() {
        $id_ville = Flight::request()->data->id_ville;
        $id_besoin = Flight::request()->data->id_besoin;
        $quantite = Flight::request()->data->quantite;

        $DonModel = new Don(Flight::db());
        $BesoinModel = new Besoin(Flight::db());

        // Vérifier la quantité restante des dons pour ce besoin
        $quantite_restante = $DonModel->getQuantiteRestante($id_besoin);
        $besoin = $BesoinModel->getById($id_besoin);

        if ($quantite_restante <= 0) {
            $error = "Distribution refusée : aucun don restant pour le besoin \"" . $besoin['nom'] . "\". Quantité disponible : 0.";
            $this->liste($error);
            return;
        }

        if ($quantite > $quantite_restante) {
            $error = "Distribution refusée : quantité demandée (" . $quantite . ") supérieure aux dons restants pour \"" . $besoin['nom'] . "\". Quantité disponible : " . $quantite_restante . ".";
            $this->liste($error);
            return;
        }

        $DistributionModel = new Distribution(Flight::db());

        // Créer la distribution
        $DistributionModel->createDistribution($id_ville, $id_besoin, $quantite);

        // Diminuer la quantité des dons restants pour ce besoin
        $DonModel->diminuerQuantite($id_besoin, $quantite);

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
