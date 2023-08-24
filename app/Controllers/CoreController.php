<?php

namespace App\Controllers;

class CoreController
{
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
        //! /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);
        // (importe les variables à partir des clés)
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        //! $viewData est disponible dans chaque fichier de vue
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
            header('Location : /user/login');
            //! On stop l'exécution du script
            // (au cas où par sécurité pour sortir)
            exit();
        }
    }
}
