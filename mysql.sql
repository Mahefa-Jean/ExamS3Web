create DATABASE BNGRC;
USE BNGRC;

CREATE TABLE ville(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    nombre_sinistre INT NOT NULL
);

CREATE TABLE categorie(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO categorie (nom) VALUES ('nature'), ('materiaux'), ('argent');

CREATE TABLE besoin(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    prix_unitaire DECIMAL(10, 2) NOT NULL,
    id_categorie INT NOT NULL DEFAULT 1,
    FOREIGN KEY (id_categorie) REFERENCES categorie(id)
);

CREATE TABLE achat(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_besoin INT NOT NULL,
    quantite INT NOT NULL,
    frais_pourcent DECIMAL(5, 2) NOT NULL DEFAULT 10.00,
    montant_total DECIMAL(10, 2) NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_besoin) REFERENCES besoin(id)
);

CREATE TABLE don(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_besoin INT NOT NULL,
    quantite INT NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_besoin) REFERENCES besoin(id)
);

CREATE TABLE distribution(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ville INT,
    id_besoin INT NOT NULL,
    quantite INT NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ville) REFERENCES ville(id),
    FOREIGN KEY (id_besoin) REFERENCES besoin(id)
);

CREATE TABLE besoinVille(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ville INT,
    id_besoin INT NOT NULL,
    quantite INT NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
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
    d.date,
    (d.quantite * b.prix_unitaire) as montant_total
FROM distribution d
JOIN ville v ON d.id_ville = v.id
JOIN besoin b ON d.id_besoin = b.id;

CREATE OR REPLACE VIEW V_somme_montant_par_ville AS
SELECT 
    id_ville,
    SUM(montant_total) as montant_total_distribution
FROM V_distribution_detaillee
GROUP BY id_ville;

CREATE OR REPLACE VIEW V_besoin_ville_detail AS
SELECT 
    bv.id as id,
    v.id as id_ville,
    v.nom as ville,
    v.nombre_sinistre,
    b.id as id_besoin,
    b.nom as besoin,
    b.prix_unitaire,
    bv.quantite,
    bv.date,
    (b.prix_unitaire * bv.quantite) as total_prix_besoin
FROM besoinVille bv
JOIN ville v ON bv.id_ville = v.id
JOIN besoin b ON bv.id_besoin = b.id;

CREATE OR REPLACE VIEW V_somme_besoin_par_ville AS
SELECT 
    id_ville,
    SUM(total_prix_besoin) as montant_total_besoin
FROM V_besoin_ville_detail
GROUP BY id_ville;

CREATE OR REPLACE VIEW V_dons_restants AS
SELECT 
    b.id as id_besoin,
    b.nom as besoin,
    c.nom as categorie,
    b.prix_unitaire,
    COALESCE(SUM(d.quantite), 0) as quantite_restante
FROM don d
JOIN besoin b ON d.id_besoin = b.id
JOIN categorie c ON b.id_categorie = c.id
WHERE d.quantite > 0
GROUP BY b.id, b.nom, c.nom, b.prix_unitaire
HAVING quantite_restante > 0; 