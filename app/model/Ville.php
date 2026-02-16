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

}