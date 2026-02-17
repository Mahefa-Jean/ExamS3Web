# Guide de Déploiement - ExamS3Web

## 📋 Table des matières
1. [Prérequis](#prérequis)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Base de Données](#base-de-données)
5. [Lancement du Projet](#lancement-du-projet)
6. [Accès à l'Application](#accès-à-lapplication)
7. [Dépannage](#dépannage)

---

## ✅ Prérequis

Avant de démarrer, assurez-vous que vous disposez de:

- **PHP**: Version 7.4 ou supérieure
- **MySQL/MariaDB**: Version 5.7 ou supérieure
- **Composer**: Pour gérer les dépendances PHP
- **XAMPP, WAMP, LAMP** ou **MAMP**: Serveur local (récemment installé)
- **Git** (optionnel, si vous clonez depuis un dépôt)

### Vérifier les versions installées:

```bash
php --version
mysql --version
composer --version
```

---

## 🚀 Installation

### 1. Vérifier la localisation du projet

Le projet doit être situé dans:
```
/opt/lampp/htdocs/ExamS3Web/
```

ou pour Windows avec XAMPP:
```
C:\xampp\htdocs\ExamS3Web\
```

### 2. Installer les dépendances PHP

Navigez dans le répertoire du projet:

```bash
cd /opt/lampp/htdocs/ExamS3Web
```

Installez les dépendances avec Composer:

```bash
composer install
```

Cela va installer:
- FlightPHP Framework (v3.0+)
- FlightPHP Runway (CLI tools)
- Tracy (Debugging tool)
- Autres dépendances requises

---

## ⚙️ Configuration

### 1. Vérifier le fichier config.php

Le fichier `/app/config/config.php` contient les paramètres suivants:

```php
'database' => [
    'driver'   => 'mysql',
    'host'     => 'localhost',      // Hôte MySQL
    'port'     => 3306,             // Port MySQL (par défaut: 3306)
    'dbname'   => 'exams3web',      // Nom de la base de données
    'user'     => 'root',           // Utilisateur MySQL
    'password' => '',               // Mot de passe MySQL
    'charset'  => 'utf8mb4',        // Encodage
],
```

### 2. Adapter la configuration si nécessaire

Si votre MySQL utilise un mot de passe pour l'utilisateur `root`:

```php
'password' => 'votre_mot_de_passe', // Mettez votre mot de passe ici
```

Si vous utilisez un utilisateur différent:

```php
'user'     => 'votre_utilisateur',
'password' => 'votre_mot_de_passe',
```

### 3. Chemins importants

Assurez-vous que ces répertoires existent et sont accessibles:

```
/app/models/       - Modèles (à créer si absent)
/app/utils/        - Utilitaires (à créer si absent)
/app/cache/        - Cache (à créer si absent)
/app/log/          - Journaux (à créer si absent)
/public/           - Fichiers publics (CSS, JS, images)
/vendor/           - Dépendances (créé par Composer)
```

Créez les répertoires manquants:

```bash
mkdir -p app/models
mkdir -p app/utils
mkdir -p app/cache
mkdir -p app/log
chmod -R 755 app/cache app/log
```

---

## 🗄️ Base de Données

### 1. Démarrer MySQL

**Sur Linux avec XAMPP:**
```bash
sudo /opt/lampp/bin/mysql
```

**Sur Mac avec XAMPP:**
```bash
/Applications/XAMPP/xampp mysql start
```

**Ou via phpMyAdmin:**
- Allez à `http://localhost/phpmyadmin`
- Connectez-vous avec `root` et pas de mot de passe

### 2. Créer la base de données

**Option A: Utiliser le fichier SQL fourni**

Depuis la ligne de commande MySQL:

```bash
# Entrer dans MySQL
mysql -u root

# Puis exécuter:
source /opt/lampp/htdocs/ExamS3Web/mysql.sql;

# Ou depuis votre shell:
mysql -u root < /opt/lampp/htdocs/ExamS3Web/mysql.sql
```

**Option B: Via phpMyAdmin**

1. Allez à `http://localhost/phpmyadmin`
2. Cliquez sur "Importer"
3. Sélectionnez le fichier `mysql.sql`
4. Cliquez sur "Exécuter"

### 3. Vérifier la base de données

```bash
mysql -u root
USE exams3web;
SHOW TABLES;
```

Vous devriez voir:
- `villes`
- `besoins`
- `dons`
- `distributions`

### 4. Vérifier les données

```sql
SELECT COUNT(*) FROM villes;
SELECT COUNT(*) FROM besoins;
SELECT COUNT(*) FROM dons;
```

---

## 🎯 Lancement du Projet

### Option 1: Serveur développement intégré (Recommandé)

```bash
cd /opt/lampp/htdocs/ExamS3Web
Œ
```

Le serveur démarre sur **`http://localhost:8000`**

### Option 2: Utiliser XAMPP directement

Le projet est déjà dans `/opt/lampp/htdocs/ExamS3Web/`

1. Démarrez XAMPP
2. Accédez à **`http://localhost/ExamS3Web`**
3. La page d'accueil (Dashboard) s'affiche

### Option 3: Utiliser Apache directement

Assurez-vous que:
- Apache est en cours d'exécution
- Le fichier `.htaccess` est présent dans `/public`

Créez `/public/.htaccess` s'il n'existe pas:

```apache
<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteBase /ExamS3Web/public/
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^ index.php [QSA,L]
</IfModule>
```

Puis accédez à **`http://localhost/ExamS3Web/public`**

---

## 🌐 Accès à l'Application

### URLs de l'application:

Si vous lancez avec `php -S localhost:8000`:
```
http://localhost:8000/                          # Dashboard
http://localhost:8000/villes                    # Gestion des Villes
http://localhost:8000/besoins                   # Gestion des Besoins
http://localhost:8000/dons                      # Gestion des Dons
http://localhost:8000/distribution              # Distribution
http://localhost:8000/recapitulatif            # Récapitulatif
```

Si vous utilisez XAMPP:
```
http://localhost/ExamS3Web/                     # Dashboard
http://localhost/ExamS3Web/villes               # Gestion des Villes
http://localhost/ExamS3Web/besoins              # Gestion des Besoins
http://localhost/ExamS3Web/dons                 # Gestion des Dons
http://localhost/ExamS3Web/distribution         # Distribution
http://localhost/ExamS3Web/recapitulatif       # Récapitulatif
```

---

## 🔍 Dépannage

### Problème: "Error 404 - Page not found"

**Solution 1:** Vérifiez la configuration de base_url dans `config.php`:
```php
$app->set('flight.base_url', BASE_URL);
```

**Solution 2:** Vérifiez les routes dans `/app/config/routes.php`

### Problème: "Connection refused" - Erreur MySQL

**Vérifications:**
```bash
# Vérifier que MySQL est actif
ps aux | grep mysql

# Vérifier la connexion
mysql -u root -h localhost

# Vérifier le nom de la base de données
mysql -u root -e "SHOW DATABASES;"
```

**Solution:** Vérifiez les identifiants dans `/app/config/config.php`

### Problème: "Permission denied" ou "Cannot write to cache"

```bash
# Donner les permissions nécessaires
chmod -R 777 app/cache
chmod -R 777 app/log
chmod -R 777 public
```

### Problème: "Class not found" ou "Undefined function"

```bash
# Régénérer l'autoloader Composer
composer dump-autoload
```

### Problème: "Cannot load stylesheet" ou "script.js not found"

Vérifiez que les fichiers existent:
```bash
ls -la public/assets/css/
ls -la public/assets/js/
```

Si absent, créez-les. Les fichiers sont fournis dans le projet.

### Problème: Les formulaires ne fonctionnent pas

```bash
# Vérifier les routes POST
grep "post'" app/config/routes.php

# Vérifier que les controllers existent
ls -la app/controllers/
```

---

## 📊 Structure du Projet

```
ExamS3Web/
├── public/                  # Racine web (servi au navigateur)
│   └── assets/
│       ├── css/
│       │   └── style.css   # Styles globaux
│       ├── js/
│       │   └── script.js   # Scripts JavaScript
│       └── index.php        # Point d'entrée
├── app/
│   ├── config/
│   │   ├── bootstrap.php    # Initialisation de l'app
│   │   ├── config.php       # Configuration (à personnaliser)
│   │   ├── routes.php       # Définition des routes
│   │   └── services.php     # Services (base de données, etc.)
│   ├── controllers/         # Contrôleurs (logique métier)
│   ├── models/             # Modèles de données
│   ├── views/              # Vues (templates HTML)
│   │   ├── dashboard.php
│   │   ├── villes/
│   │   ├── besoins/
│   │   ├── dons/
│   │   ├── distribution/
│   │   ├── recapitulatif/
│   │   └── layouts/
│   ├── middlewares/        # Middlewares (sécurité, etc.)
│   ├── cache/              # Cache temporaire
│   └── log/                # Fichiers journaux
├── vendor/                  # Dépendances Composer
├── mysql.sql               # Script de création BD
├── composer.json           # Dépendances du projet
├── composer.lock           # Versions figées des dépendances
├── index.php               # Point d'entrée (redirects vers public/)
└── README.md               # Documentation
```

---

## 🔐 Sécurité (Production)

Avant de déployer en production:

### 1. Fichiers .env ou config sécurisés

Ne commitez JAMAIS les mots de passe. Utilisez plutôt:

```bash
# Créer un fichier .env (non commité)
touch .env
```

```env
DB_HOST=localhost
DB_NAME=exams3web
DB_USER=root
DB_PASS=your_secure_password
```

Chargez ensuite ce fichier dans `config.php`:

```php
if (file_exists(__DIR__ . '/../../.env')) {
    require __DIR__ . '/../../.env';
}
```

### 2. Permissions des fichiers

```bash
# Répertoires accessibles
chmod -R 755 app/cache
chmod -R 755 app/log
chmod -R 755 public

# Fichiers config (limiter l'accès)
chmod 640 app/config/config.php
chmod 640 .env
```

### 3. HTTPS en production

Assurez-vous que HTTPS est activé sur votre serveur.

### 4. Headers de sécurité

Vérifiez que `app/middlewares/SecurityHeadersMiddleware.php` est appliqué.

---

## 📞 Support Supplémentaire

- **Documentation Flight PHP:** https://docs.flightphp.com
- **MySQL Documentation:** https://dev.mysql.com/doc/
- **PHP Manuel:** https://www.php.net/manual/

---

## ✨ Prochaines étapes

1. **Créer les contrôleurs:**
   - `app/controllers/DashboardController.php`
   - `app/controllers/VillesController.php`
   - `app/controllers/BesoinsController.php`
   - `app/controllers/DonsController.php`
   - `app/controllers/DistributionController.php`
   - `app/controllers/RecapitulatifController.php`

2. **Créer les modèles:**
   - `app/models/Ville.php`
   - `app/models/Besoin.php`
   - `app/models/Don.php`
   - `app/models/Distribution.php`

3. **Configurer les routes:**
   - Mettre à jour `/app/config/routes.php`

4. **Tester l'application:**
   - Accéder à chaque page
   - Tester les formulaires
   - Vérifier les calculs

---

**Version:** 1.0.0  
**Dernière mise à jour:** 16 février 2026
