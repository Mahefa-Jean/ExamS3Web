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
        $stmt = $this->db->query("SELECT * FROM distribution");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistributionParVille($idVille) {
        $stmt = $this->db->prepare("SELECT * FROM distribution WHERE id_ville = ?");
        $stmt->execute([$idVille]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistributionDetaillee() {
        $stmt = $this->db->query("SELECT * FROM V_distribution_detaillee");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}