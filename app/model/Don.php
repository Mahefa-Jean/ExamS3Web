<?php 

namespace app\model;

use flight;
use flight\Engine;
use PDO;

class Don {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllDon() {
        $stmt = $this->db->query("SELECT d.id, b.nom as besoin, d.quantite, d.date FROM don d JOIN besoin b ON d.id_besoin = b.id ORDER BY d.date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createDon($id_besoin, $quantite) {
        $sql = "INSERT INTO don (id_besoin, quantite, date) VALUES (:id_besoin, :quantite, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_besoin' => $id_besoin, ':quantite' => $quantite]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM don WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $id_besoin, $quantite) {
        $sql = "UPDATE don SET id_besoin = :id_besoin, quantite = :quantite WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':id_besoin' => $id_besoin, ':quantite' => $quantite]);
    }

    public function delete($id) {
        $sql = "DELETE FROM don WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
    
    public function getDonOneVille($idVille){

        $sql = "SELECT montant_total_distribution FROM V_somme_montant_par_ville WHERE id_ville = :idVille";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':idVille' => $idVille]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['montant_total_distribution'] : 0;     
    }

    
}