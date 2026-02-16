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
    

    
}