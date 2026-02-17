<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier besoin - <?= htmlspecialchars($ville['nom']) ?> - BNGRC</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Header ── */
        .site-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .site-header__title {
            font-size: 1.6rem;
            margin-bottom: 0.25rem;
        }
        .site-header__subtitle {
            font-size: 0.9rem;
            opacity: 0.85;
        }

        /* ── Wrapper sidebar + contenu ── */
        .site-wrapper {
            display: flex;
            flex: 1;
        }

        /* ── Menu / Sidebar à gauche ── */
        .site-menu {
            width: 240px;
            min-width: 240px;
            background-color: #2c3e50;
            padding: 1.5rem 0;
            box-shadow: 2px 0 6px rgba(0,0,0,0.1);
            min-height: calc(100vh - 120px);
        }
        .site-menu__title {
            color: #7f8c8d;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 1.5rem;
            margin-bottom: 0.75rem;
        }
        .site-menu__list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }
        .site-menu__link {
            display: block;
            color: #bdc3c7;
            text-decoration: none;
            padding: 0.7rem 1.5rem;
            transition: all 0.25s;
            border-left: 3px solid transparent;
            font-size: 0.95rem;
        }
        .site-menu__link:hover {
            background-color: rgba(255,255,255,0.08);
            color: white;
            border-left-color: #3498db;
        }
        .site-menu__link.active {
            background-color: rgba(52, 152, 219, 0.15);
            color: white;
            border-left-color: #3498db;
            font-weight: 600;
        }

        /* ── Contenu ── */
        .main-content {
            flex: 1;
            overflow-x: auto;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        .header {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            color: #34495e;
            margin: 0 0 1.5rem 0;
            border-bottom: 2px solid #3498db;
            padding-bottom: 0.5rem;
        }

        /* ── Formulaire ── */
        .form-group {
            margin-bottom: 1.2rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            color: #34495e;
        }
        .form-group select,
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.95rem;
        }

        /* ── Boutons ── */
        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-back {
            background-color: #95a5a6;
            color: white;
        }
        .btn-back:hover {
            background-color: #7f8c8d;
        }
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        /* ── Footer ── */
        .site-footer {
            background-color: #1a252f;
            color: #ecf0f1;
            text-align: center;
            padding: 1rem 2rem;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .site-wrapper {
                flex-direction: column;
            }
            .site-menu {
                width: 100%;
                min-width: 100%;
                min-height: auto;
                padding: 0.5rem 0;
            }
            .site-menu__list {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 0;
            }
            .site-menu__link {
                border-left: none;
                border-bottom: 3px solid transparent;
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <?php include __DIR__ . '/header.php'; ?>

    <div class="site-wrapper">
        <!-- Menu -->
        <?php $currentPage = 'villes'; ?>
        <?php include __DIR__ . '/menu.php'; ?>

        <!-- Contenu -->
        <div class="main-content">
        <div class="container">

        <div class="header">
            <h2>Modifier un besoin de : <?= htmlspecialchars($ville['nom']) ?></h2>

            <form method="POST" action="<?= BASE_URL ?>/villes/besoins/<?= $ville['id'] ?>/update/<?= $besoinVille['id'] ?>">
                <div class="form-group">
                    <label for="id_besoin">Besoin</label>
                    <select name="id_besoin" id="id_besoin" required>
                        <?php foreach ($allBesoins as $b): ?>
                            <option value="<?= $b['id'] ?>" <?= $b['id'] == $besoinVille['id_besoin'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($b['nom']) ?> (<?= number_format($b['prix_unitaire'], 2, ',', ' ') ?> Ar)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantite">Quantité</label>
                    <input type="number" name="quantite" id="quantite" value="<?= htmlspecialchars($besoinVille['quantite']) ?>" required min="1">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="<?= BASE_URL ?>/villes/besoins/<?= $ville['id'] ?>" class="btn btn-back">Annuler</a>
                </div>
            </form>
        </div>

    </div>
    </div><!-- /main-content -->
    </div><!-- /site-wrapper -->

    <!-- Footer -->
    <?php include __DIR__ . '/footer.php'; ?>

    <script src="<?= BASE_URL ?>/assets/js/script.js"></script>
</body>
</html>
