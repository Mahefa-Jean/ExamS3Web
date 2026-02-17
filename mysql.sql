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
    id_ville INT,
    id_besoin INT NOT NULL,
    quantite INT NOT NULL,
    frais_pourcent DECIMAL(5, 2) NOT NULL DEFAULT 10.00,
    montant_total DECIMAL(10, 2) NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ville) REFERENCES ville(id),
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
    SUM(montant_total) as montant_total_ville
FROM V_distribution_detaillee
GROUP BY id_ville; 

CREATE OR REPLACE VIEW V_besoin_ville_detail AS
<<<<<<< HEAD
SELECT
    bv.id_ville as id_ville,
    bv.id_besoin as id_besoin,
    b.nom as besoin,
    b.prix_unitaire as prix_unitaire,
    bv.quantite_par_sinistre as quantite_par_sinistre,
    v.nombre_sinistre as nombre_sinistre,
    (b.prix_unitaire * bv.quantite_par_sinistre * v.nombre_sinistre) as total_prix_besoin
=======
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
>>>>>>> origin/main
FROM besoinVille bv
JOIN besoin b ON bv.id_besoin = b.id
JOIN ville v ON bv.id_ville = v.id;

CREATE OR REPLACE VIEW V_somme_besoin_par_ville AS
SELECT
    id_ville,
    COALESCE(SUM(total_prix_besoin), 0) as montant_total_besoin
FROM V_besoin_ville_detail
<<<<<<< HEAD
GROUP BY id_ville;
=======
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

CREATE OR REPLACE VIEW V_achat_detaillee AS
SELECT 
    a.id,
    v.id as id_ville,
    v.nom as ville,
    b.nom as besoin,
    c.nom as categorie,
    a.quantite,
    b.prix_unitaire,
    (a.quantite * b.prix_unitaire) as sous_total,
    a.frais_pourcent,
    a.montant_total,
    a.date
FROM achat a
JOIN besoin b ON a.id_besoin = b.id
JOIN categorie c ON b.id_categorie = c.id
LEFT JOIN ville v ON a.id_ville = v.id;
>>>>>>> origin/main
