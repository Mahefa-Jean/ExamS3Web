<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Besoins - <?= htmlspecialchars($ville['nom'] ?? 'Ville inconnue') ?></title>
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
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #7f8c8d;
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
        .info-box {
            background: #ecf0f1;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            border-left: 4px solid #3498db;
        }
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
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
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="/">Dashboard</a></li>
            <li><a href="/villes">Gestion Villes</a></li>
            <li><a href="/besoins" class="active">Gestion Besoins</a></li>
            <li><a href="/dons">Gestion Dons</a></li>
            <li><a href="/distribution">Distribution</a></li>
            <li><a href="/recapitulatif">Récapitulatif</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="header">
            <h1>Besoins de la ville: <?= htmlspecialchars($ville['nom'] ?? 'Ville inconnue') ?></h1>
            <div class="info-box">
                <p><strong>Ville:</strong> <?= htmlspecialchars($ville['nom'] ?? 'N/A') ?></p>
                <p><strong>Nombre de sinistrés:</strong> <?= htmlspecialchars($ville['nombre_sinistre'] ?? '0') ?></p>
            </div>
            <div class="btn-group">
                <a href="/" class="btn btn-secondary">Retour au Dashboard</a>
            </div>
        </div>

        <div class="header">
            <h2>Liste des besoins</h2>
            <?php if(!empty($besoins)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom du besoin</th>
                            <th>Prix unitaire</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($besoins as $besoin): ?>
                            <tr>
                                <td><?= htmlspecialchars($besoin['id']) ?></td>
                                <td><?= htmlspecialchars($besoin['nom']) ?></td>
                                <td><?= htmlspecialchars($besoin['prix_unitaire']) ?> DZD</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="info-box">
                    <p style="border: none; padding: 0;">Aucun besoin enregistré pour cette ville.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="/assets/js/script.js"></script>
</body>
</html>
