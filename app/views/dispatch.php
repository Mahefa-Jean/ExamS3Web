<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispatch des dons - BNGRC</title>
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
        .btn { padding: 0.6rem 1.2rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: all 0.3s; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-primary:hover { background-color: #2980b9; }
        .btn-success { background-color: #27ae60; color: white; }
        .btn-success:hover { background-color: #219a52; }
        .site-footer { background-color: #1a252f; color: #ecf0f1; text-align: center; padding: 1rem 2rem; }
        select, input { padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; }
        .alert { padding: 1rem 1.5rem; border-radius: 6px; margin-bottom: 1.5rem; font-weight: 500; }
        .alert-danger { background-color: #fce4e4; color: #c0392b; border: 1px solid #e74c3c; }
        .alert-success { background-color: #d5f5e3; color: #1e8449; border: 1px solid #27ae60; }
        .dispatch-form { display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; margin-top: 1rem; }
        .dispatch-form select { flex: 1; min-width: 200px; }
        .badge { display: inline-block; padding: 0.25rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600; }
        .badge-nature { background-color: #d5f5e3; color: #1e8449; }
        .badge-materiaux { background-color: #d6eaf8; color: #2471a3; }
        .badge-argent { background-color: #fdebd0; color: #d68910; }
        .dons-restants-box { background: linear-gradient(135deg, #f8f9fa, #e9ecef); border: 2px solid #27ae60; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem; }
        .dons-restants-box h3 { color: #2c3e50; margin-bottom: 1rem; }
        .dons-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
        .don-card { background: white; border-radius: 6px; padding: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-align: center; }
        .don-card .don-nom { font-weight: 600; color: #2c3e50; font-size: 1rem; }
        .don-card .don-qte { font-size: 1.5rem; font-weight: 700; color: #27ae60; margin: 0.5rem 0; }
        .don-card .don-cat { font-size: 0.8rem; color: #7f8c8d; }
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
        <?php $currentPage = 'dispatch'; ?>
        <?php include __DIR__ . '/menu.php'; ?>

        <div class="main-content">
        <div class="container">

        <!-- Message -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $message_type ?? 'danger' ?>">
                <?= $message_type === 'success' ? '✅' : '⚠️' ?> <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Dons restants -->
        <div class="dons-restants-box">
            <h3>📦 Dons restants disponibles</h3>
            <?php if (!empty($dons_restants)): ?>
                <div class="dons-grid">
                    <?php foreach ($dons_restants as $don): ?>
                        <div class="don-card">
                            <div class="don-nom"><?= htmlspecialchars($don['besoin']) ?></div>
                            <div class="don-qte"><?= $don['quantite'] ?></div>
                            <div class="don-cat">
                                <span class="badge badge-<?= $don['categorie'] ?>"><?= htmlspecialchars($don['categorie']) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color: #7f8c8d; text-align: center;">Aucun don restant disponible.</p>
            <?php endif; ?>
        </div>

        <!-- Formulaire de dispatch -->
        <div class="header">
            <h2>🚀 Simuler le dispatch automatique</h2>
            <p style="color: #7f8c8d; margin-bottom: 1rem;">Choisissez une méthode de distribution puis cliquez sur "Simuler" pour voir le résultat. Vous pourrez ensuite valider pour exécuter réellement le dispatch.</p>
            <form method="POST" action="<?= BASE_URL ?>/dispatch/simuler" class="dispatch-form">
                <select name="methode" required>
                    <option value="">-- Choisir une méthode --</option>
                    <option value="date" <?= (isset($methode_choisie) && $methode_choisie === 'date') ? 'selected' : '' ?>>📅 Par ordre de date de saisie</option>
                    <option value="quantite" <?= (isset($methode_choisie) && $methode_choisie === 'quantite') ? 'selected' : '' ?>>📊 Par le plus petit quantité d'abord</option>
                    <option value="proportionnel" <?= (isset($methode_choisie) && $methode_choisie === 'proportionnel') ? 'selected' : '' ?>>⚖️ Proportionnel</option>
                </select>
                <button type="submit" class="btn btn-primary">🔍 Simuler</button>
            </form>
        </div>

        <!-- Résultat de simulation -->
        <?php if (!empty($simulation_results)): ?>
            <div class="header" style="border: 2px solid #3498db;">
                <h2>📋 Résultat de la simulation</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Besoin</th>
                            <th>Qté demandée</th>
                            <th>Qté distribuée</th>
                            <th>Reste</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_montant = 0;
                        foreach ($simulation_results as $sim): 
                            $total_montant += $sim['montant'];
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($sim['ville']) ?></td>
                                <td><?= htmlspecialchars($sim['besoin']) ?></td>
                                <td><?= $sim['quantite_demandee'] ?></td>
                                <td style="color: #27ae60; font-weight: 600;"><?= $sim['quantite_distribuee'] ?></td>
                                <td style="color: <?= $sim['reste'] > 0 ? '#e74c3c' : '#27ae60' ?>; font-weight: 600;"><?= $sim['reste'] ?></td>
                                <td><?= number_format($sim['montant'], 2) ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                        <tr style="background-color: #f8f9fa; font-weight: 700;">
                            <td colspan="5" style="text-align: right;">Total :</td>
                            <td><?= number_format($total_montant, 2) ?> Ar</td>
                        </tr>
                    </tbody>
                </table>
                
                <!-- Bouton Valider -->
                <form method="POST" action="<?= BASE_URL ?>/dispatch/executer" style="margin-top: 1.5rem;">
                    <input type="hidden" name="methode" value="<?= htmlspecialchars($methode_choisie) ?>">
                    <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.8rem; font-size: 1rem;" onclick="return confirm('Confirmer le dispatch ? Les distributions seront créées et les besoins mis à jour.');">✅ Valider le dispatch</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Tableau des besoins de toutes les villes -->
        <div class="header">
            <h2>📋 Besoins de toutes les villes (par date de saisie)</h2>
            <table>
                <thead>
                    <tr>
                        <th>Ville</th>
                        <th>Nb sinistrés</th>
                        <th>Besoin</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Coût total</th>
                        <th>Date de saisie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($besoins_villes)): ?>
                        <?php foreach ($besoins_villes as $bv): ?>
                            <tr>
                                <td><?= htmlspecialchars($bv['ville']) ?></td>
                                <td><?= $bv['nombre_sinistre'] ?></td>
                                <td><?= htmlspecialchars($bv['besoin']) ?></td>
                                <td><strong><?= $bv['quantite'] ?></strong></td>
                                <td><?= number_format($bv['prix_unitaire'], 2) ?> Ar</td>
                                <td><?= number_format($bv['total_prix_besoin'], 2) ?> Ar</td>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($bv['date']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: #7f8c8d;">Aucun besoin enregistré pour les villes</td>
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
</body>
</html>
