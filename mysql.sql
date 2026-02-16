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
    FOREIGN KEY (id_ville) REFERENCES ville(id),
    FOREIGN KEY (id_besoin) REFERENCES besoin(id)
); 
