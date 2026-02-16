<?php 

namespace app\controllers;
use app\model\Besoin;

use Flight;
use flight\Engine;

class BesoinController {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function liste(){
        $BesoinModel = new Besoin(Flight::db());
        $besoins = $BesoinModel->getAllBesoins();
        $this->app->render('besoin', ['besoins' => $besoins]);
    }

    public function create() {
        $nom = Flight::request()->data->nom;
        $prix_unitaire = Flight::request()->data->prix_unitaire;

        $BesoinModel = new Besoin(Flight::db());
        $BesoinModel->createBesoin($nom, $prix_unitaire);

        $this->liste();
    }

    public function delete($id) {
        $BesoinModel = new Besoin(Flight::db());
        $BesoinModel->delete($id);

        $this->liste();
    }

    public function edit($id) {
        $BesoinModel = new Besoin(Flight::db());
        $besoin = $BesoinModel->getById($id);
        $this->app->render('editBesoin', ['besoin' => $besoin]);
    }

    public function update($id) {
        $nom = Flight::request()->data->nom;
        $prix_unitaire = Flight::request()->data->prix_unitaire;

        $BesoinModel = new Besoin(Flight::db());
        $BesoinModel->update($id, $nom, $prix_unitaire);

        $this->liste();
    }
}
