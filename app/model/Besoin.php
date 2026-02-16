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

    public function getAllBesoins() {
        $stmt = $this->db->query("SELECT * FROM besoin");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createBesoin($nom, $prix_unitaire) {
        $sql = "INSERT INTO besoin (nom, prix_unitaire) VALUES (:nom, :prix_unitaire)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nom' => $nom, ':prix_unitaire' => $prix_unitaire]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM besoin WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nom, $prix_unitaire) {
        $sql = "UPDATE besoin SET nom = :nom, prix_unitaire = :prix_unitaire WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':nom' => $nom, ':prix_unitaire' => $prix_unitaire]);
    }

    public function delete($id) {
        // Supprimer les dons liés à ce besoin
        $sql = "DELETE FROM don WHERE id_besoin = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Supprimer les distributions liées à ce besoin
        $sql = "DELETE FROM distribution WHERE id_besoin = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Supprimer les besoinVille liés à ce besoin
        $sql = "DELETE FROM besoinVille WHERE id_besoin = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Supprimer le besoin
        $sql = "DELETE FROM besoin WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    
}