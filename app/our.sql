-- =============================================
-- Script d'insertion des données initiales
-- Prérequis : mysql.sql doit être exécuté avant
-- Catégories existantes : 1=nature, 2=materiaux, 3=argent
-- =============================================

-- =============================================
-- 1. Villes
-- =============================================
INSERT INTO ville (nom, nombre_sinistre) VALUES
    ('Toamasina',   0),   -- id = 1
    ('Mananjary',   0),   -- id = 2
    ('Farafangana', 0),   -- id = 3
    ('Nosy Be',     0),   -- id = 4
    ('Morondava',   0);   -- id = 5

-- =============================================
-- 2. Besoins (produits)
-- =============================================
-- Nature (id_categorie = 1)
INSERT INTO besoin (nom, prix_unitaire, id_categorie) VALUES
    ('Riz (kg)',    3000.00,    1),   -- id = 1
    ('Eau (L)',     1000.00,    1),   -- id = 2
    ('Huile (L)',   6000.00,    1),   -- id = 3
    ('Haricots',    4000.00,    1);   -- id = 4

-- Materiaux (id_categorie = 2)
INSERT INTO besoin (nom, prix_unitaire, id_categorie) VALUES
    ('Tôle',        25000.00,   2),   -- id = 5
    ('Bâche',       15000.00,   2),   -- id = 6
    ('Clous (kg)',  8000.00,    2),   -- id = 7
    ('Bois',        10000.00,   2),   -- id = 8
    ('groupe',      6750000.00, 2);   -- id = 9

-- Argent (id_categorie = 3)
INSERT INTO besoin (nom, prix_unitaire, id_categorie) VALUES
    ('Argent',      1.00,       3);   -- id = 10

-- =============================================
-- 3. Besoins par ville (table besoinVille)
-- =============================================
-- Villes  : 1=Toamasina, 2=Mananjary, 3=Farafangana, 4=Nosy Be, 5=Morondava
-- Besoins : 1=Riz (kg), 2=Eau (L), 3=Huile (L), 4=Haricots,
--           5=Tôle, 6=Bâche, 7=Clous (kg), 8=Bois, 9=groupe, 10=Argent

INSERT INTO besoinVille (id_ville, id_besoin, quantite, date) VALUES
    -- Ordre 1  : Toamasina - Bâche - 200
    (1, 6,  200,      '2026-02-15 00:00:00'),
    -- Ordre 2  : Nosy Be - Tôle - 40
    (4, 5,  40,       '2026-02-15 00:00:00'),
    -- Ordre 3  : Mananjary - Argent - 6000000
    (2, 10, 6000000,  '2026-02-15 00:00:00'),
    -- Ordre 4  : Toamasina - Eau (L) - 1500
    (1, 2,  1500,     '2026-02-15 00:00:00'),
    -- Ordre 5  : Nosy Be - Riz (kg) - 300
    (4, 1,  300,      '2026-02-15 00:00:00'),
    -- Ordre 6  : Mananjary - Tôle - 80
    (2, 5,  80,       '2026-02-15 00:00:00'),
    -- Ordre 7  : Nosy Be - Argent - 4000000
    (4, 10, 4000000,  '2026-02-15 00:00:00'),
    -- Ordre 8  : Farafangana - Bâche - 150
    (3, 6,  150,      '2026-02-16 00:00:00'),
    -- Ordre 9  : Mananjary - Riz (kg) - 500
    (2, 1,  500,      '2026-02-15 00:00:00'),
    -- Ordre 10 : Farafangana - Argent - 8000000
    (3, 10, 8000000,  '2026-02-16 00:00:00'),
    -- Ordre 11 : Morondava - Riz (kg) - 700
    (5, 1,  700,      '2026-02-16 00:00:00'),
    -- Ordre 12 : Toamasina - Argent - 12000000
    (1, 10, 12000000, '2026-02-16 00:00:00'),
    -- Ordre 13 : Morondava - Argent - 10000000
    (5, 10, 10000000, '2026-02-16 00:00:00'),
    -- Ordre 14 : Farafangana - Eau (L) - 1000
    (3, 2,  1000,     '2026-02-15 00:00:00'),
    -- Ordre 15 : Morondava - Bâche - 180
    (5, 6,  180,      '2026-02-16 00:00:00'),
    -- Ordre 16 : Toamasina - groupe - 3
    (1, 9,  3,        '2026-02-15 00:00:00'),
    -- Ordre 17 : Toamasina - Riz (kg) - 800
    (1, 1,  800,      '2026-02-16 00:00:00'),
    -- Ordre 18 : Nosy Be - Haricots - 200
    (4, 4,  200,      '2026-02-16 00:00:00'),
    -- Ordre 19 : Mananjary - Clous (kg) - 60
    (2, 7,  60,       '2026-02-16 00:00:00'),
    -- Ordre 20 : Morondava - Eau (L) - 1200
    (5, 2,  1200,     '2026-02-15 00:00:00'),
    -- Ordre 21 : Farafangana - Riz (kg) - 600
    (3, 1,  600,      '2026-02-16 00:00:00'),
    -- Ordre 22 : Morondava - Bois - 150
    (5, 8,  150,      '2026-02-15 00:00:00'),
    -- Ordre 23 : Toamasina - Tôle - 120
    (1, 5,  120,      '2026-02-16 00:00:00'),
    -- Ordre 24 : Nosy Be - Clous (kg) - 30
    (4, 7,  30,       '2026-02-16 00:00:00'),
    -- Ordre 25 : Mananjary - Huile (L) - 120
    (2, 3,  120,      '2026-02-16 00:00:00'),
    -- Ordre 26 : Farafangana - Bois - 100
    (3, 8,  100,      '2026-02-15 00:00:00');

-- =============================================
-- 4. Dons reçus (table don)
-- =============================================
INSERT INTO don (id_besoin, quantite, date) VALUES
    (10, 5000000,  '2026-02-16 00:00:00'),   -- Argent      5 000 000
    (10, 3000000,  '2026-02-16 00:00:00'),   -- Argent      3 000 000
    (10, 4000000,  '2026-02-17 00:00:00'),   -- Argent      4 000 000
    (10, 1500000,  '2026-02-17 00:00:00'),   -- Argent      1 500 000
    (10, 6000000,  '2026-02-17 00:00:00'),   -- Argent      6 000 000
    (1,  400,      '2026-02-16 00:00:00'),   -- Riz (kg)    400
    (2,  600,      '2026-02-16 00:00:00'),   -- Eau (L)     600
    (5,  50,       '2026-02-17 00:00:00'),   -- Tôle        50
    (6,  70,       '2026-02-17 00:00:00'),   -- Bâche       70
    (4,  100,      '2026-02-17 00:00:00'),   -- Haricots    100
    (1,  2000,     '2026-02-18 00:00:00'),   -- Riz (kg)    2 000
    (5,  300,      '2026-02-18 00:00:00'),   -- Tôle        300
    (2,  5000,     '2026-02-18 00:00:00'),   -- Eau (L)     5 000
    (10, 20000000, '2026-02-19 00:00:00'),   -- Argent      20 000 000
    (6,  500,      '2026-02-19 00:00:00'),   -- Bâche       500
    (4,  88,       '2026-02-17 00:00:00');    -- Haricots    88
