<?php 

namespace app\model;

use flight;
use flight\Engine;
use PDO;

class BesoinVille {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getBesoinOneVille($idVille){

        $sql = "SELECT montant_total_besoin FROM V_somme_besoin_par_ville WHERE id_ville = :idVille";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':idVille' => $idVille]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['montant_total_besoin'] : 0;

    }




    
}