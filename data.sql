INSERT INTO ville (nom, nombre_sinistre)
VALUES ('Antananarivo', 12),
    ('Toamasina', 8),
    ('Mahajanga', 5),
    ('Fianarantsoa', 9),
    ('Toliara', 4);
INSERT INTO besoin (nom, prix_unitaire)
VALUES ('Riz', 2500.00),
    ('Eau potable', 1000.00),
    ('Médicaments', 5000.00),
    ('Couvertures', 12000.00),
    ('Tentes', 35000.00);
INSERT INTO don (id_besoin, quantite)
VALUES (1, 200),
    (2, 500),
    (3, 120),
    (4, 80),
    (5, 40);
INSERT INTO distribution (id_ville, id_besoin, quantite)
VALUES (1, 2, 150),
    (2, 1, 180),
    (3, 4, 60),
    (4, 3, 90),
    (5, 2, 110);
INSERT INTO besoinVille (id_ville, id_besoin)
VALUES (1, 3),
    (2, 4),
    (3, 2),
    (4, 5),
    (5, 1);