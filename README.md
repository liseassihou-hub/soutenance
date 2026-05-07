# PEBCO — Application de gestion des demandes de crédit

Ce dépôt contient l'application PEBCO, une application Laravel utilisée pour gérer les demandes de crédit communautaires.

Ce README remplace le README générique fourni par Laravel et contient les informations essentielles pour installer, configurer et exécuter le projet en environnement de développement.

---

## 1) Présentation rapide
- Multi-guard authentication: `admin` et `agent`.
- Sessions stockées en base (`SESSION_DRIVER=database`).
- Flux de réinitialisation de mot de passe personnalisé (compatible `admin` et `agent`).

## 2) Prérequis
- PHP 8.4
- Composer
- Node.js 18+ et npm
- MySQL (ou SQLite pour un setup léger)

## 3) Installation locale
1. Cloner le dépôt:

```bash
git clone <repo-url> pebco
cd pebco
```

2. Installer dépendances PHP et JS:

```bash
composer install --no-interaction --prefer-dist
npm install
```

3. Copier l'environnement et générer la clé:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configurer la base de données dans `.env`.
	- MySQL: renseigner `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
	- SQLite: `DB_CONNECTION=sqlite` et `DB_DATABASE=database/database.sqlite` puis:

```bash
touch database/database.sqlite
chmod 664 database/database.sqlite
```

5. Lancer les migrations (attention si la base contient déjà des tables):

```bash
php artisan migrate --force
```

Si votre base contient déjà des tables, appliquez de préférence les migrations ciblées au lieu de tout relancer.

## 4) Emails en local (Maildev)
Le projet est configuré pour utiliser SMTP local en dev. Pour capturer les emails (reset password, notifications) :

```bash
npx maildev --smtp 1025 --web 1080
```

Ouvrez ensuite `http://127.0.0.1:1080` pour voir les emails reçus.

## 5) Commandes utiles
- Démarrer l'application:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

- Vider les caches:

```bash
php artisan optimize:clear
```

- Lister les routes liées au reset :

```bash
php artisan route:list --name=password
```

## 6) Tests
- Tests PHPUnit: `./vendor/bin/phpunit`

## 7) Conventions Git
- Commits atomiques et explicites: `type(scope): description` (ex: `fix(auth): disable admin timestamps`).
- Créez une branche par fonctionnalité: `git checkout -b feat/ma-fonctionnalite`.

## 8) Points d'attention
- Le modèle `Admin` n'utilise pas les timestamps (`public $timestamps = false`).
- Si vous rencontrez des erreurs SQL pour des tables manquantes, appliquez les migrations correspondantes (ex: `password_reset_tokens`, `sessions`).

## 9) Déploiement
- Adapter les variables d'environnement (DB, MAIL, CACHE, SESSION).
- Sauvegarder la DB avant d'exécuter `php artisan migrate --force` en production.

---

Si tu veux, je peux :
- ajouter un guide de déploiement (procédure pas-à-pas),
- créer des checklists pour la pré-production,
- ou harmoniser la documentation technique pour les développeurs (API, événements, jobs, notifications).

Contact: ouvre une issue pour toute question ou problème.

