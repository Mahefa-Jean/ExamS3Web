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

    public function getBesoinsDetailByVille($idVille){
        $sql = "SELECT * FROM V_besoin_ville_detail WHERE id_ville = :idVille";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':idVille' => $idVille]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM besoinVille WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createBesoinVille($id_ville, $id_besoin, $quantite_par_sinistre) {
        $sql = "INSERT INTO besoinVille (id_ville, id_besoin, quantite_par_sinistre) VALUES (:id_ville, :id_besoin, :quantite_par_sinistre)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_ville' => $id_ville, ':id_besoin' => $id_besoin, ':quantite_par_sinistre' => $quantite_par_sinistre]);
    }

    public function update($id, $id_besoin, $quantite_par_sinistre) {
        $sql = "UPDATE besoinVille SET id_besoin = :id_besoin, quantite_par_sinistre = :quantite_par_sinistre WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':id_besoin' => $id_besoin, ':quantite_par_sinistre' => $quantite_par_sinistre]);
    }

    public function delete($id) {
        $sql = "DELETE FROM besoinVille WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

}