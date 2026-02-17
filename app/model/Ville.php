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

    public function createVille($nom, $nombre_sinistre) {
        $sql = "INSERT INTO ville (nom, nombre_sinistre) VALUES (:nom, :nombre_sinistre)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nom' => $nom, ':nombre_sinistre' => $nombre_sinistre]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM ville WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nom, $nombre_sinistre) {
        $sql = "UPDATE ville SET nom = :nom, nombre_sinistre = :nombre_sinistre WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':nom' => $nom, ':nombre_sinistre' => $nombre_sinistre]);
    }

    public function delete($id) {
        $sql = "DELETE FROM distribution WHERE id_ville = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $sql = "DELETE FROM besoinVille WHERE id_ville = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $sql = "DELETE FROM ville WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}