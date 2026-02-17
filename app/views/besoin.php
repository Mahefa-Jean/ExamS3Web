<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Besoins - BNGRC</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; color: #333; display: flex; flex-direction: column; min-height: 100vh; }
        .site-header { background: linear-gradient(135deg, #2c3e50, #3498db); color: white; padding: 1.5rem 2rem; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.15); }
        .site-header__title { font-size: 1.6rem; margin-bottom: 0.25rem; }
        .site-wrapper { display: flex; flex: 1; }
        .site-menu { width: 240px; min-width: 240px; background-color: #2c3e50; padding: 1.5rem 0; box-shadow: 2px 0 6px rgba(0,0,0,0.1); min-height: calc(100vh - 120px); }
        .site-menu__title { color: #7f8c8d; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 0 1.5rem; margin-bottom: 0.75rem; }
        .site-menu__list { list-style: none; display: flex; flex-direction: column; gap: 0.15rem; }
        .site-menu__link { display: block; color: #bdc3c7; text-decoration: none; padding: 0.7rem 1.5rem; transition: all 0.25s; border-left: 3px solid transparent; font-size: 0.95rem; }
        .site-menu__link:hover { background-color: rgba(255,255,255,0.08); color: white; border-left-color: #3498db; }
        .site-menu__link.active { background-color: rgba(52, 152, 219, 0.15); color: white; border-left-color: #3498db; font-weight: 600; }
        .main-content { flex: 1; overflow-x: auto; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1.5rem; }
        .header { background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { color: #34495e; margin: 2rem 0 1rem 0; border-bottom: 2px solid #3498db; padding-bottom: 0.5rem; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; margin-top: 1rem; }
        thead { background-color: #34495e; color: white; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #ecf0f1; }
        tbody tr:hover { background-color: #f9f9f9; }
        .action-buttons { display: flex; gap: 0.5rem; }
        .btn { padding: 0.6rem 1.2rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: all 0.3s; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-primary:hover { background-color: #2980b9; }
        .site-footer { background-color: #1a252f; color: #ecf0f1; text-align: center; padding: 1rem 2rem; }
        @media (max-width: 768px) {
            .site-wrapper { flex-direction: column; }
            .site-menu { width: 100%; min-width: 100%; min-height: auto; padding: 0.5rem 0; }
            .site-menu__list { flex-direction: row; flex-wrap: wrap; gap: 0; }
            .site-menu__link { border-left: none; border-bottom: 3px solid transparent; padding: 0.5rem 1rem; font-size: 0.85rem; }
            .action-buttons { flex-direction: column; }
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/header.php'; ?>

    <div class="site-wrapper">
        <?php $currentPage = 'besoins'; ?>
        <?php include __DIR__ . '/menu.php'; ?>

        <div class="main-content">
        <div class="container">

        <!-- Formulaire d'ajout -->
        <div class="header">
            <h2>Ajouter un nouveau besoin</h2>
            <form method="POST" action="<?= BASE_URL ?>/besoins/create" style="display: flex; gap: 1rem; margin-top: 1rem; align-items: center;">
                <input type="text" name="nom" placeholder="Nom du besoin" required style="flex: 1; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                <input type="number" name="prix_unitaire" placeholder="Prix unitaire" required min="0" step="0.01" style="flex: 0.5; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                <select name="id_categorie" required style="flex: 0.5; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="">-- Catégorie --</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars(ucfirst($cat['nom'])) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>

        <!-- Tableau des besoins -->
        <div class="header">
            <h2>Liste des besoins</h2>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Prix unitaire</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($besoins)): ?>
                        <?php foreach ($besoins as $besoin): ?>
                            <tr>
                                <td><?= htmlspecialchars($besoin['id']) ?></td>
                                <td><?= htmlspecialchars($besoin['nom']) ?></td>
                                <td><?= number_format($besoin['prix_unitaire'], 2) ?> Ar</td>
                                <td><span style="padding: 0.25rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600; background-color: <?= $besoin['categorie'] === 'argent' ? '#27ae60' : ($besoin['categorie'] === 'materiaux' ? '#e67e22' : '#3498db') ?>; color: white;"><?= htmlspecialchars(ucfirst($besoin['categorie'])) ?></span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?= BASE_URL ?>/besoins/edit/<?= $besoin['id'] ?>" class="btn btn-primary" style="font-size: 0.8rem; padding: 0.5rem 0.8rem;">Modifier</a>
                                        <a href="<?= BASE_URL ?>/besoins/delete/<?= $besoin['id'] ?>" class="btn" onclick="return confirm('Êtes-vous sûr ?');" style="font-size: 0.8rem; padding: 0.5rem 0.8rem; background-color: #e74c3c; color: white;">Supprimer</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #7f8c8d;">Aucun besoin enregistré</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
    </div>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>
    <script src="<?= BASE_URL ?>/assets/js/script.js"></script>
</body>
</html>
