# Guide d'Installation : Cloner et Préparer le Projet sur un Nouveau PC (Windows)

Ce guide détaille les étapes pour récupérer et faire fonctionner le projet `laravel_plateforme-formation` sur un nouvel ordinateur. Étant donné que le fichier `.env` a été inclus dans le dépôt, l'installation est simplifiée.

## 🛠 Prérequis

Assurez-vous que les logiciels suivants sont installés sur le nouveau PC :
1. **PHP** (via Laragon, XAMPP ou installation autonome)
2. **Composer** (Gestionnaire de dépendances pour PHP)
3. **Node.js et npm** (Pour compiler les assets frontend CSS/JS)
4. **PostgreSQL** (Système de base de données)
5. **Git** (Pour cloner le dépôt)

---

## 🚀 Étapes d'Installation

### 1. Cloner le projet
Ouvrez un terminal (PowerShell ou Git Bash) dans le dossier où vous souhaitez installer le projet et exécutez la commande suivante :
```bash
git clone https://github.com/adrienfranto/laravel_plateforme-formation.git
```

### 2. Accéder au dossier du projet
Déplacez-vous dans le répertoire fraîchement cloné :
```bash
cd laravel_plateforme-formation
```

### 3. Installer les dépendances PHP (Laravel)
Cette commande va télécharger le dossier `vendor` contenant le cœur du framework Laravel et toutes les bibliothèques nécessaires :
```bash
composer install
```

### 4. Installer les dépendances JavaScript/CSS (Frontend)
Cette commande va télécharger le dossier `node_modules` contenant les packages Javascript :
```bash
npm install
```

### 5. Compiler les assets (CSS/JS)
Pour préparer les fichiers de style et les scripts pour la production :
```bash
npm run build
```
*(Note : Si vous souhaitez modifier le design ou le code JS et voir les changements en temps réel, utilisez plutôt `npm run dev`).*

### 6. Préparer la Base de Données
1. Ouvrez **pgAdmin** ou votre interface de gestion PostgreSQL.
2. Créez une nouvelle base de données en respectant le nom défini dans votre fichier `.env` (probablement `plateforme_formation_steph`).
3. Assurez-vous que les informations de connexion (utilisateur, mot de passe, port) de PostgreSQL sur ce nouveau PC correspondent bien à celles indiquées dans le fichier `.env` du projet.

### 7. Lancer les migrations
Une fois la base de données créée, construisez les tables en exécutant :
```bash
php artisan migrate
```
*(Si vous avez des Seeders pour insérer des données de test par défaut, utilisez `php artisan migrate:fresh --seed`).*

### 8. Démarrer le serveur local
Lancez le serveur de développement de Laravel :
```bash
php artisan serve
```

Vous pouvez maintenant accéder à votre application depuis votre navigateur à l'adresse suivante :  
👉 **http://127.0.0.1:8000**
