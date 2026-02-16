<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion des Dons et Besoins</title>
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
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
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
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-success {
            background-color: #27ae60;
            color: white;
        }
        .btn-success:hover {
            background-color: #229954;
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
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="/" class="active">Dashboard</a></li>
            <li><a href="/villes">Gestion Villes</a></li>
            <li><a href="/besoins">Gestion Besoins</a></li>
            <li><a href="/dons">Gestion Dons</a></li>
            <li><a href="/distribution">Distribution</a></li>
            <li><a href="/recapitulatif">Récapitulatif</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="header">
            <h1>Dashboard - Gestion des Dons et Besoins</h1>
            <p>Bienvenue sur votre plateforme de gestion des dons et des besoins par ville.</p>
        </div>

<div class="stats">
    <div class="stat-card">
        <h3>Total Villes</h3>
        <div class="value"><?= $totalVilles ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <h3>Total Besoins</h3>
        <div class="value"><?= $totalBesoins ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <h3>Total Dons</h3>
        <div class="value"><?= $totalDons ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <h3>Total Montant Dons</h3>
        <div class="value"><?= number_format($totalMontantDons ?? 0, 2) ?> DA</div>
    </div>
</div>

<div class="header">
    <h2>Actions Rapides</h2>
    <div class="btn-group">
        <a href="/villes" class="btn btn-primary">Ajouter une Ville</a>
        <a href="/besoins" class="btn btn-primary">Ajouter un Besoin</a>
        <a href="/dons" class="btn btn-primary">Ajouter un Don</a>
        <a href="/distribution" class="btn btn-success">Distribuer</a>
    </div>
</div>

<div class="header">
    <h2>Liste des Villes</h2>
    <table>
        <thead>
            <tr>
                <th>Nom Ville</th>
                <th>Total Besoins</th>
                <th>Total Dons</th>
                <th>Reste à Couvrir</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($villes)): ?>
                <?php foreach($villes as $ville): ?>
                    <tr>
                        <td><?= htmlspecialchars($ville['nom'] ?? '') ?></td>
                        <td><?= number_format($ville['total_besoins'] ?? 0, 2) ?> DA</td>
                        <td><?= number_format($ville['total_dons'] ?? 0, 2) ?> DA</td>
                        <td><?= number_format(($ville['total_besoins'] ?? 0) - ($ville['total_dons'] ?? 0), 2) ?> DA</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; color: #7f8c8d;">Aucune ville enregistrée</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
        </div>
    </div>
    <script src="/assets/js/script.js"></script>
</body>
</html>
