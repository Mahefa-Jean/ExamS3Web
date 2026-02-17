<?php 

namespace app\model;

use flight;
use flight\Engine;
use PDO;

class Don {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllDon() {
        $stmt = $this->db->query("SELECT d.id, b.nom as besoin, c.nom as categorie, d.quantite, d.date FROM don d JOIN besoin b ON d.id_besoin = b.id JOIN categorie c ON b.id_categorie = c.id ORDER BY d.date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createDon($id_besoin, $quantite) {
        $sql = "INSERT INTO don (id_besoin, quantite, date) VALUES (:id_besoin, :quantite, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_besoin' => $id_besoin, ':quantite' => $quantite]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM don WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $id_besoin, $quantite) {
        $sql = "UPDATE don SET id_besoin = :id_besoin, quantite = :quantite WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':id_besoin' => $id_besoin, ':quantite' => $quantite]);
    }

    public function delete($id) {
        $sql = "DELETE FROM don WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
    
    public function getDonOneVille($idVille){

        $sql = "SELECT montant_total_distribution FROM V_somme_montant_par_ville WHERE id_ville = :idVille";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':idVille' => $idVille]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['montant_total_distribution'] : 0;     
    }

    /**
     * Obtenir les dons restants (quantité > 0)
     */
    public function getDonsRestants() {
        $sql = "SELECT b.id as id_besoin, b.nom as besoin, c.nom as categorie, 
                       SUM(d.quantite) as quantite
                FROM don d 
                JOIN besoin b ON d.id_besoin = b.id 
                JOIN categorie c ON b.id_categorie = c.id 
                WHERE d.quantite > 0 
                GROUP BY b.id, b.nom, c.nom
                ORDER BY b.nom ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtenir le total restant pour un besoin donné
     */
    public function getQuantiteRestante($id_besoin) {
        $sql = "SELECT COALESCE(SUM(d.quantite), 0) as total 
                FROM don d 
                WHERE d.id_besoin = :id_besoin AND d.quantite > 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_besoin' => $id_besoin]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Diminuer la quantité d'un don (utilisé lors de la distribution)
     */
    public function diminuerQuantite($id_besoin, $quantite_a_diminuer) {
        // Récupérer les dons pour ce besoin avec quantité > 0, du plus ancien au plus récent
        $sql = "SELECT id, quantite FROM don WHERE id_besoin = :id_besoin AND quantite > 0 ORDER BY date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_besoin' => $id_besoin]);
        $dons = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $reste_a_diminuer = $quantite_a_diminuer;

        foreach ($dons as $don) {
            if ($reste_a_diminuer <= 0) break;

            if ($don['quantite'] >= $reste_a_diminuer) {
                // Ce don suffit
                $nouvelle_quantite = $don['quantite'] - $reste_a_diminuer;
                $updateSql = "UPDATE don SET quantite = :quantite WHERE id = :id";
                $updateStmt = $this->db->prepare($updateSql);
                $updateStmt->execute([':quantite' => $nouvelle_quantite, ':id' => $don['id']]);
                $reste_a_diminuer = 0;
            } else {
                // Ce don ne suffit pas, on le met à 0 et on continue
                $reste_a_diminuer -= $don['quantite'];
                $updateSql = "UPDATE don SET quantite = 0 WHERE id = :id";
                $updateStmt = $this->db->prepare($updateSql);
                $updateStmt->execute([':id' => $don['id']]);
            }
        }
    }
}