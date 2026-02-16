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


    
}