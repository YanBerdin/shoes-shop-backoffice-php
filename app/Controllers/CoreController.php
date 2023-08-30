<?php

namespace App\Controllers;

class CoreController
{
    /**
     * Constructeur : systématiquement et automatiqueent appelé
     * (à l'appel de la classe ou lors d'une nouvelle isntanciation)
     */
    public function __construct()
    {
        //! On définit une liste des permissions
        // ACL : Access Control List
        // https://fr.wikipedia.org/wiki/Access_Control_List
        // Ici, on fait une correspondance entre nom de la route et rôles ayant les permissions
        // Les routes ne nécessitant pas de gestion de permission n'ont rien à faire là
        // (elles ne seront pas listées dans $acl)
        //TODO Nom de la Route PAS CHEMIN !!!
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
            'category-select' => ['admin', 'catalog-manager'],
        ];

        // On va regarder si l'URL demandée (cad la route concernée)
        // nécessite un contrôle
        // Si la route demandée est dans la liste des routes à vérifier (cad dans $acl)
        // alors on devra appeler checkAuthorization()
        // On a donc besoin de la route actuelle : $match['name']
        // ==> On doit donc récupérer $match
        global $match;
        // On récupère à présent le nom de la route
        $routeName = $match['name'];

        //! Si la route demandée est dans la liste des routes à vérifier
        //! (cad dans $acl)
        if (array_key_exists($routeName, $acl)) {
            // On  récupère la liste des rôles autorisés
            $authorizedRoles = $acl[$routeName];

            //! On appelle le check
            $this->checkAuthorization($authorizedRoles);
        }
        // else ? ==> pas besoin de else car si on ne rentre pas dans le if, ça signifie 
        // que la route n'est pas dans la liste $acl des routes à vérifier
        // cad toute le monde peut accéder librement et directement à cete route

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
        // On globalise $router car on ne sait pas faire mieux pour l'instant
        global $router;

        // Comme $viewData est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        //! ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()

        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        //! /!\ != racine projet => ici on parle du répertoire public/
        // Rappel 0.0.0.0:8080 = public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);
        // (importe les variables à partir des clés)
        //TODODone => la variable $currentPage existe désormais, et sa valeur est $viewName
        //TODODone => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        //TODODone => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        //TODODone => il en va de même pour chaque élément du tableau

        //? Pour voir le nom de la Route pour la class active du menu
        //? "-" sera un "/" dans la barre d'adresse
        
        //dump($currentPage);

        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }


    /**
     * Méthode "helper" qui sera appellée dans les Controllers
     * ! Verifie si dans la SESSION on a un userId
     * pour vérifier si le user peut accéder à la page demandée
     *
     * @return void
     */
    protected function checkAuthorization($authorizedRoles = [])
    {
        //! Si le user est connecté
        if (isset($_SESSION['userId'])) {
            // On récupère le user via la session pour avoir accès à son rôle
            $user = $_SESSION['userObject'];

            //! On récupère son rôle
            $role = $user->getRole();

            // On vérifie si son rôle permet d'accéder à la page demandée
            // => vérification à partir d'un array des rôles autorisés
            if (in_array($role, $authorizedRoles)) {
                //! si son rôle le permet => ok : on retourne true
                return true;
            } else {
                // sinon => ko : on renvoie une 403 "Forbidden"
                //! On envoie le code 403 dans le header
                http_response_code(403);
                echo 'Oups, une erreur 403';
                //! On stop l'exécution du script (vu que y a pas de return)
                // Sinon affiche quand même la page demandée (category-list) 
                exit();
                // Amélioration possible : créer un template 403 
                // et rediriger vers cette page dédiée
            }
        } else {
            // Si le user n'est pas connecté
            // alors on le redirige vers la page de connexion
            header('Location: /user/login');
            //! On stop l'exécution du script
            // (au cas où par sécurité pour sortir)
            exit();
        }
    }
}
