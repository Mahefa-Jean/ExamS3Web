<?php 

namespace app\model;

use flight;
use flight\Engine;
use PDO;

class Distribution {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllDistributions() {
        $stmt = $this->db->query("SELECT * FROM V_distribution_detaillee");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createDistribution($id_ville, $id_besoin, $quantite) {
        $sql = "INSERT INTO distribution (id_ville, id_besoin, quantite, date) VALUES (:id_ville, :id_besoin, :quantite, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_ville' => $id_ville, ':id_besoin' => $id_besoin, ':quantite' => $quantite]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM distribution WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $id_ville, $id_besoin, $quantite) {
        $sql = "UPDATE distribution SET id_ville = :id_ville, id_besoin = :id_besoin, quantite = :quantite WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':id_ville' => $id_ville, ':id_besoin' => $id_besoin, ':quantite' => $quantite]);
    }

    public function delete($id) {
        $sql = "DELETE FROM distribution WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    
}