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
INSERT INTO don (id_besoin, quantite, date)
VALUES (1, 200, '2026-01-10 08:30:00'),
    (2, 500, '2026-01-12 14:15:00'),
    (3, 120, '2026-01-15 10:45:00'),
    (4, 80, '2026-01-18 16:20:00'),
    (5, 40, '2026-01-20 09:00:00');
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