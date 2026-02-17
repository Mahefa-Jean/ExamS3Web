<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achats - BNGRC</title>
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
        tbody tr { transition: background-color 0.2s; }
        tbody tr:hover { background-color: #f9f9f9; }
        tbody tr.hidden { display: none; }
        .action-buttons { display: flex; gap: 0.5rem; }
        .btn { padding: 0.6rem 1.2rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: all 0.3s; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-primary:hover { background-color: #2980b9; }
        .btn-success { background-color: #27ae60; color: white; }
        .btn-success:hover { background-color: #219a52; }
        .btn-warning { background-color: #e67e22; color: white; }
        .btn-warning:hover { background-color: #d35400; }
        .btn-danger { background-color: #e74c3c; color: white; }
        .btn-danger:hover { background-color: #c0392b; }
        .site-footer { background-color: #1a252f; color: #ecf0f1; text-align: center; padding: 1rem 2rem; }
        select, input { padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; }
        .solde-card { display: flex; gap: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .solde-item { flex: 1; min-width: 200px; padding: 1.2rem; border-radius: 8px; color: white; text-align: center; }
        .solde-item h3 { font-size: 0.85rem; margin-bottom: 0.5rem; opacity: 0.9; }
        .solde-item .montant { font-size: 1.5rem; font-weight: 700; }
        .alert { padding: 1rem 1.5rem; border-radius: 6px; margin-bottom: 1.5rem; font-weight: 500; }
        .alert-danger { background-color: #fce4e4; color: #c0392b; border: 1px solid #e74c3c; }
        .alert-success { background-color: #d5f5e3; color: #1e8449; border: 1px solid #27ae60; }
        .alert-warning { background-color: #fef9e7; color: #b7950b; border: 1px solid #f1c40f; }
        .simulation-box { background: linear-gradient(135deg, #f8f9fa, #e9ecef); border: 2px solid #3498db; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem; }
        .simulation-box h3 { color: #2c3e50; margin-bottom: 1rem; }
        .simulation-detail { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px dashed #bdc3c7; }
        .simulation-detail:last-child { border-bottom: none; }
        .simulation-detail.total { font-weight: 700; font-size: 1.1rem; color: #2c3e50; border-top: 2px solid #34495e; margin-top: 0.5rem; padding-top: 0.75rem; }
        .badge { padding: 0.25rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600; color: white; }
        .badge-nature { background-color: #3498db; }
        .badge-materiaux { background-color: #e67e22; }
        .filter-controls { display: flex; gap: 1rem; margin-bottom: 1.5rem; align-items: center; flex-wrap: wrap; }
        .filter-result { font-size: 0.9rem; color: #7f8c8d; font-style: italic; }
        @media (max-width: 768px) {
            .site-wrapper { flex-direction: column; }
            .site-menu { width: 100%; min-width: 100%; min-height: auto; padding: 0.5rem 0; }
            .site-menu__list { flex-direction: row; flex-wrap: wrap; gap: 0; }
            .site-menu__link { border-left: none; border-bottom: 3px solid transparent; padding: 0.5rem 1rem; font-size: 0.85rem; }
            .action-buttons { flex-direction: column; }
            .solde-card { flex-direction: column; }
            .filter-controls { flex-direction: column; }
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/header.php'; ?>

    <div class="site-wrapper">
        <?php $currentPage = 'achats'; ?>
        <?php include __DIR__ . '/menu.php'; ?>

        <div class="main-content">
        <div class="container">

        <!-- Cartes solde -->
        <div class="solde-card">
            <div class="solde-item" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">
                <h3>💰 Total Dons en Argent</h3>
                <div class="montant"><?= number_format($total_dons_argent, 2) ?> Ar</div>
            </div>
            <div class="solde-item" style="background: linear-gradient(135deg, #e67e22, #f39c12);">
                <h3>🛒 Total Achats Effectués</h3>
                <div class="montant"><?= number_format($total_achats, 2) ?> Ar</div>
            </div>
            <div class="solde-item" style="background: linear-gradient(135deg, <?= $solde_disponible >= 0 ? '#2980b9, #3498db' : '#c0392b, #e74c3c' ?>);">
                <h3>💳 Solde Disponible</h3>
                <div class="montant"><?= number_format($solde_disponible, 2) ?> Ar</div>
            </div>
        </div>

        <!-- Message d'erreur -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Résultat de simulation -->
        <?php if (!empty($simulation)): ?>
            <div class="simulation-box">
                <h3>📋 Résultat de la Simulation</h3>
                <div class="simulation-detail">
                    <span>Besoin :</span>
                    <span><?= htmlspecialchars($simulation['besoin']['nom']) ?> <span class="badge badge-<?= $simulation['besoin']['categorie'] ?? '' ?>"><?= htmlspecialchars(ucfirst($simulation['besoin']['categorie'] ?? '')) ?></span></span>
                </div>
                <div class="simulation-detail">
                    <span>Quantité :</span>
                    <span><?= $simulation['quantite'] ?></span>
                </div>
                <div class="simulation-detail">
                    <span>Prix unitaire :</span>
                    <span><?= number_format($simulation['prix_unitaire'], 2) ?> Ar</span>
                </div>
                <div class="simulation-detail">
                    <span>Sous-total :</span>
                    <span><?= number_format($simulation['sous_total'], 2) ?> Ar</span>
                </div>
                <div class="simulation-detail">
                    <span>Frais (<?= $simulation['frais_pourcent'] ?>%) :</span>
                    <span style="color: #e67e22;"><?= number_format($simulation['frais'], 2) ?> Ar</span>
                </div>
                <div class="simulation-detail total">
                    <span>Montant Total :</span>
                    <span><?= number_format($simulation['montant_total'], 2) ?> Ar</span>
                </div>
                <div class="simulation-detail">
                    <span>Solde après achat :</span>
                    <span style="color: <?= $simulation['solde_apres_achat'] >= 0 ? '#27ae60' : '#e74c3c' ?>; font-weight: 600;">
                        <?= number_format($simulation['solde_apres_achat'], 2) ?> Ar
                    </span>
                </div>

                <?php if ($simulation['achat_possible']): ?>
                    <div class="alert alert-success" style="margin-top: 1rem;">✅ Achat possible ! Le solde est suffisant.</div>
                    <form method="POST" action="<?= BASE_URL ?>/achats/valider" style="margin-top: 1rem;">
                        <input type="hidden" name="id_besoin" value="<?= $form_data['id_besoin'] ?>">
                        <input type="hidden" name="quantite" value="<?= $form_data['quantite'] ?>">
                        <input type="hidden" name="frais_pourcent" value="<?= $form_data['frais_pourcent'] ?>">
                        <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.8rem; font-size: 1rem;">✅ Valider l'achat</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-danger" style="margin-top: 1rem;">❌ Achat impossible ! Solde insuffisant.</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire d'achat / simulation -->
        <div class="header">
            <h2>🛒 Nouvel Achat (via dons en argent)</h2>
            <form method="POST" action="<?= BASE_URL ?>/achats/simuler" style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
                    <div style="flex: 1; min-width: 200px;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2c3e50;">Besoin (nature/matériaux)</label>
                        <select name="id_besoin" required>
                            <option value="">-- Choisir un besoin --</option>
                            <?php if (!empty($besoins)): ?>
                                <?php foreach ($besoins as $besoin): ?>
                                    <option value="<?= $besoin['id'] ?>" <?= (isset($form_data) && $form_data['id_besoin'] == $besoin['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($besoin['nom']) ?> (<?= number_format($besoin['prix_unitaire'], 2) ?> Ar) [<?= ucfirst($besoin['categorie']) ?>]
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div style="flex: 0.3; min-width: 100px;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2c3e50;">Quantité</label>
                        <input type="number" name="quantite" placeholder="Qté" required min="1" 
                               value="<?= isset($form_data) ? $form_data['quantite'] : '' ?>">
                    </div>
                    <div style="flex: 0.3; min-width: 100px;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2c3e50;">Frais %</label>
                        <input type="number" name="frais_pourcent" placeholder="%" required min="0" step="0.01" 
                               value="<?= isset($form_data) ? $form_data['frais_pourcent'] : '10' ?>">
                    </div>
                    <button type="submit" class="btn btn-warning">🔍 Simuler</button>
                </div>
            </form>
        </div>

        <!-- Filtre par besoin / catégorie -->
        <div class="header">
            <h2>📋 Liste des achats</h2>
            <div class="filter-controls">
                <input type="text" id="filterInput" placeholder="🔍 Filtrer par nom besoin, catégorie..." style="flex: 1; min-width: 250px;">
                <button type="button" id="resetFilter" class="btn" style="background-color: #95a5a6; color: white; display: none;">Réinitialiser</button>
                <span class="filter-result"><span id="resultCount"><?= count($achats) ?></span> achat(s) trouvé(s)</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Besoin</th>
                        <th>Catégorie</th>
                        <th>Qté</th>
                        <th>P.U.</th>
                        <th>Sous-total</th>
                        <th>Frais %</th>
                        <th>Montant Total</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="achatTableBody">
                    <?php if (!empty($achats)): ?>
                        <?php foreach ($achats as $achat): ?>
                            <tr class="achat-row" data-besoin="<?= strtolower(htmlspecialchars($achat['besoin'])) ?>" data-categorie="<?= strtolower($achat['categorie']) ?>">
                                <td><?= htmlspecialchars($achat['id']) ?></td>
                                <td><?= htmlspecialchars($achat['besoin']) ?></td>
                                <td><span class="badge badge-<?= $achat['categorie'] ?>"><?= htmlspecialchars(ucfirst($achat['categorie'])) ?></span></td>
                                <td><?= htmlspecialchars($achat['quantite']) ?></td>
                                <td><?= number_format($achat['prix_unitaire'], 2) ?> Ar</td>
                                <td><?= number_format($achat['sous_total'], 2) ?> Ar</td>
                                <td><?= number_format($achat['frais_pourcent'], 2) ?>%</td>
                                <td style="font-weight: 600; color: #2c3e50;"><?= number_format($achat['montant_total'], 2) ?> Ar</td>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($achat['date']))) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?= BASE_URL ?>/achats/delete/<?= $achat['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet achat ?');" style="font-size: 0.8rem; padding: 0.5rem 0.8rem;">Supprimer</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="noResultRow">
                            <td colspan="10" style="text-align: center; color: #7f8c8d;">Aucun achat enregistré</td>
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
        const tableRows = document.querySelectorAll('.achat-row');

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

            // Afficher/masquer message "aucun résultat"
            const noResultRow = document.getElementById('noResultRow');
            if (noResultRow) {
                noResultRow.style.display = visibleCount === 0 && tableRows.length > 0 ? 'table-row' : 'none';
            }
        });

        resetButton.addEventListener('click', function() {
            filterInput.value = '';
            filterInput.dispatchEvent(new Event('input'));
        });
    </script>
</body>
</html>
