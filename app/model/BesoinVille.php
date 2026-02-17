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

    public function createBesoinVille($id_ville, $id_besoin, $quantite) {
        $sql = "INSERT INTO besoinVille (id_ville, id_besoin, quantite, date) VALUES (:id_ville, :id_besoin, :quantite, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_ville' => $id_ville, ':id_besoin' => $id_besoin, ':quantite' => $quantite]);
    }

    public function update($id, $id_besoin, $quantite) {
        $sql = "UPDATE besoinVille SET id_besoin = :id_besoin, quantite = :quantite WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':id_besoin' => $id_besoin, ':quantite' => $quantite]);
    }

    public function delete($id) {
        $sql = "DELETE FROM besoinVille WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    /**
     * Tous les besoins ville triés par date de saisie ASC
     */
    public function getAllBesoinsVilleDetailByDate() {
        $sql = "SELECT * FROM V_besoin_ville_detail ORDER BY date ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tous les besoins ville triés par quantité ASC (plus petit d'abord)
     */
    public function getAllBesoinsVilleDetailByQuantite() {
        $sql = "SELECT * FROM V_besoin_ville_detail ORDER BY quantite ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Diminuer la quantité d'un besoinVille après distribution.
     * Si quantite tombe à 0, on supprime la ligne.
     */
    public function diminuerQuantite($id, $quantite_distribuee) {
        $besoin = $this->getById($id);
        if (!$besoin) return;

        $nouvelle_quantite = $besoin['quantite'] - $quantite_distribuee;
        if ($nouvelle_quantite <= 0) {
            $this->delete($id);
        } else {
            $sql = "UPDATE besoinVille SET quantite = :qte WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':qte' => $nouvelle_quantite, ':id' => $id]);
        }
    }

}