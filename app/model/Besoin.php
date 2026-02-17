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

<<<<<<< HEAD
    public function getBesoinsParVille($idVille) {
        $sql = "SELECT b.id, b.nom, b.prix_unitaire 
                FROM besoinVille bv
                JOIN besoin b ON bv.id_besoin = b.id
                WHERE bv.id_ville = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idVille]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBesoins() {
        $stmt = $this->db->query("SELECT * FROM besoin");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
=======
    public function getAllBesoins() {
        $stmt = $this->db->query("SELECT b.*, c.nom as categorie FROM besoin b JOIN categorie c ON b.id_categorie = c.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createBesoin($nom, $prix_unitaire, $id_categorie = 1) {
        $sql = "INSERT INTO besoin (nom, prix_unitaire, id_categorie) VALUES (:nom, :prix_unitaire, :id_categorie)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nom' => $nom, ':prix_unitaire' => $prix_unitaire, ':id_categorie' => $id_categorie]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM besoin WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nom, $prix_unitaire, $id_categorie = 1) {
        $sql = "UPDATE besoin SET nom = :nom, prix_unitaire = :prix_unitaire, id_categorie = :id_categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':nom' => $nom, ':prix_unitaire' => $prix_unitaire, ':id_categorie' => $id_categorie]);
    }

    public function getBesoinsAchetables() {
        $stmt = $this->db->query("SELECT b.*, c.nom as categorie FROM besoin b JOIN categorie c ON b.id_categorie = c.id WHERE c.nom IN ('nature', 'materiaux')");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBesoinArgent() {
        $stmt = $this->db->query("SELECT b.*, c.nom as categorie FROM besoin b JOIN categorie c ON b.id_categorie = c.id WHERE c.nom = 'argent'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
>>>>>>> origin/backend

    
}