<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulation - BNGRC</title>
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
        .header-block { background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { color: #34495e; margin: 0 0 1rem 0; border-bottom: 2px solid #3498db; padding-bottom: 0.5rem; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; margin-top: 1rem; }
        thead { background-color: #34495e; color: white; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #ecf0f1; }
        tbody tr { transition: background-color 0.2s; }
        tbody tr:hover { background-color: #f9f9f9; }
        .btn { padding: 0.6rem 1.2rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: all 0.3s; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-primary:hover { background-color: #2980b9; }
        .site-footer { background-color: #1a252f; color: #ecf0f1; text-align: center; padding: 1rem 2rem; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { padding: 1.5rem; border-radius: 8px; color: white; text-align: center; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card h3 { font-size: 0.85rem; margin-bottom: 0.5rem; opacity: 0.9; }
        .stat-card .value { font-size: 1.8rem; font-weight: 700; }
        .stat-card .sub { font-size: 0.8rem; opacity: 0.8; margin-top: 0.25rem; }

        .progress-container { background: #ecf0f1; border-radius: 10px; overflow: hidden; height: 30px; margin: 1rem 0; }
        .progress-bar { height: 100%; border-radius: 10px; transition: width 0.8s ease; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem; }

        .loading { text-align: center; padding: 2rem; color: #7f8c8d; }
        .loading .spinner { display: inline-block; width: 30px; height: 30px; border: 3px solid #ecf0f1; border-top-color: #3498db; border-radius: 50%; animation: spin 0.8s linear infinite; margin-right: 0.5rem; vertical-align: middle; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .last-update { font-size: 0.85rem; color: #95a5a6; font-style: italic; }

        @media (max-width: 768px) {
            .site-wrapper { flex-direction: column; }
            .site-menu { width: 100%; min-width: 100%; min-height: auto; padding: 0.5rem 0; }
            .site-menu__list { flex-direction: row; flex-wrap: wrap; gap: 0; }
            .site-menu__link { border-left: none; border-bottom: 3px solid transparent; padding: 0.5rem 1rem; font-size: 0.85rem; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/header.php'; ?>

    <div class="site-wrapper">
        <?php $currentPage = 'recapitulatif'; ?>
        <?php include __DIR__ . '/menu.php'; ?>

        <div class="main-content">
        <div class="container">

        <!-- Titre + bouton actualiser -->
        <div class="header-block">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <h2 style="flex: 1; border: none; margin: 0;">📊 Récapitulation Générale</h2>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span class="last-update" id="lastUpdate"></span>
                    <button type="button" class="btn btn-primary" id="btnActualiser" onclick="actualiserDonnees()">🔄 Actualiser</button>
                </div>
            </div>
        </div>

        <!-- Chargement initial -->
        <div id="loadingIndicator" class="loading">
            <span class="spinner"></span> Chargement des données...
        </div>

        <!-- Contenu dynamique -->
        <div id="recapContent" style="display: none;">

            <!-- Cartes statistiques -->
            <div class="stats-grid" id="statsGrid">
                <div class="stat-card" style="background: linear-gradient(135deg, #2980b9, #3498db);">
                    <h3>📋 Besoins Totaux</h3>
                    <div class="value" id="besoinsTotal">-</div>
                    <div class="sub">Montant total des besoins</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">
                    <h3>✅ Besoins Satisfaits</h3>
                    <div class="value" id="besoinsSatisfaits">-</div>
                    <div class="sub">Montant distribué</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                    <h3>⏳ Besoins Restants</h3>
                    <div class="value" id="besoinsRestants">-</div>
                    <div class="sub">Reste à couvrir</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #8e44ad, #9b59b6);">
                    <h3>📈 Taux de Couverture</h3>
                    <div class="value" id="tauxCouverture">-</div>
                    <div class="sub">des besoins satisfaits</div>
                </div>
            </div>

            <!-- Barre de progression -->
            <div class="header-block">
                <h2>Progression globale</h2>
                <div class="progress-container">
                    <div class="progress-bar" id="progressBar" style="width: 0%; background: linear-gradient(90deg, #27ae60, #2ecc71);">0%</div>
                </div>
            </div>

            <!-- Cartes finances -->
            <div class="stats-grid">
                <div class="stat-card" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
                    <h3>💰 Dons en Argent</h3>
                    <div class="value" id="totalDonsArgent">-</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #e67e22, #d35400);">
                    <h3>🛒 Total Achats</h3>
                    <div class="value" id="totalAchats">-</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #1abc9c, #16a085);">
                    <h3>💳 Solde Argent</h3>
                    <div class="value" id="soldeArgent">-</div>
                </div>
            </div>

            <!-- Dons restants -->
            <div class="header-block">
                <h2>📦 Dons Restants (disponibles pour distribution)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Besoin</th>
                            <th>Catégorie</th>
                            <th>Quantité restante</th>
                        </tr>
                    </thead>
                    <tbody id="donsRestantsBody">
                        <tr><td colspan="3" style="text-align: center; color: #7f8c8d;">Chargement...</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Détail par ville -->
            <div class="header-block">
                <h2>🏙️ Détail par Ville</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Sinistrés</th>
                            <th>Besoins (montant)</th>
                            <th>Distribué (montant)</th>
                            <th>Reste</th>
                            <th>Taux</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody id="villesBody">
                        <tr><td colspan="7" style="text-align: center; color: #7f8c8d;">Chargement...</td></tr>
                    </tbody>
                </table>
            </div>

        </div><!-- /recapContent -->

    </div>
    </div>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>
    <script nonce="<?= Flight::app()->get('csp_nonce') ?>" src="<?= BASE_URL ?>/assets/js/script.js"></script>

    <script nonce="<?= Flight::app()->get('csp_nonce') ?>">
        const BASE = '<?= BASE_URL ?>';

        function formatMontant(val) {
            return parseFloat(val).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' Ar';
        }

        function getBadgeClass(categorie) {
            const colors = { nature: '#3498db', materiaux: '#e67e22', argent: '#27ae60' };
            return colors[categorie] || '#95a5a6';
        }

        function actualiserDonnees() {
            const btn = document.getElementById('btnActualiser');
            btn.disabled = true;
            btn.innerHTML = '⏳ Chargement...';

            fetch(BASE + '/recapitulatif/data')
                .then(response => response.json())
                .then(data => {
                    // Cartes statistiques
                    document.getElementById('besoinsTotal').textContent = formatMontant(data.besoins_total);
                    document.getElementById('besoinsSatisfaits').textContent = formatMontant(data.besoins_satisfaits);
                    document.getElementById('besoinsRestants').textContent = formatMontant(data.besoins_restants);
                    document.getElementById('tauxCouverture').textContent = data.taux_couverture + '%';

                    // Barre de progression
                    const progressBar = document.getElementById('progressBar');
                    const taux = Math.min(data.taux_couverture, 100);
                    progressBar.style.width = taux + '%';
                    progressBar.textContent = data.taux_couverture + '%';
                    if (taux >= 80) {
                        progressBar.style.background = 'linear-gradient(90deg, #27ae60, #2ecc71)';
                    } else if (taux >= 50) {
                        progressBar.style.background = 'linear-gradient(90deg, #f39c12, #e67e22)';
                    } else {
                        progressBar.style.background = 'linear-gradient(90deg, #e74c3c, #c0392b)';
                    }

                    // Finances
                    document.getElementById('totalDonsArgent').textContent = formatMontant(data.total_dons_argent);
                    document.getElementById('totalAchats').textContent = formatMontant(data.total_achats);
                    document.getElementById('soldeArgent').textContent = formatMontant(data.solde_argent);

                    // Dons restants
                    const donsBody = document.getElementById('donsRestantsBody');
                    if (data.dons_restants.length > 0) {
                        donsBody.innerHTML = data.dons_restants.map(don => 
                            '<tr>' +
                                '<td>' + don.besoin + '</td>' +
                                '<td><span style="padding: 0.25rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600; color: white; background-color: ' + getBadgeClass(don.categorie) + ';">' + don.categorie.charAt(0).toUpperCase() + don.categorie.slice(1) + '</span></td>' +
                                '<td style="font-weight: 600; color: #27ae60;">' + don.quantite + '</td>' +
                            '</tr>'
                        ).join('');
                    } else {
                        donsBody.innerHTML = '<tr><td colspan="3" style="text-align: center; color: #7f8c8d;">Aucun don restant</td></tr>';
                    }

                    // Détail par ville
                    const villesBody = document.getElementById('villesBody');
                    if (data.villes.length > 0) {
                        villesBody.innerHTML = data.villes.map(ville => {
                            let statut;
                            if (ville.taux >= 100) {
                                statut = '<span style="background-color: #d5f5e3; color: #1e8449; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">✅ Couverte</span>';
                            } else if (ville.taux >= 50) {
                                statut = '<span style="background-color: #fef9e7; color: #b7950b; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">⚠️ Partielle</span>';
                            } else {
                                statut = '<span style="background-color: #fce4e4; color: #c0392b; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">❌ Non couverte</span>';
                            }

                            return '<tr>' +
                                '<td><strong>' + ville.nom + '</strong></td>' +
                                '<td>' + ville.nombre_sinistre + '</td>' +
                                '<td>' + formatMontant(ville.total_besoins) + '</td>' +
                                '<td>' + formatMontant(ville.total_distribue) + '</td>' +
                                '<td style="color: ' + (ville.reste <= 0 ? '#27ae60' : '#e74c3c') + '; font-weight: 600;">' + formatMontant(Math.max(ville.reste, 0)) + '</td>' +
                                '<td>' + ville.taux.toFixed(1) + '%</td>' +
                                '<td>' + statut + '</td>' +
                            '</tr>';
                        }).join('');
                    } else {
                        villesBody.innerHTML = '<tr><td colspan="7" style="text-align: center; color: #7f8c8d;">Aucune ville</td></tr>';
                    }

                    // Afficher contenu et cacher loading
                    document.getElementById('loadingIndicator').style.display = 'none';
                    document.getElementById('recapContent').style.display = 'block';

                    // Heure de mise à jour
                    const now = new Date();
                    document.getElementById('lastUpdate').textContent = 'Dernière mise à jour : ' + now.toLocaleTimeString('fr-FR');

                    btn.disabled = false;
                    btn.innerHTML = '🔄 Actualiser';
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    btn.disabled = false;
                    btn.innerHTML = '🔄 Actualiser';
                    alert('Erreur lors du chargement des données.');
                });
        }

        // Charger les données au démarrage
        document.addEventListener('DOMContentLoaded', actualiserDonnees);
    </script>
</body>
</html>
