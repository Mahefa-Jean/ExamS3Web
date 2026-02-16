<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue Récapitulative</title>
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
        }
        nav {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: rgba(255,255,255,0.2);
        }
        nav a.active {
            background-color: #3498db;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
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
            margin-bottom: 1rem;
        }
        h2 {
            color: #34495e;
            margin: 2rem 0 1rem 0;
            border-bottom: 2px solid #3498db;
            padding-bottom: 0.5rem;
        }
        h3 {
            color: #34495e;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                gap: 0;
            }
            nav a {
                display: block;
                padding: 0.75rem;
            }
            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="/">Dashboard</a></li>
            <li><a href="/villes">Gestion Villes</a></li>
            <li><a href="/besoins">Gestion Besoins</a></li>
            <li><a href="/dons">Gestion Dons</a></li>
            <li><a href="/distribution">Distribution</a></li>
            <li><a href="/recapitulatif" class="active">Récapitulatif</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="header">
            <h1>Vue Récapitulative Globale</h1>
            <p>Synthèse complète des villes, besoins, dons et distribution.</p>
        </div>

<div class="stats">
    <div class="stat-card">
        <h3>Total Villes</h3>
        <div class="value"><?= count($villes ?? []) ?></div>
    </div>
    <div class="stat-card">
        <h3>Total Besoins</h3>
        <div class="value"><?= number_format($totalBesoins ?? 0, 2) ?> DA</div>
    </div>
    <div class="stat-card">
        <h3>Total Dons</h3>
        <div class="value"><?= number_format($totalDons ?? 0, 2) ?> DA</div>
    </div>
    <div class="stat-card">
        <h3>Reste à Couvrir</h3>
        <div class="value"><?= number_format(($totalBesoins ?? 0) - ($totalDons ?? 0), 2) ?> DA</div>
    </div>
</div>

<div class="header">
    <h2>Taux de Couverture Global</h2>
    <?php 
        $tauxCouverture = ($totalBesoins ?? 0) > 0 ? (($totalDons ?? 0) / ($totalBesoins ?? 0) * 100) : 0;
    ?>
    <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;">
        <div style="font-size: 3rem; font-weight: bold; color: #3498db;">
            <?= number_format($tauxCouverture, 1) ?>%
        </div>
        <p style="color: #7f8c8d; margin-top: 0.5rem;">des besoins sont couverts par les dons</p>
    </div>
</div>

<div class="header">
    <h2>Détail par Ville</h2>
    <table>
        <thead>
            <tr>
                <th>Ville</th>
                <th>Total Besoins</th>
                <th>Total Dons Reçus</th>
                <th>Reste à Couvrir</th>
                <th>Taux de Couverture</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($villes)): ?>
                <?php foreach($villes as $ville): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($ville['nom']) ?></strong></td>
                        <td><?= number_format($ville['total_besoins'] ?? 0, 2) ?> DA</td>
                        <td><?= number_format($ville['total_dons'] ?? 0, 2) ?> DA</td>
                        <td><?= number_format(($ville['total_besoins'] ?? 0) - ($ville['total_dons'] ?? 0), 2) ?> DA</td>
                        <td>
                            <?php 
                                $taux = ($ville['total_besoins'] ?? 0) > 0 ? (($ville['total_dons'] ?? 0) / ($ville['total_besoins'] ?? 0) * 100) : 0;
                                echo number_format($taux, 1) . '%';
                            ?>
                        </td>
                        <td>
                            <?php 
                                $taux = ($ville['total_besoins'] ?? 0) > 0 ? (($ville['total_dons'] ?? 0) / ($ville['total_besoins'] ?? 0) * 100) : 0;
                                if($taux >= 100) {
                                    echo '<span style="background-color: #d4edda; color: #155724; padding: 0.25rem 0.75rem; border-radius: 4px;">Couverte</span>';
                                } elseif($taux >= 50) {
                                    echo '<span style="background-color: #fff3cd; color: #856404; padding: 0.25rem 0.75rem; border-radius: 4px;">Partiellement</span>';
                                } else {
                                    echo '<span style="background-color: #f8d7da; color: #721c24; padding: 0.25rem 0.75rem; border-radius: 4px;">Non couverte</span>';
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #7f8c8d;">Aucune ville enregistrée</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="header">
    <h2>Détail Besoins par Ville</h2>
    <?php if(!empty($donsParVille)): ?>
        <?php foreach($donsParVille as $villeNom => $besoins): ?>
            <div style="margin-bottom: 2rem;">
                <h3><?= htmlspecialchars($villeNom) ?></h3>
                <table style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>Besoin</th>
                            <th>Type</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($besoins as $besoin): ?>
                            <tr>
                                <td><?= htmlspecialchars($besoin['designation']) ?></td>
                                <td><?= htmlspecialchars($besoin['type']) ?></td>
                                <td><?= number_format($besoin['quantite'], 2) ?></td>
                                <td><?= number_format($besoin['prix_unitaire'], 2) ?> DA</td>
                                <td><?= number_format($besoin['quantite'] * $besoin['prix_unitaire'], 2) ?> DA</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center; color: #7f8c8d;">Aucun besoin enregistré</p>
    <?php endif; ?>
        </div>
    </div>
    <script src="/assets/js/script.js"></script>
</body>
</html>
