<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Besoins de <?= htmlspecialchars($ville['nom']) ?> - BNGRC</title>
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
        }
    </style>
</head>
<body>

    <!-- Header : Nom du site -->
    <?php include __DIR__ . '/header.php'; ?>

    <div class="site-wrapper">
        <!-- Menu : sidebar à gauche -->
        <?php $currentPage = 'villes'; ?>
        <?php include __DIR__ . '/menu.php'; ?>

        <!-- Contenu : besoins de la ville -->
        <div class="main-content">
        <div class="container">

        <!-- Info ville -->
        <div class="header">
            <a href="<?= BASE_URL ?>/villes" class="btn btn-back" style="margin-bottom: 1rem;">← Retour aux villes</a>
            <h2>Besoins de la ville : <?= htmlspecialchars($ville['nom']) ?></h2>
            <p>Nombre de sinistrés : <strong><?= htmlspecialchars($ville['nombre_sinistre']) ?></strong></p>
        </div>

        <!-- Formulaire d'ajout -->
        <div class="header">
            <h2>Ajouter un besoin à cette ville</h2>
            <form method="POST" action="<?= BASE_URL ?>/villes/besoins/<?= $ville['id'] ?>/create" style="display: flex; gap: 1rem; margin-top: 1rem; align-items: flex-end;">
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 0.3rem; font-weight: 600;">Besoin</label>
                    <select name="id_besoin" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">-- Choisir un besoin --</option>
                        <?php foreach ($allBesoins as $b): ?>
                            <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['nom']) ?> (<?= number_format($b['prix_unitaire'], 2, ',', ' ') ?> Ar)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="flex: 0.5;">
                    <label style="display: block; margin-bottom: 0.3rem; font-weight: 600;">Quantité</label>
                    <input type="number" name="quantite" placeholder="Quantité" required min="1" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>

        <!-- Tableau des besoins -->
        <div class="header">
            <h2>Liste des besoins</h2>
            <table>
                <thead>
                    <tr>
                        <th>Besoin</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Total prix besoin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($besoins)): ?>
                        <?php 
                            $totalGeneral = 0;
                            foreach ($besoins as $besoin): 
                                $totalGeneral += $besoin['total_prix_besoin'];
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($besoin['besoin']) ?></td>
                                <td><?= number_format($besoin['prix_unitaire'], 2, ',', ' ') ?> Ar</td>
                                <td><?= htmlspecialchars($besoin['quantite']) ?></td>
                                <td><?= number_format($besoin['total_prix_besoin'], 2, ',', ' ') ?> Ar</td>
                                <td>
                                    <div class="action-buttons" style="display: flex; gap: 0.5rem;">
                                        <a href="<?= BASE_URL ?>/villes/besoins/<?= $ville['id'] ?>/edit/<?= $besoin['id'] ?>" class="btn btn-primary" style="font-size: 0.8rem; padding: 0.5rem 0.8rem;">Modifier</a>
                                        <a href="<?= BASE_URL ?>/villes/besoins/<?= $ville['id'] ?>/delete/<?= $besoin['id'] ?>" class="btn" onclick="return confirm('Êtes-vous sûr ?');" style="font-size: 0.8rem; padding: 0.5rem 0.8rem; background-color: #e74c3c; color: white;">Supprimer</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr style="background-color: #eaf2f8; font-weight: bold;">
                            <td colspan="4" style="text-align: right;">Total général :</td>
                            <td><?= number_format($totalGeneral, 2, ',', ' ') ?> Ar</td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #7f8c8d;">Aucun besoin enregistré pour cette ville</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div><!-- /main-content -->
    </div><!-- /site-wrapper -->

    <!-- Footer : ETU -->
    <?php include __DIR__ . '/footer.php'; ?>

    <script src="<?= BASE_URL ?>/assets/js/script.js"></script>
</body>
</html>
