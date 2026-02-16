<?php 

namespace app\model;

use flight;
use flight\Engine;
use PDO;

class Ville {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllVilles() {
        $stmt = $this->db->query("SELECT * FROM ville");
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