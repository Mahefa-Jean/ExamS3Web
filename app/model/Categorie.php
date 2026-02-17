<?php 

namespace app\model;

use flight;
use flight\Engine;
use PDO;

class Categorie {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM categorie ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByNom($nom) {
        $sql = "SELECT * FROM categorie WHERE nom = :nom";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nom' => $nom]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
