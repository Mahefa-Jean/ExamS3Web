<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribution des Dons</title>
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
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-success {
            background-color: #27ae60;
            color: white;
        }
        .btn-success:hover {
            background-color: #229954;
        }
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
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
            <li><a href="/distribution" class="active">Distribution</a></li>
            <li><a href="/recapitulatif">Récapitulatif</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="header">
            <h1>Distribution des Dons</h1>
            <p>Visualisez et simulez la distribution des dons selon les besoins.</p>
        </div>

<div class="header">
    <h2>Contrôles</h2>
    <div class="btn-group">
        <form method="POST" action="/distribution/simulate" style="display:inline;">
            <button type="submit" class="btn btn-success">Simuler la Distribution</button>
        </form>
    </div>
</div>

<div class="header">
    <h2>Tableau de Distribution</h2>
    <table>
        <thead>
            <tr>
                <th>Ville</th>
                <th>Besoin</th>
                <th>Quantité Besoin</th>
                <th>Don Attribué</th>
                <th>Quantité Attribuée</th>
                <th>Reste</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($distributions)): ?>
                <?php foreach($distributions as $dist): ?>
                    <tr>
                        <td><?= htmlspecialchars($dist['ville_nom'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($dist['besoin_designation'] ?? 'N/A') ?></td>
                        <td><?= number_format($dist['besoin_quantite'] ?? 0, 2) ?></td>
                        <td><?= htmlspecialchars($dist['don_designation'] ?? 'Non attribué') ?></td>
                        <td><?= number_format($dist['quantite_attribuee'] ?? 0, 2) ?></td>
                        <td><?= number_format(($dist['besoin_quantite'] ?? 0) - ($dist['quantite_attribuee'] ?? 0), 2) ?></td>
                        <td>
                            <?php 
                                $reste = ($dist['besoin_quantite'] ?? 0) - ($dist['quantite_attribuee'] ?? 0);
                                if($reste <= 0) {
                                    echo '<span style="color: #27ae60; font-weight: bold;">Couvert</span>';
                                } elseif($reste < ($dist['besoin_quantite'] ?? 0) / 2) {
                                    echo '<span style="color: #f39c12; font-weight: bold;">Partiellement</span>';
                                } else {
                                    echo '<span style="color: #e74c3c; font-weight: bold;">Non couvert</span>';
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #7f8c8d;">Aucune distribution disponible. Ajoutez des besoins et des dons d'abord.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="header">
    <h2>Résumé par Ville</h2>
    <table>
        <thead>
            <tr>
                <th>Ville</th>
                <th>Total Besoins</th>
                <th>Total Dons Attribués</th>
                <th>Reste à Couvrir</th>
                <th>Pourcentage</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($resumeVilles)): ?>
                <?php foreach($resumeVilles as $resume): ?>
                    <tr>
                        <td><?= htmlspecialchars($resume['ville_nom']) ?></td>
                        <td><?= number_format($resume['total_besoins'], 2) ?> DA</td>
                        <td><?= number_format($resume['total_dons_attribues'], 2) ?> DA</td>
                        <td><?= number_format($resume['reste'], 2) ?> DA</td>
                        <td>
                            <?php 
                                $pourcentage = $resume['total_besoins'] > 0 ? ($resume['total_dons_attribues'] / $resume['total_besoins'] * 100) : 0;
                                echo number_format($pourcentage, 1) . '%';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #7f8c8d;">Aucune ville avec distribution</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
        </div>
    </div>
    <script src="/assets/js/script.js"></script>
</body>
</html>
