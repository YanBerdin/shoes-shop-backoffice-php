# `Projet Shoes Shop - BackOffice`

## `Description du projet`

> [!NOTE]
> Backoffice pour la gestion complète d'une boutique de chaussures en ligne [Shoes Shop](https://github.com/YanBerdin/shoes-shop-frontoffice-php), permettant la gestion des produits, catégories, types, marques, commandes et utilisateurs, avec contrôle d'accès par rôles.

## Problèmes résolus

- Centralisation de la gestion des données produits, catégories, types, marques
- Suivi et gestion des commandes
- Gestion des droits d'accès selon le rôle
- Amélioration de la productivité et réduction des erreurs manuelles

## Objectifs d'expérience utilisateur

- Interface claire, navigation rapide
- Sécurité des accès et des données
- Simplicité des opérations courantes (CRUD)
- Feedback utilisateur sur les actions

## 1. Résumé exécutif

Le projet est une application web PHP monolithique organisée selon le pattern MVC (Model-View-Controller) avec un Front Controller (`public/index.php`).

Les dépendances sont gérées par Composer.
Le routeur est AltoRouter, la présentation est assurée par des templates PHP (`.tpl.php`) et les règles de sécurité et de réécriture sont gérées via des fichiers `.htaccess`.

## 2. Technologies et patterns

- **Langage** : PHP >=7.x.
- **Gestion des dépendances** : Composer (`composer.json`, `vendor/`).
- **Routage** : AltoRouter (package vendor/altorouter).
- Bootstrap 5.1 (UI)
- Font Awesome 4.7 (icônes)
- **Organisation** : Architecture MVC, PSR-4 (namespace `App\` => dossier `app/`).
- **Front Controller** : `public/index.php` comme point d'entrée unique.
- **Templates** : vues PHP (`app/views/*.tpl.php`).
- **Base de données MySQL** : Accès via un utilitaire `App\Utils\Database` (PDO) et modèles Active Record.
- **Sécurité / Accès** : `.htaccess` pour protection de répertoires. Contrôle d'accès centralisé via `CoreController` (ACL / rôles).
- **Débogage** : Symfony var-dumper présent dans `vendor`.

## 3. Vue d'ensemble architecturale

- **Approche** : Monolithe organisé en couches (presentation / controllers / models / utils). Les vues restent découplées du code métier et sont rendues par les controllers.
- **Principes guidant le design** : séparation des préoccupations (MVC), simplicité pour CRUD, sécurité par isolation (fichiers non publics protégés), conventions PSR-4 pour autoload.
- **Frontières** :
  - Public / web root (`public/`) contient uniquement le Front Controller et les assets.
  - Code applicatif (`app/`) non accessible directement par HTTP.
  - Vendor / Composer pour dépendances externes.

## 4. Visualisation

```md
├── 📁 app/
│   ├── 📁 Controllers/
│   │   ├── 📄 .htaccess
│   │   ├── 🐘 AppUserController.php
│   │   ├── 🐘 CategoryController.php
│   │   ├── 🐘 CoreController.php
│   │   ├── 🐘 ErrorController.php
│   │   ├── 🐘 MainController.php
│   │   └── 🐘 ProductController.php
│   ├── 📁 Models/
│   │   ├── 📄 .htaccess
│   │   ├── 🐘 AppUser.php
│   │   ├── 🐘 Brand.php
│   │   ├── 🐘 Category.php
│   │   ├── 🐘 CoreModel.php
│   │   ├── 🐘 Product.php
│   │   └── 🐘 Type.php
│   ├── 📁 Routes/
│   │   ├── 🐘 AppUserRouter.php
│   │   ├── 🐘 CategoryRouter.php
│   │   └── 🐘 ProductRouter.php
│   ├── 📁 Utils/
│   │   ├── 📄 .htaccess
│   │   └── 🐘 Database.php
│   ├── 📁 views/
│   │   ├── 📁 category/
│   │   │   ├── 🐘 category-add-update.tpl.php
│   │   │   ├── 🐘 category-add.tpl.php
│   │   │   ├── 🐘 category-list.tpl.php
│   │   │   └── 🐘 manage.tpl.php
│   │   ├── 📁 error/
│   │   │   ├── 🐘 err403.tpl.php
│   │   │   └── 🐘 err404.tpl.php
│   │   ├── 📁 layout/
│   │   │   ├── 🐘 footer.tpl.php
│   │   │   └── 🐘 header.tpl.php
│   │   ├── 📁 main/
│   │   │   └── 🐘 home.tpl.php
│   │   ├── 📁 partials/
│   │   │   └── 🐘 nav.tpl.php
│   │   ├── 📁 product/
│   │   │   ├── 🐘 product-add.tpl.php
│   │   │   └── 🐘 product-list.tpl.php
│   │   ├── 📁 user/
│   │   │   ├── 🐘 login.tpl.php
│   │   │   ├── 🐘 user-add.tpl.php
│   │   │   └── 🐘 user-list.tpl.php
│   │   └── 📄 .htaccess
│   ├── 📄 .htaccess
│   ├── ⚙️ config.ini 🚫 (auto-hidden)
│   └── 📄 config.ini.dist 🚫 (auto-hidden)
├── 📁 docs/
│   ├── 📁 integration-html-css/
│   │   ├── 📁 css/
│   │   │   └── 🎨 style.css
│   │   ├── 🌐 categories.html
│   │   ├── 🌐 category_add.html
│   │   └── 🌐 index.html
│   ├── 📝 Project_Folders_Structure_Blueprint.md
│   ├── 🗄️ MPD.sql
│   ├── 🗄️ images.sql
│   ├── 📝 routes.md
│   ├── 📝 serveur_de_dev_php.md
│   └── 📝 user_stories.md
├── 📁 public/
│   ├── 📁 assets/
│   │   ├── 📁 css/
│   │   │   ├── 📄 .keep
│   │   │   └── 🎨 style.css
│   │   ├── 📁 images/
│   │   │   └── 📄 .keep
│   │   └── 📁 js/
│   │       └── 📄 .keep
│   ├── 📁 sessions/
│   │   ├── 🐘 add-session.php
│   │   ├── 🐘 read-session.php
│   │   └── 🐘 update-session.php
│   ├── 📄 .htaccess
│   └── 🐘 index.php
├── 📁 vendor/ 🚫 (auto-hidden)
├── 🚫 .gitignore
├── 📖 README.md
├── 📄 composer.json
├── 🔒 composer.lock 🚫 (auto-hidden)
└── 🐚 import-external-repo.sh
```

### Architecture globale (niveau 1)

- Client (navigateur)
  -> HTTP
- Web Server (Apache / PHP-FPM)
  -> `public/index.php` (Front Controller)
  -> AltoRouter dispatch
  -> Controller approprié (`App\Controllers\*Controller`)
  -> Modèles (`App\Models\*`) via `App\Utils\Database`
  -> Vues (`app/views/*`) retournées au client

### Composants et interactions (niveau 2)

- Router (AltoRouter)
  - Mappe l'URL vers la paire controller/method
- Controllers (CoreController, MainController, ProductController, etc.)
  - Valide l'entrée, contrôle l'accès, appelle les Models
  - Prépare les données et inclut les templates
- Models (Product, Category, AppUser, Brand, Type)
  - Encapsulent la logique d'accès aux données (Active Record)
  - Utilisent `Database` singleton pour exécuter des requêtes
- Utils/Database
  - Singleton de connexion PDO, méthodes utilitaires pour requêtes
- Views (.tpl.php)
  - Templates PHP, fragmentés en `layout/`, `partials/`, et dossiers par domaine

### Flux de données (exemple création produit)

Client -> POST /product/create -> ProductController::create()
ProductController::create() -> validation -> Product model -> Database -> INSERT
-> redirection ou rendu de la vue de confirmation

## 5. Composants clés (détails)

Pour chaque composant : rôle, structure interne, interactions, patterns d'évolution.

- CoreController
  - Rôle : point central de fonctionnalités partagées (auth, rendu, ACL).
  - Implémentation : méthodes utilitaires pour afficher des vues (`show()`), contrôler les accès.
  - Interaction : tous les controllers héritent de CoreController.
  - Evolution : ajouter des hooks middleware (pré/post action) si nécessaire.

- Controllers métier (ProductController, CategoryController, AppUserController)
  - Rôle : implémenter les cas d'utilisation (CRUD, formulaires, actions métier).
  - Pattern : méthodes nommées REST-like (list, add, edit, create, update, delete).
  - Interaction : consomment les Models, renvoient des vues.

- Models (CoreModel, Product, Category, Brand, Type, AppUser)
  - Rôle : représenter entités et opérations DB.
  - Pattern : Active Record (méthodes statiques `findAll`, `find`, `save`, `delete`).
  - Limitations : mélange possible d'accès DB et logique métier — envisager extraction en Repository/Service si complexité augmente.

- Utils/Database
  - Rôle : gestion de la connexion et exécution des requêtes.
  - Pattern : Singleton + PDO.
  - Recommandation : exposer des méthodes parametrées, préparer les requêtes pour éviter injection SQL.

- Views
  - Rôle : rendu HTML via templates PHP; layout partagé (`header.tpl.php` / `footer.tpl.php`).
  - Pattern : inclusion simple (`require`) et extraction de variables pour templates.
  - Recommandation : standardiser helpers pour échappement HTML.

## 6. Couches et dépendances

- **Couche présentation** (views) : dépend des controllers (uni-directionnel).
- **Couche application** (controllers) : dépend des modèles et utils.
- **Couche domaine/persistante** (models) : dépend de Utils/Database.

Dépendances dirigées top-down (views <- controllers <- models <- utils). Pas d'injection de dépendance lourde; le code utilise héritage et appels statiques.

> [!WARNING]
> **Risques identifiés** :
>
> Potentielles violations si de nouvelles views incluent des accès DB directement.
>
> Absence d'un conteneur DI rend les tests unitaires plus difficiles.

## 7. Data architecture

- **Modèle de domaine** : entités classiques (Product, Category, Brand, Type, AppUser).
- **Accès aux données** : méthodes statiques / instance sur modèles et `Database` pour exécution SQL.
- **Recommandations** : si les requêtes complexes se multiplient, introduire des Repository classes et mapper DTOs pour séparations.
- **Validation des données** : majoritairement dans controllers; envisager déplacer règles dans un service de validation réutilisable.
- **Caching** : aucun mécanisme de cache.

## 8. Cross-cutting concerns

- **Authentification & Autorisation**
  - Implémentation : centralisée dans `CoreController` (vérification de session / rôle).
  - Recommandation : formaliser une couche Auth service et centraliser les checks via middleware-like hooks.

- **Gestion d'erreurs & résilience**
  - Implémentation : `ErrorController` pour affichage d'erreurs 403/404.
  - Recommandation : capturer exceptions globalement dans Front Controller et logger les erreurs.

- **Logging & monitoring**
  - Observations : pas de solution de logging explicite (pas de Monolog trouvé). Recommander d'ajouter un logger (Monolog) et d'instrumenter erreurs/évènements critiques.

- **Validation**
  - Observations : validations présentes côté controller. Recommander extraction vers des validateurs réutilisables.

- **Configuration**
  - `app/config.ini.dist` fourni ; la pratique recommandée est de ne pas versionner `config.ini` (actuellement `.dist` + copier localement).
  - Recommandation : utiliser variables d'environnement pour secrets (DB), ou un loader sécurisé.

## 9. Communication et API

- **Communication interne** : appels directs PHP (méthodes) — pas de microservices.
- **Protocoles externes** : HTTP via routes pour UI; pas d'API exposée par défaut (mais pattern REST-like présent pour controllers).
- **Versioning** : aucune stratégie d'API versioning.

## 10. Patterns d'implémentation observés

- PSR-4 autoloading (`App\`)
- Front Controller + AltoRouter dispatch
- Active Record pour modèles
- Singleton pour `Database`
- Templates PHP (no template engine externe)
- .htaccess pour protection et rewrite

**Recommandations d'amélioration** :

- Introduire une couche Service entre Controllers et Models pour séparer logique métier et persistance.
- Introduire un conteneur léger DI (p.ex. PHP-DI) pour faciliter le test et l'injection d'un logger, DB, etc.

## 11. Tests

- **TODO** : créer dossier `tests/`.
- **Recommandations** :
  - Ajouter tests unitaires pour Models et Services (PHPUnit).
  - Ajouter tests d'intégration pour routes critiques.
  - Mettre en place un job CI simple (composer install + phpunit).

## 12. Déploiement & opérationnel

- Entrée de déploiement : `public/` comme webroot.
- Déploiement recommandé : Apache + PHP-FPM avec `public/` comme DocumentRoot et règles `.htaccess` ou config serveur équivalente.
- Développement local : `php -S 0.0.0.0:8080 -t public` documenté dans `docs/`.
- Conteneurisation : pas d'artefacts Docker fournis — pattern possible : container PHP-FPM + Nginx/Apache, volume pour storage si sessions locales.

## 13. Sécurité

> [!IMPORTANT]
> Fichiers `.htaccess` présents pour empêcher l'accès direct aux dossiers sensitifs.
>
> **Recommandations de sécurité immédiates** :
>
> - Stocker secrets hors du repo (variables d'environnement ou vault).
> - Valider et échapper toutes les sorties HTML (prévenir XSS).
> - Préparer toutes les requêtes SQL via PDO prepared statements (prévenir injection SQL).
> - Forcer HTTPS au niveau serveur / redirections.

## 14. Extensibilité et évolution

**Principes pour étendre sans casser l'architecture** :

- Ajout de domaine / feature :
  - Créer `app/Models/[Domain].php` pour la représentation des données.
  - Créer `app/Controllers/[Domain]Controller.php` héritant de `CoreController`.
  - Créer `app/Routes/[Domain]Router.php` pour regrouper les routes du domaine.
  - Créer `app/views/[domain]/` avec les templates `list.tpl.php`, `add-update.tpl.php`.

- **Pour fonctionnalités complexes** : déplacer logique métier dans des services (`app/Services/`) et utiliser des Repositories pour accès DB.

- **Migration progressive vers tests** : commencer par ajouter tests pour nouveaux composants, fixer une politique de couverture minimale pour code critique.

## 15. Exemples d'implémentation (extraits représentatifs)

- Modèle : méthode `findAll()` typique

```php
// ...existing code...
public static function findAll()
{
    $sql = "SELECT * FROM product";
    $db = Database::getPDO();
    $stmt = $db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
}
// ...existing code...
```

- Controller : redirection après action

```php
// ...existing code...
header('Location: /product/list');
exit; // s'assurer d'arrêter l'exécution
// ...existing code...
```

Recommandation : ajouter `exit;` après `header('Location: ...')` et vérifier l'absence d'output préalable.

## 16. Architectural Governance

- **Processus de décision** : documenter les décisions majeures (choix de patterns, nouvelles dépendances) dans `docs/architecture-decisions.md`.
- **Revue** : ajouter une checklist de revue PR axée architecture (nouvelles dépendances, changements DB, migrations).
- **Contrôles automatisés** :
  - `composer validate`
  - linters PHP (p.ex. PHP_CodeSniffer) pour respecter conventions
  - tests unitaires dans CI

## 17. Guide pour nouveaux développements

- **Workflow recommandé pour ajouter une fonctionnalité CRUD** :
  1. Créer/mettre à jour Model
  2. Créer Controller (héritant CoreController)
  3. Ajouter routes dans `app/Routes/*Router.php` ou nouveau fichier router
  4. Créer templates dans `app/views/[domain]/`
  5. Ajouter tests unitaires pour Model et integration pour controller
  6. Mettre à jour navigation (`app/views/partials/nav.tpl.php`) si visible par l'UI

- **Pièges courants** :
  - Eviter d'ajouter du SQL dans les templates.
  - Ne pas effectuer d'echo direct avant les appels à `header()`.
  - Centraliser la validation pour éviter duplication.

## 18. Liste de recommandations prioritaires (roadmap court terme)

1. Ajouter un logger (Monolog) et instrumenter erreurs critiques.
2. Introduire tests unitaires (PHPUnit) et intégrer dans CI.
3. Extraire règles de validation dans une couche réutilisable.
4. Préparer plan d'introduction d'un conteneur DI léger.
5. Documenter convention de commit et revue pour décisions architecturales.

## 19. Annexes

- **Emplacement des fichiers clés** :
  - Front Controller : `public/index.php`
  - Routes : `app/Routes/` (CategoryRouter.php, ProductRouter.php, AppUserRouter.php)
  - Controllers : `app/Controllers/` (CoreController.php, ProductController.php...)
  - Models : `app/Models/` (CoreModel.php, Product.php...)
  - Views : `app/views/`
  - Utilitaires : `app/Utils/Database.php`

- Commandes utiles :

```bash
# Installer dépendances
composer install

# Lancer serveur de dev
php -S 0.0.0.0:8080 -t public
```

---
