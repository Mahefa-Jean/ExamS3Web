<?php 

namespace app\model;

use flight;
use flight\Engine;
use PDO;

class Achat {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllAchats() {
        $sql = "SELECT a.id, b.nom as besoin, c.nom as categorie,
                       a.quantite, a.frais_pourcent, b.prix_unitaire,
                       (a.quantite * b.prix_unitaire) as sous_total,
                       a.montant_total, a.date
                FROM achat a 
                JOIN besoin b ON a.id_besoin = b.id 
                JOIN categorie c ON b.id_categorie = c.id
                ORDER BY a.date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createAchat($id_besoin, $quantite, $frais_pourcent) {
        // Calculer le montant total avec frais
        $besoinStmt = $this->db->prepare("SELECT prix_unitaire FROM besoin WHERE id = :id");
        $besoinStmt->execute([':id' => $id_besoin]);
        $besoin = $besoinStmt->fetch(PDO::FETCH_ASSOC);
        
        $sous_total = $quantite * $besoin['prix_unitaire'];
        $montant_total = $sous_total * (1 + $frais_pourcent / 100);

        $sql = "INSERT INTO achat (id_besoin, quantite, frais_pourcent, montant_total, date) 
                VALUES (:id_besoin, :quantite, :frais_pourcent, :montant_total, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_besoin' => $id_besoin, 
            ':quantite' => $quantite, 
            ':frais_pourcent' => $frais_pourcent,
            ':montant_total' => $montant_total
        ]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM achat WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM achat WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    /**
     * Obtenir le total des dons en argent disponibles
     */
    public function getTotalDonsArgent() {
        $sql = "SELECT COALESCE(SUM(d.quantite * b.prix_unitaire), 0) as total 
                FROM don d 
                JOIN besoin b ON d.id_besoin = b.id 
                JOIN categorie c ON b.id_categorie = c.id
                WHERE c.nom = 'argent'";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Obtenir le total des achats déjà effectués
     */
    public function getTotalAchats() {
        $sql = "SELECT COALESCE(SUM(montant_total), 0) as total FROM achat";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Obtenir le solde disponible (dons argent - achats)
     */
    public function getSoldeDisponible() {
        return $this->getTotalDonsArgent() - $this->getTotalAchats();
    }

    /**
     * Vérifier si un besoin existe encore dans les dons restants (quantité > 0)
     */
    public function besoinExisteDansDons($id_besoin) {
        $sql = "SELECT COALESCE(SUM(d.quantite), 0) as total_dons 
                FROM don d 
                WHERE d.id_besoin = :id_besoin AND d.quantite > 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_besoin' => $id_besoin]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_dons'] > 0;
    }

    /**
     * Simuler un achat (retourne les détails sans enregistrer)
     */
    public function simulerAchat($id_besoin, $quantite, $frais_pourcent) {
        $besoinStmt = $this->db->prepare("SELECT * FROM besoin WHERE id = :id");
        $besoinStmt->execute([':id' => $id_besoin]);
        $besoin = $besoinStmt->fetch(PDO::FETCH_ASSOC);

        $sous_total = $quantite * $besoin['prix_unitaire'];
        $frais = $sous_total * ($frais_pourcent / 100);
        $montant_total = $sous_total + $frais;
        $solde_disponible = $this->getSoldeDisponible();

        return [
            'besoin' => $besoin,
            'quantite' => $quantite,
            'prix_unitaire' => $besoin['prix_unitaire'],
            'sous_total' => $sous_total,
            'frais_pourcent' => $frais_pourcent,
            'frais' => $frais,
            'montant_total' => $montant_total,
            'solde_disponible' => $solde_disponible,
            'solde_apres_achat' => $solde_disponible - $montant_total,
            'achat_possible' => ($solde_disponible >= $montant_total)
        ];
    }
}
