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

## 10) CI / CD (GitHub Actions) — déploiement via SSH

Un workflow GitHub Actions est inclus pour déployer automatiquement le contenu vers votre hébergement partagé (o2switch) lorsque vous poussez sur `main`, ou manuellement via `workflow_dispatch`.

Comment ça marche:
- Le workflow construit l'application (composer + assets) sur GitHub, puis synchronise les fichiers vers le serveur via `rsync` sur SSH.
- Il exécute ensuite quelques commandes distantes (composer install, clear caches). Les migrations ne sont exécutées que si le secret `RUN_MIGRATIONS` est défini à `true`.

Secrets requis (Repository > Settings > Secrets):
- `SSH_PRIVATE_KEY` : clé privée SSH (PEM) pour se connecter au serveur.
- `SSH_HOST` : hôte SSH (ex: `monserveur.o2switch.net`).
- `SSH_PORT` : port SSH (par défaut `22`).
- `SSH_USER` : utilisateur SSH (ex: `ronaldo`).
- `REMOTE_PATH` : chemin absolu vers le dossier du site sur le serveur (ex: `/home/ronaldo/www/mon-site`).
- `RUN_MIGRATIONS` : `true` ou `false` (par défaut `false`).

Comment générer et installer la clé SSH :
1. Sur votre poste local, créez une paire de clés (sans passphrase si vous voulez usage CI automatique) :

```bash
ssh-keygen -t rsa -b 4096 -C "deploy@pebco" -f ~/.ssh/pebco_deploy
```

2. Copiez la clé publique sur votre serveur (o2switch) :

```bash
ssh-copy-id -i ~/.ssh/pebco_deploy.pub ronaldo@monserveur.o2switch.net
```

3. Dans GitHub, ajoutez la clé privée (`~/.ssh/pebco_deploy`) dans `Secrets` sous le nom `SSH_PRIVATE_KEY`, et complétez `SSH_HOST`, `SSH_USER`, `SSH_PORT`, `REMOTE_PATH`.

Notes spécifiques à o2switch (hébergement mutualisé) :
- Assurez-vous que l'accès SSH est activé sur votre compte o2switch et que l'utilisateur a les droits d'écriture sur `REMOTE_PATH`.
- Certains hébergeurs ont des chemins différents pour le webroot (public_html, www). Ajustez `REMOTE_PATH` en conséquence.
- Si vous n'avez pas `composer` côté serveur, l'action essaie d'installer les dépendances côté GitHub et synchronise les fichiers; mais il est préférable d'avoir `composer` installé sur le serveur pour exécuter les optimisations et migrations.

Sécurité
- Ne mettez jamais votre `.env` dans le dépôt. Le workflow exclut `.env` par défaut.
- Les secrets GitHub sont masqués dans les logs et doivent être gérés via l'interface GitHub.


---

Si tu veux, je peux :
- ajouter un guide de déploiement (procédure pas-à-pas),
- créer des checklists pour la pré-production,
- ou harmoniser la documentation technique pour les développeurs (API, événements, jobs, notifications).

Contact: ouvre une issue pour toute question ou problème.

