<?php 

namespace app\controllers;
use app\model\Distribution;
use app\model\Ville;
use app\model\Besoin;
use app\model\Don;
use app\model\BesoinVille;

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

    /**
     * Affiche la page de dispatch : tous les besoins de toutes les villes + formulaire choix méthode
     */
    public function dispatch($message = null, $message_type = null) {
        $BesoinVilleModel = new BesoinVille(Flight::db());
        $DonModel = new Don(Flight::db());

        $besoins_villes = $BesoinVilleModel->getAllBesoinsVilleDetailByDate();
        $dons_restants = $DonModel->getDonsRestants();

        $this->app->render('dispatch', [
            'besoins_villes' => $besoins_villes,
            'dons_restants' => $dons_restants,
            'message' => $message,
            'message_type' => $message_type
        ]);
    }

    /**
     * Exécuter le dispatch automatique selon la méthode choisie
     */
    public function executerDispatch() {
        $methode = Flight::request()->data->methode;

        $BesoinVilleModel = new BesoinVille(Flight::db());
        $DonModel = new Don(Flight::db());
        $DistributionModel = new Distribution(Flight::db());

        // Récupérer les besoins selon la méthode
        switch ($methode) {
            case 'date':
                $besoins = $BesoinVilleModel->getAllBesoinsVilleDetailByDate();
                break;
            case 'quantite':
                $besoins = $BesoinVilleModel->getAllBesoinsVilleDetailByQuantite();
                break;
            case 'proportionnel':
                $besoins = $BesoinVilleModel->getAllBesoinsVilleDetailByDate();
                break;
            default:
                $this->dispatch("Méthode de distribution invalide.", "danger");
                return;
        }

        if (empty($besoins)) {
            $this->dispatch("Aucun besoin à distribuer.", "danger");
            return;
        }

        $nb_distributions = 0;

        if ($methode === 'proportionnel') {
            // Méthode proportionnelle : on répartit les dons proportionnellement
            // Pour chaque besoin (type), calculer le total demandé, puis répartir le don disponible
            $besoins_par_type = [];
            foreach ($besoins as $b) {
                $besoins_par_type[$b['id_besoin']][] = $b;
            }

            foreach ($besoins_par_type as $id_besoin => $liste_besoins) {
                $don_disponible = $DonModel->getQuantiteRestante($id_besoin);
                if ($don_disponible <= 0) continue;

                $total_demande = 0;
                foreach ($liste_besoins as $b) {
                    $total_demande += $b['quantite'];
                }

                foreach ($liste_besoins as $b) {
                    if ($don_disponible <= 0) break;

                    // Part proportionnelle
                    $ratio = $b['quantite'] / $total_demande;
                    $quantite_attribuee = (int) floor($don_disponible * $ratio);
                    if ($quantite_attribuee <= 0) continue;

                    // Ne pas dépasser le besoin
                    $quantite_a_distribuer = min($quantite_attribuee, $b['quantite']);

                    // Créer la distribution
                    $DistributionModel->createDistribution($b['id_ville'], $b['id_besoin'], $quantite_a_distribuer);
                    $DonModel->diminuerQuantite($b['id_besoin'], $quantite_a_distribuer);
                    $BesoinVilleModel->diminuerQuantite($b['id'], $quantite_a_distribuer);
                    $don_disponible -= $quantite_a_distribuer;
                    $nb_distributions++;
                }
            }
        } else {
            // Méthode par date ou par quantité : on distribue dans l'ordre
            foreach ($besoins as $b) {
                $don_disponible = $DonModel->getQuantiteRestante($b['id_besoin']);
                if ($don_disponible <= 0) continue;

                $quantite_a_distribuer = min($b['quantite'], $don_disponible);

                // Créer la distribution
                $DistributionModel->createDistribution($b['id_ville'], $b['id_besoin'], $quantite_a_distribuer);

                // Diminuer le don
                $DonModel->diminuerQuantite($b['id_besoin'], $quantite_a_distribuer);

                // Diminuer ou supprimer le besoinVille
                $BesoinVilleModel->diminuerQuantite($b['id'], $quantite_a_distribuer);

                $nb_distributions++;
            }
        }

        if ($nb_distributions > 0) {
            $methode_label = $methode === 'date' ? 'par ordre de date' : ($methode === 'quantite' ? 'par plus petit quantité' : 'proportionnel');
            $this->dispatch("Dispatch effectué avec succès ($methode_label) : $nb_distributions distribution(s) créée(s).", "success");
        } else {
            $this->dispatch("Aucune distribution n'a pu être effectuée. Vérifiez les dons restants.", "danger");
        }
    }
}
