<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dons Restants - BNGRC</title>
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
        h2 { color: #34495e; margin: 0 0 1rem 0; border-bottom: 2px solid #27ae60; padding-bottom: 0.5rem; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; margin-top: 1rem; }
        thead { background-color: #27ae60; color: white; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #ecf0f1; }
        tbody tr { transition: background-color 0.2s; }
        tbody tr:hover { background-color: #f9f9f9; }
        tbody tr.hidden { display: none; }
        .btn { padding: 0.6rem 1.2rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: all 0.3s; text-decoration: none; display: inline-block; text-align: center; }
        .btn-secondary { background-color: #95a5a6; color: white; }
        .btn-secondary:hover { background-color: #7f8c8d; }
        .btn-success { background-color: #27ae60; color: white; }
        .badge { padding: 0.25rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600; color: white; }
        .badge-nature { background-color: #3498db; }
        .badge-materiaux { background-color: #e67e22; }
        .badge-argent { background-color: #27ae60; }
        .site-footer { background-color: #1a252f; color: #ecf0f1; text-align: center; padding: 1rem 2rem; }
        .info-card { display: flex; gap: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .info-item { flex: 1; min-width: 200px; padding: 1.2rem; border-radius: 8px; color: white; text-align: center; background: linear-gradient(135deg, #27ae60, #2ecc71); }
        .info-item h3 { font-size: 0.85rem; margin-bottom: 0.5rem; opacity: 0.9; }
        .info-item .montant { font-size: 1.5rem; font-weight: 700; }
        .filter-controls { display: flex; gap: 1rem; margin-bottom: 1.5rem; align-items: center; flex-wrap: wrap; }
        .filter-result { font-size: 0.9rem; color: #7f8c8d; font-style: italic; }
        @media (max-width: 768px) {
            .site-wrapper { flex-direction: column; }
            .site-menu { width: 100%; min-width: 100%; min-height: auto; padding: 0.5rem 0; }
            .site-menu__list { flex-direction: row; flex-wrap: wrap; gap: 0; }
            .site-menu__link { border-left: none; border-bottom: 3px solid transparent; padding: 0.5rem 1rem; font-size: 0.85rem; }
            .info-card { flex-direction: column; }
            .filter-controls { flex-direction: column; }
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/header.php'; ?>

    <div class="site-wrapper">
        <?php $currentPage = 'dons'; ?>
        <?php include __DIR__ . '/menu.php'; ?>

        <div class="main-content">
        <div class="container">

        <!-- Carte récapitulative -->
        <div class="info-card">
            <div class="info-item">
                <h3>📦 Nombre de dons restants</h3>
                <div class="montant"><?= count($donsRestants) ?></div>
            </div>
            <div class="info-item" style="background: linear-gradient(135deg, #2980b9, #3498db);">
                <h3>📊 Total quantités restantes</h3>
                <div class="montant"><?= array_sum(array_column($donsRestants, 'quantite')) ?></div>
            </div>
        </div>

        <!-- Tableau des dons restants -->
        <div class="header">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <h2 style="flex: 1;">📦 Dons Restants (quantité > 0)</h2>
                <a href="<?= BASE_URL ?>/dons" class="btn btn-secondary" style="margin-bottom: 1rem;">← Retour aux dons</a>
            </div>

            <div class="filter-controls">
                <input type="text" id="filterInput" placeholder="🔍 Filtrer par besoin ou catégorie..." style="flex: 1; min-width: 250px; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                <button type="button" id="resetFilter" class="btn" style="background-color: #95a5a6; color: white; display: none;">Réinitialiser</button>
                <span class="filter-result"><span id="resultCount"><?= count($donsRestants) ?></span> don(s) restant(s)</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Besoin</th>
                        <th>Catégorie</th>
                        <th>Quantité restante</th>
                    </tr>
                </thead>
                <tbody id="donsTableBody">
                    <?php if (!empty($donsRestants)): ?>
                        <?php foreach ($donsRestants as $don): ?>
                            <tr class="don-row" data-besoin="<?= strtolower(htmlspecialchars($don['besoin'])) ?>" data-categorie="<?= strtolower($don['categorie']) ?>">
                                <td><?= htmlspecialchars($don['besoin']) ?></td>
                                <td><span class="badge badge-<?= $don['categorie'] ?>"><?= htmlspecialchars(ucfirst($don['categorie'])) ?></span></td>
                                <td style="font-weight: 600; color: #27ae60;"><?= htmlspecialchars($don['quantite']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center; color: #7f8c8d;">Aucun don restant (tous les dons ont été distribués)</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
    </div>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>
    <script nonce="<?= Flight::app()->get('csp_nonce') ?>" src="<?= BASE_URL ?>/assets/js/script.js"></script>

    <script nonce="<?= Flight::app()->get('csp_nonce') ?>">
        const filterInput = document.getElementById('filterInput');
        const resetButton = document.getElementById('resetFilter');
        const resultCount = document.getElementById('resultCount');
        const tableRows = document.querySelectorAll('.don-row');

        filterInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const besoin = row.getAttribute('data-besoin');
                const categorie = row.getAttribute('data-categorie');
                const isVisible = besoin.includes(searchTerm) || categorie.includes(searchTerm) || searchTerm === '';

                if (isVisible) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });

            resultCount.textContent = visibleCount;
            resetButton.style.display = searchTerm ? 'inline-block' : 'none';
        });

        resetButton.addEventListener('click', function() {
            filterInput.value = '';
            filterInput.dispatchEvent(new Event('input'));
        });
    </script>
</body>
</html>
