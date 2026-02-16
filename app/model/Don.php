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
        $stmt = $this->db->query("SELECT * FROM don");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getDonOneVille($idVille){

        $sql = "SELECT montant_total_distribution FROM V_somme_montant_par_ville WHERE id_ville = :idVille";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':idVille' => $idVille]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['montant_total_distribution'] : 0;     
    }

    
}