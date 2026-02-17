<?php 

namespace app\controllers;
use app\model\Ville;
use app\model\Don;
use app\model\BesoinVille;
use app\model\Distribution;
use app\model\Achat;
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
        $data = [];
        foreach ($villes as $ville) {

            $idVille = $ville['id'];
            $montantTotalDon = $donVilleModel->getDonOneVille($idVille);
            $montantTotalBesoin = $besoinVilleModel->getBesoinOneVille($idVille);
            $besoinsDetail = $besoinVilleModel->getBesoinsDetailByVille($idVille);

            $data[] = array(
                'id' => $ville['id'],
                'nom' => $ville['nom'],
                'nombre_sinistre' => $ville['nombre_sinistre'],
                'don' => $montantTotalDon,
                'besoin' => $montantTotalBesoin,
                'besoins_detail' => $besoinsDetail
            );
        }

        $this->app->render('dashboard', ['villes' => $data]);
    }

    /**
     * API endpoint pour la page récapitulation (Ajax)
     */
    public function recapitulatifData() {
        $db = Flight::db();

        // Besoins totaux en montant (besoinVille * nombre_sinistre * prix_unitaire)
        $sqlBesoinsTotal = "SELECT COALESCE(SUM(total_prix_besoin), 0) as total FROM V_besoin_ville_detail";
        $stmtBT = $db->query($sqlBesoinsTotal);
        $besoinsTotal = $stmtBT->fetch(\PDO::FETCH_ASSOC)['total'];

        // Besoins satisfaits = montant total distribué
        $sqlSatisfaits = "SELECT COALESCE(SUM(montant_total), 0) as total FROM V_distribution_detaillee";
        $stmtS = $db->query($sqlSatisfaits);
        $besoinsSatisfaits = $stmtS->fetch(\PDO::FETCH_ASSOC)['total'];

        // Montant des achats effectués
        $AchatModel = new Achat($db);
        $totalAchats = $AchatModel->getTotalAchats();
        $totalDonsArgent = $AchatModel->getTotalDonsArgent();
        $soldeArgent = $AchatModel->getSoldeDisponible();

        // Dons restants en quantité
        $DonModel = new Don($db);
        $donsRestants = $DonModel->getDonsRestants();

        // Besoins restants en montant
        $besoinsRestants = $besoinsTotal - $besoinsSatisfaits;
        if ($besoinsRestants < 0) $besoinsRestants = 0;

        // Taux de couverture
        $tauxCouverture = $besoinsTotal > 0 ? ($besoinsSatisfaits / $besoinsTotal * 100) : 0;

        // Détail par ville
        $VilleModel = new Ville($db);
        $besoinVilleModel = new BesoinVille($db);
        $villes = $VilleModel->getAllVilles();
        $villesDetail = [];

        foreach ($villes as $ville) {
            $montantBesoin = $besoinVilleModel->getBesoinOneVille($ville['id']);
            $montantDon = $DonModel->getDonOneVille($ville['id']);

            $villesDetail[] = [
                'nom' => $ville['nom'],
                'nombre_sinistre' => $ville['nombre_sinistre'],
                'total_besoins' => floatval($montantBesoin),
                'total_distribue' => floatval($montantDon),
                'reste' => floatval($montantBesoin) - floatval($montantDon),
                'taux' => $montantBesoin > 0 ? (floatval($montantDon) / floatval($montantBesoin) * 100) : 0
            ];
        }

        Flight::json([
            'besoins_total' => floatval($besoinsTotal),
            'besoins_satisfaits' => floatval($besoinsSatisfaits),
            'besoins_restants' => floatval($besoinsRestants),
            'taux_couverture' => round($tauxCouverture, 1),
            'total_achats' => floatval($totalAchats),
            'total_dons_argent' => floatval($totalDonsArgent),
            'solde_argent' => floatval($soldeArgent),
            'dons_restants' => $donsRestants,
            'villes' => $villesDetail
        ]);
    }

    public function recapitulatif() {
        $this->app->render('recapitulatif');
    }
}