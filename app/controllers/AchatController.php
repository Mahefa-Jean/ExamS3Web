<?php 

namespace app\controllers;
use app\model\Achat;
use app\model\Besoin;
use app\model\Don;
use app\model\Ville;
use app\model\BesoinVille;

use Flight;
use flight\Engine;

class AchatController {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function liste(){
        $AchatModel = new Achat(Flight::db());
        $BesoinModel = new Besoin(Flight::db());
        $VilleModel = new Ville(Flight::db());
        $BesoinVilleModel = new BesoinVille(Flight::db());

        $achats = $AchatModel->getAllAchats();
        $besoins = $BesoinModel->getBesoinsAchetables();
        $villes = $VilleModel->getAllVilles();
        // Besoins restants par ville (nature et materiaux uniquement)
        $besoins_restants = $BesoinVilleModel->getBesoinsVilleAchetables();
        
        $solde_disponible = $AchatModel->getSoldeDisponible();
        $total_dons_argent = $AchatModel->getTotalDonsArgent();
        $total_achats = $AchatModel->getTotalAchats();

        $this->app->render('achat', [
            'achats' => $achats, 
            'besoins' => $besoins, 
            'villes' => $villes,
            'besoins_restants' => $besoins_restants,
            'solde_disponible' => $solde_disponible,
            'total_dons_argent' => $total_dons_argent,
            'total_achats' => $total_achats,
            'error' => null,
            'simulation' => null
        ]);
    }

    public function simuler() {
        $AchatModel = new Achat(Flight::db());
        $BesoinModel = new Besoin(Flight::db());

        $id_ville = Flight::request()->data->id_ville;
        $id_besoin = Flight::request()->data->id_besoin;
        $quantite = Flight::request()->data->quantite;
        $frais_pourcent = Flight::request()->data->frais_pourcent ?? 10;

        $error = null;

        // Vérifier si le besoin existe déjà dans les dons restants (nature/materiaux)
        if ($AchatModel->besoinExisteDansDons($id_besoin)) {
            $besoin = $BesoinModel->getById($id_besoin);
            $error = "Erreur : Le besoin \"" . $besoin['nom'] . "\" existe encore dans les dons restants. Utilisez d'abord les dons disponibles avant d'acheter.";
        }

        $simulation = null;
        if (!$error) {
            $simulation = $AchatModel->simulerAchat($id_ville, $id_besoin, $quantite, $frais_pourcent);
        }

        $VilleModel = new Ville(Flight::db());
        $BesoinVilleModel = new BesoinVille(Flight::db());
        $achats = $AchatModel->getAllAchats();
        $besoins = $BesoinModel->getBesoinsAchetables();
        $villes = $VilleModel->getAllVilles();
        $besoins_restants = $BesoinVilleModel->getBesoinsVilleAchetables();
        $solde_disponible = $AchatModel->getSoldeDisponible();
        $total_dons_argent = $AchatModel->getTotalDonsArgent();
        $total_achats = $AchatModel->getTotalAchats();

        $this->app->render('achat', [
            'achats' => $achats, 
            'besoins' => $besoins, 
            'villes' => $villes,
            'besoins_restants' => $besoins_restants,
            'solde_disponible' => $solde_disponible,
            'total_dons_argent' => $total_dons_argent,
            'total_achats' => $total_achats,
            'error' => $error,
            'simulation' => $simulation,
            'form_data' => [
                'id_ville' => $id_ville,
                'id_besoin' => $id_besoin,
                'quantite' => $quantite,
                'frais_pourcent' => $frais_pourcent
            ]
        ]);
    }

    public function valider() {
        $AchatModel = new Achat(Flight::db());
        $BesoinModel = new Besoin(Flight::db());

        $id_ville = Flight::request()->data->id_ville;
        $id_besoin = Flight::request()->data->id_besoin;
        $quantite = Flight::request()->data->quantite;
        $frais_pourcent = Flight::request()->data->frais_pourcent ?? 10;

        // Vérifier si le besoin existe dans les dons
        if ($AchatModel->besoinExisteDansDons($id_besoin)) {
            $this->liste();
            return;
        }

        // Vérifier le solde
        $simulation = $AchatModel->simulerAchat($id_ville, $id_besoin, $quantite, $frais_pourcent);
        if (!$simulation['achat_possible']) {
            $this->liste();
            return;
        }

        $AchatModel->createAchat($id_ville, $id_besoin, $quantite, $frais_pourcent);

        // Enregistrer le besoin acheté dans les dons restants
        $DonModel = new Don(Flight::db());
        $DonModel->createDon($id_besoin, $quantite);

        // Diminuer les dons en argent (le montant total)
        $DonModel->diminuerQuantiteArgent($simulation['montant_total']);

        $this->liste();
    }

    public function delete($id) {
        $AchatModel = new Achat(Flight::db());
        $AchatModel->delete($id);
        $this->liste();
    }
}

