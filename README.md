# Projet : Carte de visite digitale PWA

Ce projet permet à n’importe qui de créer et partager sa propre **carte de visite digitale** directement depuis son téléphone, sans avoir besoin de cartes papier.  
Il utilise **Laravel** pour le backend, **Alpine.js + TailwindCSS** pour le frontend, et est transformé en **PWA** pour être installable sur mobile.

**Environnement :** le projet tourne avec **DDEV**. **Toutes les commandes doivent être exécutées via DDEV** (voir section [Commandes DDEV](#commandes-ddev) ci‑dessous).

---

## Fonctionnalités principales

- Création instantanée d’une carte de visite personnalisée.
- Chaque utilisateur obtient un **lien court** (ex. `/c/AB3X9K`) et un **identifiant + code** pour modifier sa carte plus tard.
- Partage facile via **QR code** ou lien direct.
- Carte interactive avec :
  - Nom, titre, entreprise
  - Email et téléphone
  - LinkedIn et site web
  - Photo/avatar
- Possibilité d’ajouter le site à l’écran d’accueil grâce à la PWA.
- Génération automatique de QR code en vCard pour l’import direct dans les contacts.

---

## Stack technique

- **Backend :** Laravel (PHP 8)
- **Frontend :** Blade + Alpine.js + TailwindCSS
- **PWA :** Service Worker + Manifest.json
- **QR code :** Package [Simple QR Code](https://github.com/SimpleSoftwareIO/simple-qrcode)

---

## Architecture

1. **Modèle `DigitalCard`**  
   Contient les infos de la carte, un **short_code** (6 caractères A–Z + chiffres, ex. AB3X9K) pour le lien public et l’accès « Modifier », et un **edit_code** (6 chiffres) pour la modification.

2. **Routes**

| Méthode | URI | Description |
|--------|-----|-------------|
| GET    | `/` | Accueil : formulaire + affichage carte si `?card=short_code` |
| POST   | `/` | Création (redirige vers la page détail `/c/AB3X9K`) |
| GET    | `/c/{shortCode}` | Page détail carte (affichage soigné, lien public) |
| GET    | `/modifier` | Modifier : formulaire identifiant + code puis édition |
| GET    | `/card/{shortCode}/qr` | QR code (image) → vCard |
| GET    | `/card/{shortCode}/vcard` | Téléchargement vCard (.vcf) |

---

## Commandes DDEV

**Toutes les commandes du projet doivent être exécutées via DDEV** (PHP, Composer, Artisan, NPM, etc. dans le conteneur).

### Démarrer / arrêter le projet

```bash
ddev start    # Démarrer l’environnement
ddev stop     # Arrêter l’environnement
ddev restart  # Redémarrer
```

URL du site : **https://digital-card.ddev.site**

### PHP / Laravel

```bash
ddev composer install      # Installer les dépendances PHP
ddev composer update       # Mettre à jour les dépendances
ddev artisan migrate       # Exécuter les migrations
ddev artisan migrate:fresh # Recréer la BDD et migrer
ddev artisan key:generate  # Générer la clé d’application
ddev artisan cache:clear   # Vider le cache
ddev artisan route:list   # Lister les routes
```

### Frontend (NPM / Vite)

```bash
ddev npm install   # Installer les dépendances Node
ddev npm run build # Build des assets (production)
ddev npm run dev   # Mode développement Vite (si besoin en parallèle)
```

### Base de données

```bash
ddev mysql        # Connexion au client MySQL
ddev import-db    # Importer une sauvegarde
ddev export-db    # Exporter la base
```

### Autres

```bash
ddev ssh          # Shell dans le conteneur web
ddev exec <cmd>   # Exécuter une commande dans le conteneur
ddev describe     # Infos du projet (URLs, ports, etc.)
```

---

## Installation rapide (avec DDEV)

1. Cloner le dépôt et entrer dans le dossier du projet.
2. Démarrer DDEV : `ddev start`
3. Installer les dépendances et préparer l’app :
   ```bash
   ddev composer install
   ddev artisan key:generate
   ddev artisan migrate
   ddev artisan storage:link
   ddev npm install
   ddev npm run build
   ```
4. Ouvrir **https://digital-card.ddev.site** dans le navigateur.

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
