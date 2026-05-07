<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Réinitialisation du mot de passe

Le formulaire de connexion expose désormais un lien de réinitialisation de mot de passe. Le lien envoie un email via Maildev et redirige vers un formulaire de création de nouveau mot de passe.

Pour démarrer Maildev en local:

```bash
npx maildev --smtp 1025 --web 1080
```

Ensuite, ouvre l'interface web sur `http://127.0.0.1:1080`.

## README réécrit — PEBCO (Guide d'installation rapide)

Ce dépôt contient l'application PEBCO — une application Laravel (PHP) pour la gestion des demandes de crédit communautaires.

Objectifs du README
- Expliquer la configuration locale minimale.
- Décrire les commandes pour démarrer l'application.
- Détailler la configuration du canal d'emails (Maildev) utilisée pour les tests locaux.

Prérequis
- PHP 8.4 (ou version compatible Laravel utilisée dans le projet).
- Composer
- Node.js 18+ et npm
- MySQL (ou SQLite si vous préférez configurer DB en sqlite)

Installation (local)
1. Cloner le dépôt:

```bash
git clone <repo-url> pebco
cd pebco
```

2. Installer les dépendances PHP et JS:

```bash
composer install --no-interaction --prefer-dist
npm install
```

3. Copier le fichier d'environnement et générer la clé d'application:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configurer la base de données dans `.env`:
- Pour MySQL, renseigner `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
- Pour SQLite, mettez `DB_CONNECTION=sqlite` et `DB_DATABASE=/absolute/path/to/database.sqlite` ou `database/database.sqlite` puis créez le fichier:

```bash
touch database/database.sqlite
chmod 664 database/database.sqlite
```

5. Appliquer les migrations nécessaires (ou uniquement celles manquantes):

```bash
php artisan migrate --force
```

Remarques: ce dépôt contient plusieurs migrations déjà appliquées en production. Si votre base existe déjà, préférez exécuter `php artisan migrate --path=database/migrations/2026_05_07_000001_create_password_reset_tokens_table.php --force` pour appliquer une migration ciblée.

Mail (en local avec Maildev)
- Le projet est configuré pour utiliser SMTP local pour le développement. Pour capturer les emails localement, installez Maildev (via npm) et lancez-le:

```bash
npx maildev --smtp 1025 --web 1080
```

- Dans l'interface web (`http://127.0.0.1:1080`) vous verrez les emails envoyés par l'application (réinitialisation de mot de passe, notifications, etc.).

Fonctionnalités principales
- Authentification multi-guard: `admin` et `agent`.
- Gestion des sessions en base (`SESSION_DRIVER=database`).
- Réinitialisation de mot de passe: flux custom compatible `admin` et `agent`, via `password_reset_tokens`.

Points d'attention
- Certains modèles (`Admin`) ne possèdent pas de colonnes timestamps; le modèle est configuré avec `public $timestamps = false`.
- Si vous rencontrez des erreurs SQL sur des tables manquantes, vérifiez les migrations présentes dans `database/migrations` et appliquez-les individuellement.

Commandes utiles
- Lancer le serveur local:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

- Vider les caches:

```bash
php artisan optimize:clear
```

- Lister les routes (utile pour vérifier le nouveau flux de reset):

```bash
php artisan route:list --name=password
```

Tests
- Les tests PHPUnit sont présents sous `tests/`. Pour lancer les tests:

```bash
./vendor/bin/phpunit
```

Contributions et conventions Git
- Commits atomiques et messages clairs (type:scope: description) — ex: `fix(auth): disable admin timestamps`.
- Créez une branche pour chaque fonctionnalité: `git checkout -b feat/password-reset`.

Déploiement
- Adapter les variables d'environnement en production: DB, MAIL, CACHE, SESSION.
- Exécuter les migrations en production avec prudence (ex: sauvegarde avant `php artisan migrate --force`).

Support
- Pour toute question, ouvre une issue dans le dépôt avec le plus d'informations possible (logs, .env non sensibles, étapes pour reproduire).

---

Merci — je peux aussi produire une checklist d'opérations pour la mise en production si tu le souhaites.
