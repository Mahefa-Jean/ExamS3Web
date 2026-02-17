-- Supprimer les tables (dans l'ordre inverse de création pour respecter les clés étrangères)
DROP TABLE IF EXISTS don;
DROP TABLE IF EXISTS distribution;
DROP TABLE IF EXISTS besoinVille;
DROP TABLE IF EXISTS besoin;
DROP TABLE IF EXISTS ville;

-- Supprimer les vues (dans l'ordre inverse de leur dépendance)
DROP VIEW IF EXISTS V_somme_besoin_par_ville;
DROP VIEW IF EXISTS V_somme_montant_par_ville;
DROP VIEW IF EXISTS V_besoin_ville_detail;
DROP VIEW IF EXISTS V_distribution_detaillee;


