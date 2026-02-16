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

    public function getVillesAvecStats() {
        $sql = "SELECT 
                    v.id,
                    v.nom,
                    v.nombre_sinistre,
                    COUNT(DISTINCT bv.id_besoin) as nombre_besoins,
                    COUNT(DISTINCT d.id) as nombre_dons
                FROM ville v
                LEFT JOIN besoinVille bv ON v.id = bv.id_ville
                LEFT JOIN distribution d ON v.id = d.id_ville
                GROUP BY v.id, v.nom, v.nombre_sinistre
                ORDER BY v.nom";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}