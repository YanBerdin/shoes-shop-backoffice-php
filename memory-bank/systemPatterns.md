# systemPatterns.md

## Architecture

- Monolithe PHP, pattern MVC strict
- Front Controller unique (`public/index.php`)
- Routage modulaire via AltoRouter
- Séparation stricte Controllers/Models/Views/Utils
- PSR-4 pour autoloading

## Décisions techniques clés

- Utilisation de Singleton pour la connexion DB
- Active Record pour les modèles
- Templates PHP pour les vues
- Contrôle d'accès centralisé dans CoreController

## Relations entre composants

- Controllers héritent de CoreController
- Models héritent de CoreModel
- Views appelées par les controllers
- Utils/Database utilisé par les models
