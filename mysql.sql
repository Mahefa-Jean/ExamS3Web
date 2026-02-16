create DATABASE BNGRC;
USE BNGRC;

CREATE TABLE ville(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    nombre_sinistre INT NOT NULL
);

CREATE TABLE besoin(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    prix_unitaire DECIMAL(10, 2) NOT NULL
);

CREATE TABLE don(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_besoin INT NOT NULL,
    quantite INT NOT NULL,
    FOREIGN KEY (id_besoin) REFERENCES besoin(id)
);

CREATE TABLE distribution(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ville INT,
    id_besoin INT NOT NULL,
    quantite INT NOT NULL,
    FOREIGN KEY (id_ville) REFERENCES ville(id),
    FOREIGN KEY (id_besoin) REFERENCES besoin(id)
);

CREATE TABLE besoinVille(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ville INT,
    id_besoin INT NOT NULL,
    quantite_par_sinistre INT NOT NULL,
    FOREIGN KEY (id_ville) REFERENCES ville(id),
    FOREIGN KEY (id_besoin) REFERENCES besoin(id)
);

CREATE OR REPLACE VIEW V_distribution_detaillee AS
SELECT 
    d.id as id,
    v.nom as ville,
    v.id as id_ville,
    v.nombre_sinistre,
    b.nom as besoin,
    b.prix_unitaire,
    d.quantite,
    (d.quantite * b.prix_unitaire) as montant_total
FROM distribution d
JOIN ville v ON d.id_ville = v.id
JOIN besoin b ON d.id_besoin = b.id;

CREATE OR REPLACE VIEW V_somme_montant_par_ville AS
SELECT 
    id_ville,
    SUM(montant_total) as montant_total_ville
FROM V_distribution_detaillee
GROUP BY id_ville; 