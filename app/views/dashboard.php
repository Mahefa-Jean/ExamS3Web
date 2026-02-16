<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BNGRC</title>
    <link rel="stylesheet" href="/assets/css/style.css">
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
            max-width: 1200px;
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
        h1 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        h2 {
            color: #34495e;
            margin: 2rem 0 1rem 0;
            border-bottom: 2px solid #3498db;
            padding-bottom: 0.5rem;
        }

        /* ── Statistiques ── */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid #3498db;
        }
        .stat-card h3 {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .stat-card .value {
            color: #2c3e50;
            font-size: 2rem;
            font-weight: bold;
        }

        /* ── Tableau ── */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 1rem;
        }
        thead {
            background-color: #34495e;
            color: white;
        }
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }
        tbody tr:hover {
            background-color: #f9f9f9;
        }
        .action-buttons {
            display: flex;
            gap: 0.5rem;
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
            .site-menu__link:hover,
            .site-menu__link.active {
                border-left-color: transparent;
                border-bottom-color: #3498db;
            }
            .stats {
                grid-template-columns: 1fr;
            }
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <!-- Header : Nom du site -->
    <?php include __DIR__ . '/header.php'; ?>

    <div class="site-wrapper">
        <!-- Menu : sidebar à gauche -->
        <?php $currentPage = 'dashboard'; ?>
        <?php include __DIR__ . '/menu.php'; ?>

        <!-- Contenu : liste de villes -->
        <div class="main-content">
        <div class="container">

        <!-- Tableau des villes -->
        <h2>Liste des villes</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom de la ville</th>
                    <th>Besoin</th>
                    <th>Don</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($villes)): ?>
                    <?php foreach ($villes as $ville): ?>
                        <tr>
                            <td><?= htmlspecialchars($ville['nom']) ?></td>
                            <td><?= htmlspecialchars($ville['besoin']) ?></td>
                            <td><?= htmlspecialchars($ville['don']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: #7f8c8d;">Aucune ville enregistrée</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    </div><!-- /main-content -->
    </div><!-- /site-wrapper -->

    <!-- Footer : ETU -->
    <?php include __DIR__ . '/footer.php'; ?>

    <script src="/assets/js/script.js"></script>
</body>
</html>
