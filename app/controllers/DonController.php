<?php 

namespace app\controllers;
use app\model\Don;
use app\model\Besoin;

use Flight;
use flight\Engine;

class DonController {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function liste(){
        $DonModel = new Don(Flight::db());
        $BesoinModel = new Besoin(Flight::db());
        $dons = $DonModel->getAllDon();
        $besoins = $BesoinModel->getAllBesoins();
        $this->app->render('don', ['dons' => $dons, 'besoins' => $besoins]);
    }

    public function create() {
        $id_besoin = Flight::request()->data->id_besoin;
        $quantite = Flight::request()->data->quantite;

        $DonModel = new Don(Flight::db());
        $DonModel->createDon($id_besoin, $quantite);

        $this->liste();
    }

    public function delete($id) {
        $DonModel = new Don(Flight::db());
        $DonModel->delete($id);

        $this->liste();
    }

    public function edit($id) {
        $DonModel = new Don(Flight::db());
        $BesoinModel = new Besoin(Flight::db());
        $don = $DonModel->getById($id);
        $besoins = $BesoinModel->getAllBesoins();
        $this->app->render('editDon', ['don' => $don, 'besoins' => $besoins]);
    }

    public function update($id) {
        $id_besoin = Flight::request()->data->id_besoin;
        $quantite = Flight::request()->data->quantite;

        $DonModel = new Don(Flight::db());
        $DonModel->update($id, $id_besoin, $quantite);

        $this->liste();
    }
}
