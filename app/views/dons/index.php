<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Dons</title>
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
        .form-group {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            padding: 0.75rem;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
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
        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        form {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
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
        .action-buttons {
            display: flex;
            gap: 0.5rem;
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
            .action-buttons {
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
            <li><a href="/besoins">Gestion Besoins</a></li>
            <li><a href="/dons" class="active">Gestion Dons</a></li>
            <li><a href="/distribution">Distribution</a></li>
            <li><a href="/recapitulatif">Récapitulatif</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="header">
            <h1>Gestion des Dons</h1>
            <p>Ajoutez, modifiez ou supprimez les dons reçus.</p>
        </div>

<form method="POST" action="/dons/save">
    <h2>Ajouter un Nouveau Don</h2>
    
    <input type="hidden" name="id" value="<?= $don['id'] ?? '' ?>">

    <div class="form-group">
        <label for="type">Type de Don *</label>
        <select id="type" name="type" required>
            <option value="">-- Sélectionner un type --</option>
            <option value="nature" <?= ($don['type'] ?? '') === 'nature' ? 'selected' : '' ?>>Nature (Alimentaire)</option>
            <option value="materiel" <?= ($don['type'] ?? '') === 'materiel' ? 'selected' : '' ?>>Matériel</option>
            <option value="argent" <?= ($don['type'] ?? '') === 'argent' ? 'selected' : '' ?>>Argent</option>
        </select>
    </div>

    <div class="form-group">
        <label for="designation">Désignation *</label>
        <input type="text" id="designation" name="designation" required value="<?= htmlspecialchars($don['designation'] ?? '') ?>" placeholder="Ex: Riz, Tôle, Don d'argent">
    </div>

    <div class="form-group">
        <label for="quantite">Quantité *</label>
        <input type="number" id="quantite" name="quantite" required value="<?= $don['quantite'] ?? '' ?>" min="0" step="0.01" placeholder="Ex: 100">
    </div>

    <div class="form-group">
        <label for="date_don">Date du Don *</label>
        <input type="date" id="date_don" name="date_don" required value="<?= $don['date_don'] ?? date('Y-m-d') ?>">
    </div>

    <div class="btn-group">
        <button type="submit" class="btn btn-primary"><?= !empty($don['id']) ? 'Modifier' : 'Ajouter' ?></button>
        <?php if(!empty($don['id'])): ?>
            <a href="/dons" class="btn btn-secondary">Annuler</a>
        <?php endif; ?>
    </div>
</form>

<div class="header">
    <h2>Liste des Dons</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Désignation</th>
                <th>Quantité</th>
                <th>Date Don</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($dons)): ?>
                <?php foreach($dons as $don): ?>
                    <tr>
                        <td><?= $don['id'] ?></td>
                        <td><?= htmlspecialchars($don['type']) ?></td>
                        <td><?= htmlspecialchars($don['designation']) ?></td>
                        <td><?= number_format($don['quantite'], 2) ?></td>
                        <td><?= date('d/m/Y', strtotime($don['date_don'])) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="/dons/edit/<?= $don['id'] ?>" class="btn btn-secondary">Modifier</a>
                                <a href="/dons/delete/<?= $don['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr?')">Supprimer</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #7f8c8d;">Aucun don enregistré</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
        </div>
    </div>
    <script src="/assets/js/script.js"></script>
</body>
</html>
