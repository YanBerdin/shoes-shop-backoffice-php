<?php

namespace App\Controllers;

class CoreController
{
    protected $router;
    protected $match;

    /**
     * Constructeur : systématiquement et automatiqueent appelé
     * (à l'appel de la classe ou lors d'une nouvelle isntanciation)
     */
    public function __construct($router, $match)
    {
        // protected => accès propriétés de CoreController
        $this->router = $router;
        $this->match  = $match;

        // Rappel Nom de la Route (PAS CHEMIN) Pas de route "publique"
        $acl = [
            'category-add-update' => ['admin', 'catalog-manager'],
            'category-create' => ['admin', 'catalog-manager'],
            'category-edit' => ['admin', 'catalog-manager'],
            'category-update' => ['admin', 'catalog-manager'],
            'product-add' =>  ['admin', 'catalog-manager'],
            'product-create' => ['admin', 'catalog-manager'],
            'user-list' => ['admin'],
            'user-add' => ['admin'],
            'user-create' => ['admin'],
            'category-manage' => ['admin', 'catalog-manager'],
            'category-select' => ['admin', 'catalog-manager']
        ];

        $routeName = $match['name'];

        if (array_key_exists($routeName, $acl)) {
            // liste rôles autorisés
            $authorizedRoles = $acl[$routeName];
            $this->checkAuthorization($authorizedRoles);
        }
    }

    /**
     * Afficher du code HTML via les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * valeur par defaut array vide, parametre facultatif
     * @return void 
     */
    protected function show(string $viewName, $viewData = [])
    {
        // valeur définie dans show() = Dispo dans TOUTES les vues
        $viewData['router'] = $this->router;
        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        //* /!\ != racine projet => ici = répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // extract() crée une variable pour chaque élément du tableau passé en argument
        extract($viewData);
        // (importe les variables à partir des clés)
        //? => la variable $currentPage existe désormais, et sa valeur est $viewName
        //? => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        //? => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']

        // Pour voir le nom de la Route pour la class active du menu
        // "-" sera un "/" dans la barre d'adresse

        //dump($currentPage);

        //TODO variables disponibles dans nos vues
        //* A ne pas laisser en PROD !
        // dump(get_defined_vars());

        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }


    /**
     * Verifie si un userId est dans la SESSION
     * Vérifie si le user peut accéder à la page demandée
     *
     * @return void
     */
    protected function checkAuthorization($authorizedRoles = [])
    {
        // Si user connecté
        if (isset($_SESSION['userId'])) {
            // Récupèrer user ds la session
            $user = $_SESSION['userObject'];

            // Récupèrer son rôle
            $role = $user->getRole();

            // => vérification à partir d'un array des rôles autorisés
            if (in_array($role, $authorizedRoles)) {
                // si son rôle ok
                return true;
            } else {
                // sinon => 403 "Forbidden"
                // Envoyer le code 403 dans le header
                http_response_code(403);
                echo 'Oups, une erreur 403, Accès => Refusé';

                // Envoyer un header d’erreur
                header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden', true, 403);

                //* stopper l'exécution du script
                // Sinon affiche quand même la page 
                exit();
            }
        } else {
            // Si le user pas connecté
            // Redirection vers page de connexion
            header("Location: " . $this->router->generate("user-login"));

            //* stopper l'exécution du script
            exit();
        }
    }
}
