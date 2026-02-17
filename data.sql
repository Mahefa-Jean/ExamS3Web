-- Les catégories sont déjà créées par mysql.sql via INSERT INTO categorie
-- (nature, materiaux, argent)

INSERT INTO ville (nom, nombre_sinistre)
VALUES ('Toamasina', 150);

-- Besoins: nature (id=1), materiaux (id=2), argent (id=3)
INSERT INTO besoin (nom, prix_unitaire, id_categorie)
VALUES ('Riz', 2500.00, 1),
    ('Tente', 35000.00, 2),
    ('Argent', 50000.00, 3);

-- 3 dons, un pour chaque besoin
INSERT INTO don (id_besoin, quantite, date)
VALUES (1, 200, '2026-01-10 08:30:00'),
    (2, 40, '2026-01-15 10:45:00'),
    (3, 10, '2026-01-20 09:00:00');

-- Besoins de Toamasina
INSERT INTO besoinVille (id_ville, id_besoin, quantite, date)
VALUES (1, 1, 100, '2026-01-12 09:00:00'),
    (1, 2, 30, '2026-01-14 11:30:00'),
    (1, 3, 5, '2026-01-16 14:00:00');