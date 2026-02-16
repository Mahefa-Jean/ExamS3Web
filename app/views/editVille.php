<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Ville - BNGRC</title>
    <link rel="stylesheet" href="/assets/css/style.css">
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
        .container { max-width: 800px; margin: 2rem auto; padding: 0 1.5rem; }
        .header { background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { color: #34495e; margin: 0 0 1rem 0; border-bottom: 2px solid #3498db; padding-bottom: 0.5rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2c3e50; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.95rem; }
        .btn { padding: 0.6rem 1.2rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: all 0.3s; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-primary:hover { background-color: #2980b9; }
        .btn-secondary { background-color: #95a5a6; color: white; }
        .btn-secondary:hover { background-color: #7f8c8d; }
        .btn-group { display: flex; gap: 1rem; margin-top: 1rem; }
        .site-footer { background-color: #1a252f; color: #ecf0f1; text-align: center; padding: 1rem 2rem; }
        @media (max-width: 768px) {
            .site-wrapper { flex-direction: column; }
            .site-menu { width: 100%; min-width: 100%; min-height: auto; padding: 0.5rem 0; }
            .site-menu__list { flex-direction: row; flex-wrap: wrap; gap: 0; }
            .site-menu__link { border-left: none; border-bottom: 3px solid transparent; padding: 0.5rem 1rem; font-size: 0.85rem; }
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/header.php'; ?>

    <div class="site-wrapper">
        <?php $currentPage = 'villes'; ?>
        <?php include __DIR__ . '/menu.php'; ?>

        <div class="main-content">
        <div class="container">
            <div class="header">
                <h2>Modifier la ville</h2>
                <form method="POST" action="/villes/update/<?= $ville['id'] ?>">
                    <div class="form-group">
                        <label for="nom">Nom de la ville</label>
                        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($ville['nom']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre_sinistre">Nombre de sinistres</label>
                        <input type="number" id="nombre_sinistre" name="nombre_sinistre" value="<?= htmlspecialchars($ville['nombre_sinistre']) ?>" required min="0">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <a href="/villes" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>
    <script src="/assets/js/script.js"></script>
</body>
</html>
