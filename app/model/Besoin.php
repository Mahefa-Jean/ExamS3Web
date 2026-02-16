<?php 

namespace app\model;

use flight;
use flight\Engine;
use PDO;

class Besoin {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getBesoinsParVille($idVille) {
        $sql = "SELECT b.id, b.nom, b.prix_unitaire 
                FROM besoinVille bv
                JOIN besoin b ON bv.id_besoin = b.id
                WHERE bv.id_ville = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idVille]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBesoins() {
        $stmt = $this->db->query("SELECT * FROM besoin");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function live(){
    //     $stmt = $this->db->query("SELECT * FROM v_Liv");
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // public function daysLiv(){
    //     $stmt = $this->db->query("SELECT * FROM v_day_livrer");
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    
    // public function getOneLivraisonById($id) {
    //     $stmt = $this->db->prepare("SELECT * FROM v_Liv WHERE id = ?");
    //     $stmt->execute([$id]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

    
}