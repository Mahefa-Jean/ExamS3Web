<?php 

namespace app\controllers;
use app\model\Besoin;
use app\model\Categorie;

use Flight;
use flight\Engine;

class BesoinController {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function liste(){
        $BesoinModel = new Besoin(Flight::db());
        $CategorieModel = new Categorie(Flight::db());
        $besoins = $BesoinModel->getAllBesoins();
        $categories = $CategorieModel->getAllCategories();
        $this->app->render('besoin', ['besoins' => $besoins, 'categories' => $categories]);
    }

    public function create() {
        $nom = Flight::request()->data->nom;
        $prix_unitaire = Flight::request()->data->prix_unitaire;
        $id_categorie = Flight::request()->data->id_categorie ?? 1;

        $BesoinModel = new Besoin(Flight::db());
        $BesoinModel->createBesoin($nom, $prix_unitaire, $id_categorie);

        $this->liste();
    }

    public function delete($id) {
        $BesoinModel = new Besoin(Flight::db());
        $BesoinModel->delete($id);

        $this->liste();
    }

    public function edit($id) {
        $BesoinModel = new Besoin(Flight::db());
        $CategorieModel = new Categorie(Flight::db());
        $besoin = $BesoinModel->getById($id);
        $categories = $CategorieModel->getAllCategories();
        $this->app->render('editBesoin', ['besoin' => $besoin, 'categories' => $categories]);
    }

    public function update($id) {
        $nom = Flight::request()->data->nom;
        $prix_unitaire = Flight::request()->data->prix_unitaire;
        $id_categorie = Flight::request()->data->id_categorie ?? 1;

        $BesoinModel = new Besoin(Flight::db());
        $BesoinModel->update($id, $nom, $prix_unitaire, $id_categorie);

        $this->liste();
    }
}
