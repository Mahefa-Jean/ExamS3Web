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

        $stmt = $this->db->prepare("SELECT montant_total_besoin FROM V_somme_besoin_par_ville WHERE id_ville = :idVille");
        $stmt->bindParam(':idVille', $idVille, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['montant_total_besoin'] : 0;

    }




    
}