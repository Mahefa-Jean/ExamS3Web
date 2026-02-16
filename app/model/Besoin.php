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