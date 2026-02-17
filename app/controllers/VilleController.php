<?php 

namespace app\controllers;
use app\model\Ville;
use app\model\Besoin;
use app\model\BesoinVille;

use Flight;
use flight\Engine;

class VilleController {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function liste(){

        $VilleModel = new Ville(Flight::db());
        $villes = $VilleModel->getAllVilles();
        $this->app->render('ville', ['villes' => $villes]);

    }

    public function create() {

        // Recuperation des données du formulaire
        $nom = Flight::request()->data->nom;
        $nombre_sinistres = Flight::request()->data->nombre_sinistre;
		
        $VilleModel = new Ville(Flight::db());
        $VilleModel->createVille($nom, $nombre_sinistres);


        $this->liste();
    }

    public function delete($id) {

        $VilleModel = new Ville(Flight::db());
        $VilleModel->delete($id);

        $this->liste();
    }

    public function edit($id) {
        $VilleModel = new Ville(Flight::db());
        $ville = $VilleModel->getById($id);
        $this->app->render('editVille', ['ville' => $ville]);
    }

    public function update($id) {
        $nom = Flight::request()->data->nom;
        $nombre_sinistre = Flight::request()->data->nombre_sinistre;

        $VilleModel = new Ville(Flight::db());
        $VilleModel->update($id, $nom, $nombre_sinistre);

        $this->liste();
    }

    public function besoins($id) {
        $VilleModel = new Ville(Flight::db());
        $ville = $VilleModel->getById($id);

        $BesoinVilleModel = new BesoinVille(Flight::db());
        $besoins = $BesoinVilleModel->getBesoinsDetailByVille($id);

        $BesoinModel = new Besoin(Flight::db());
        $allBesoins = $BesoinModel->getAllBesoins();

        $this->app->render('besoinsVille', ['ville' => $ville, 'besoins' => $besoins, 'allBesoins' => $allBesoins]);
    }

    public function createBesoinVille($id) {
        $id_besoin = Flight::request()->data->id_besoin;
        $quantite = Flight::request()->data->quantite;

        $BesoinVilleModel = new BesoinVille(Flight::db());
        $BesoinVilleModel->createBesoinVille($id, $id_besoin, $quantite);

        $this->besoins($id);
    }

    public function deleteBesoinVille($id_ville, $id) {
        $BesoinVilleModel = new BesoinVille(Flight::db());
        $BesoinVilleModel->delete($id);

        $this->besoins($id_ville);
    }

    public function editBesoinVille($id_ville, $id) {
        $VilleModel = new Ville(Flight::db());
        $ville = $VilleModel->getById($id_ville);

        $BesoinVilleModel = new BesoinVille(Flight::db());
        $besoinVille = $BesoinVilleModel->getById($id);

        $BesoinModel = new Besoin(Flight::db());
        $allBesoins = $BesoinModel->getAllBesoins();

        $this->app->render('editBesoinVille', ['ville' => $ville, 'besoinVille' => $besoinVille, 'allBesoins' => $allBesoins]);
    }

    public function updateBesoinVille($id_ville, $id) {
        $id_besoin = Flight::request()->data->id_besoin;
        $quantite = Flight::request()->data->quantite;

        $BesoinVilleModel = new BesoinVille(Flight::db());
        $BesoinVilleModel->update($id, $id_besoin, $quantite);

        $this->besoins($id_ville);
    }

}