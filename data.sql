-- Les catégories sont déjà créées par mysql.sql via INSERT INTO categorie
-- (nature, materiaux, argent)

INSERT INTO ville (nom, nombre_sinistre)
VALUES ('Antananarivo', 12),
    ('Toamasina', 8),
    ('Mahajanga', 5),
    ('Fianarantsoa', 9),
    ('Toliara', 4);

-- Besoins: nature (id=1), materiaux (id=2), argent (id=3)
INSERT INTO besoin (nom, prix_unitaire, id_categorie)
VALUES ('Riz', 2500.00, 1),
    ('Eau potable', 1000.00, 1),
    ('Médicaments', 5000.00, 1),
    ('Couvertures', 12000.00, 2),
    ('Tentes', 35000.00, 2),
    ('Argent liquide', 50000.00, 3);

INSERT INTO don (id_besoin, quantite, date)
VALUES (1, 200, '2026-01-10 08:30:00'),
    (2, 500, '2026-01-12 14:15:00'),
    (3, 120, '2026-01-15 10:45:00'),
    (4, 80, '2026-01-18 16:20:00'),
    (5, 40, '2026-01-20 09:00:00'),
    (6, 5, '2026-02-05 10:00:00');

INSERT INTO distribution (id_ville, id_besoin, quantite, date)
VALUES (1, 2, 150, '2026-01-22 11:30:00'),
    (2, 1, 180, '2026-01-23 13:45:00'),
    (3, 4, 60, '2026-01-24 09:15:00'),
    (4, 3, 90, '2026-01-25 15:20:00'),
    (5, 2, 110, '2026-01-26 10:30:00'),
    (1, 5, 25, '2026-01-27 14:00:00'),
    (2, 3, 75, '2026-01-28 08:45:00'),
    (3, 1, 200, '2026-01-29 12:15:00'),
    (4, 2, 130, '2026-01-30 16:30:00'),
    (5, 4, 45, '2026-01-31 10:00:00');

INSERT INTO besoinVille (id_ville, id_besoin, quantite_par_sinistre)
VALUES (1, 3, 10),
    (2, 4, 5),
    (3, 2, 20),
    (4, 5, 3),
    (5, 1, 15);

-- Données de test pour les achats (sans ville)
INSERT INTO achat (id_besoin, quantite, frais_pourcent, montant_total, date)
VALUES (1, 100, 10.00, 275000.00, '2026-02-10 09:30:00'),
    (4, 50, 10.00, 660000.00, '2026-02-12 14:15:00'),
    (3, 30, 10.00, 165000.00, '2026-02-14 10:45:00');