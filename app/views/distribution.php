<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribution - BNGRC</title>
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
        select, input { padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; }
        .alert { padding: 1rem 1.5rem; border-radius: 6px; margin-bottom: 1.5rem; font-weight: 500; }
        .alert-danger { background-color: #fce4e4; color: #c0392b; border: 1px solid #e74c3c; }
        .alert-success { background-color: #d5f5e3; color: #1e8449; border: 1px solid #27ae60; }
        .simulation-box { background: linear-gradient(135deg, #f8f9fa, #e9ecef); border: 2px solid #3498db; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem; }
        .simulation-box h3 { color: #2c3e50; margin-bottom: 1rem; }
        .simulation-detail { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px dashed #bdc3c7; }
        .simulation-detail:last-child { border-bottom: none; }
        .simulation-detail.total { font-weight: 700; font-size: 1.1rem; color: #2c3e50; border-top: 2px solid #34495e; margin-top: 0.5rem; padding-top: 0.75rem; }
        .btn-success { background-color: #27ae60; color: white; }
        .btn-success:hover { background-color: #219a52; }
        .btn-warning { background-color: #e67e22; color: white; }
        .btn-warning:hover { background-color: #d35400; }
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
        <?php $currentPage = 'distribution'; ?>
        <?php include __DIR__ . '/menu.php'; ?>

        <div class="main-content">
        <div class="container">

        <!-- Message d'erreur -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Résultat de simulation -->
        <?php if (!empty($simulation)): ?>
            <div class="simulation-box">
                <h3>📋 Résultat de la Simulation de Distribution</h3>
                <div class="simulation-detail">
                    <span>Ville :</span>
                    <span><strong><?= htmlspecialchars($simulation['ville']['nom']) ?></strong> (<?= $simulation['ville']['nombre_sinistre'] ?> sinistrés)</span>
                </div>
                <div class="simulation-detail">
                    <span>Besoin :</span>
                    <span><?= htmlspecialchars($simulation['besoin']['nom']) ?></span>
                </div>
                <div class="simulation-detail">
                    <span>Quantité à distribuer :</span>
                    <span><?= $simulation['quantite'] ?></span>
                </div>
                <div class="simulation-detail">
                    <span>Prix unitaire :</span>
                    <span><?= number_format($simulation['prix_unitaire'], 2) ?> Ar</span>
                </div>
                <div class="simulation-detail total">
                    <span>Montant total :</span>
                    <span><?= number_format($simulation['montant_total'], 2) ?> Ar</span>
                </div>
                <div class="simulation-detail">
                    <span>Stock disponible avant :</span>
                    <span style="font-weight: 600;"><?= $simulation['stock_disponible'] ?></span>
                </div>
                <div class="simulation-detail">
                    <span>Stock après distribution :</span>
                    <span style="color: <?= $simulation['stock_apres'] > 0 ? '#27ae60' : '#e67e22' ?>; font-weight: 600;">
                        <?= $simulation['stock_apres'] ?>
                    </span>
                </div>

                <div class="alert alert-success" style="margin-top: 1rem;">✅ Distribution possible !</div>
                <form method="POST" action="<?= BASE_URL ?>/distributions/valider" style="margin-top: 1rem;">
                    <input type="hidden" name="id_ville" value="<?= $form_data['id_ville'] ?>">
                    <input type="hidden" name="id_besoin" value="<?= $form_data['id_besoin'] ?>">
                    <input type="hidden" name="quantite" value="<?= $form_data['quantite'] ?>">
                    <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.8rem; font-size: 1rem;">✅ Valider la distribution</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Formulaire de simulation -->
        <div class="header">
            <h2>Simuler une distribution</h2>
            <form method="POST" action="<?= BASE_URL ?>/distributions/simuler" style="display: flex; gap: 1rem; margin-top: 1rem; align-items: center; flex-wrap: wrap;">
                <select name="id_ville" required style="flex: 1; min-width: 150px;">
                    <option value="">-- Choisir une ville --</option>
                    <?php if (!empty($villes)): ?>
                        <?php foreach ($villes as $ville): ?>
                            <option value="<?= $ville['id'] ?>" <?= (isset($form_data) && $form_data['id_ville'] == $ville['id']) ? 'selected' : '' ?>><?= htmlspecialchars($ville['nom']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <select name="id_besoin" id="id_besoin" required style="flex: 1; min-width: 150px;">
                    <option value="" data-stock="0">-- Choisir un besoin --</option>
                    <?php if (!empty($besoins)): ?>
                        <?php foreach ($besoins as $besoin): ?>
                            <?php $qte_restante = $quantites_restantes[$besoin['id']] ?? 0; ?>
                            <option value="<?= $besoin['id'] ?>" data-stock="<?= $qte_restante ?>" <?= (isset($form_data) && $form_data['id_besoin'] == $besoin['id']) ? 'selected' : '' ?>><?= htmlspecialchars($besoin['nom']) ?> (stock: <?= $qte_restante ?>)</option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <input type="number" name="quantite" id="quantite" placeholder="Quantité" required min="1" 
                       value="<?= isset($form_data) ? $form_data['quantite'] : '' ?>"
                       style="flex: 0.5; min-width: 100px; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" class="btn btn-warning">🔍 Simuler</button>
            </form>
            <p id="stockInfo" style="margin-top: 0.75rem; font-size: 0.9rem; color: #7f8c8d; display: none;"></p>
        </div>

        <!-- Tableau des distributions -->
        <div class="header">
            <h2>Liste des distributions</h2>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Ville</th>
                        <th>Besoin</th>
                        <th>Quantité</th>
                        <th>Date</th>
                        <th>Montant total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($distributions)): ?>
                        <?php foreach ($distributions as $dist): ?>
                            <tr>
                                <td><?= htmlspecialchars($dist['id']) ?></td>
                                <td><?= htmlspecialchars($dist['ville']) ?></td>
                                <td><?= htmlspecialchars($dist['besoin']) ?></td>
                                <td><?= htmlspecialchars($dist['quantite']) ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($dist['date']))) ?></td>
                                <td><?= number_format($dist['montant_total'], 2) ?> Ar</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?= BASE_URL ?>/distributions/edit/<?= $dist['id'] ?>" class="btn btn-primary" style="font-size: 0.8rem; padding: 0.5rem 0.8rem;">Modifier</a>
                                        <a href="<?= BASE_URL ?>/distributions/delete/<?= $dist['id'] ?>" class="btn" onclick="return confirm('Êtes-vous sûr ?');" style="font-size: 0.8rem; padding: 0.5rem 0.8rem; background-color: #e74c3c; color: white;">Supprimer</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: #7f8c8d;">Aucune distribution enregistrée</td>
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
        const besoinSelect = document.getElementById('id_besoin');
        const quantiteInput = document.getElementById('quantite');
        const stockInfo = document.getElementById('stockInfo');

        besoinSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;

            if (this.value) {
                if (stock > 0) {
                    stockInfo.innerHTML = '📦 <strong>Stock disponible :</strong> ' + stock + ' unité(s)';
                    stockInfo.style.color = '#27ae60';
                    quantiteInput.max = stock;
                } else {
                    stockInfo.innerHTML = '⚠️ <strong>Aucun don restant</strong> pour ce besoin. Distribution impossible.';
                    stockInfo.style.color = '#e74c3c';
                    quantiteInput.max = 0;
                }
                stockInfo.style.display = 'block';
            } else {
                stockInfo.style.display = 'none';
                quantiteInput.removeAttribute('max');
            }
        });

        quantiteInput.addEventListener('input', function() {
            const selectedOption = besoinSelect.options[besoinSelect.selectedIndex];
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;

            if (besoinSelect.value && parseInt(this.value) > stock) {
                this.style.borderColor = '#e74c3c';
                stockInfo.innerHTML = '❌ Quantité demandée (' + this.value + ') dépasse le stock disponible (' + stock + ')';
                stockInfo.style.color = '#e74c3c';
                stockInfo.style.display = 'block';
            } else if (besoinSelect.value && stock > 0) {
                this.style.borderColor = '#27ae60';
                stockInfo.innerHTML = '📦 <strong>Stock disponible :</strong> ' + stock + ' unité(s)';
                stockInfo.style.color = '#27ae60';
            }
        });
    </script>
</body>
</html>
