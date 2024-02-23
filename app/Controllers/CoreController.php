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
    // public function __construct()
    public function __construct($router, $match)
    {
        // propriétés protected => tout les Controllers qui héritent de CoreController
        // hériteront également de ces propriétés
        $this->router = $router;
        $this->match  = $match;

        // On définit une liste des permissions
        // ACL : Access Control List
        // https://fr.wikipedia.org/wiki/Access_Control_List

        //* Pas de route "publique" comme Login
        // Rappel Nom de la Route (PAS CHEMIN)
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

        // Récupèrer le nom de la route
        $routeName = $match['name'];

        if (array_key_exists($routeName, $acl)) {
            // Récupèrer la liste des rôles autorisés
            $authorizedRoles = $acl[$routeName];

            // check
            $this->checkAuthorization($authorizedRoles);
        }
    }

    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
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
     * Méthode "helper" qui sera appellée dans les Controllers
     * Verifie si dans la SESSION on a un userId
     * pour vérifier si le user peut accéder à la page demandée
     *
     * @return void
     */
    protected function checkAuthorization($authorizedRoles = [])
    {
        // Si le user est connecté
        if (isset($_SESSION['userId'])) {
            // Récupèrer le user via la session pour avoir accès à son rôle
            $user = $_SESSION['userObject'];

            // Récupèrer son rôle
            $role = $user->getRole();

            // Vérifier si son rôle permet d'accéder à la page demandée
            // => vérification à partir d'un array des rôles autorisés
            if (in_array($role, $authorizedRoles)) {
                // si son rôle le permet
                return true;
            } else {
                // sinon => 403 "Forbidden"
                // Envoyer le code 403 dans le header
                http_response_code(403);
                echo 'Oups, une erreur 403, Accès => Refusé';

                // Envoyer un header d’erreur cf Ajax Kourou
                header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden', true, 403);
                
                //* stopper l'exécution du script
                // Sinon affiche quand même la page demandée (category-list) 
                exit();

                // Amélioration possible : créer un template 403 
                // $this->show( "error/err403" );
            }
        } else {
            // Si le user n'est pas connecté
            // Redirection vers page de connexion
            header("Location: " . $this->router->generate("user-login"));

            //* stopper l'exécution du script
            exit();
        }
    }
}
