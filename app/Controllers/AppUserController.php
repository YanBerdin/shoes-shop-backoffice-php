<?php

namespace App\Controllers;

use App\Models\AppUser;
use App\Controllers\CoreController;


class AppUserController extends CoreController
{
    //! Affichage du formulaire
    public function login()
    {
        $this->show('user/login');
    }

    // Traitement du formulaire
    // public function loginUser()
    // {
    // dump($_POST);
    // }

    //! Traitement du formulaire
    public function loginUser()
    {
        // dump($_POST);

        if (!empty($_POST)) {
            // Manière de récupérer les données simplement via $_POST
            // $email = $_POST['email'];
            // $password = $_POST['password'];

            // On récupère les données et on passe par filter_input
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');

            // Objectif : à la connexion, vérifier si :
            // - l'email existe bien en BDD
            // - si oui, alors on vérifie aussi le password

            // On utilise le Model AppUser pour récupérer les données Utilisteur
            $user = AppUser::findByEmail($email);

            // Est-ce que cet email existe et correspond bien à un user ?
            // $user contient soit un user (instance de AppUser) soit false
            if ($user != false) {
                //! On rentre ici, cad l'email existe bien en BDD
                // Alors on vérifie aussi le password

                //? $user->getPassword() permet de récupérer le password du User
                //? $password correspond au password saisi dans le form                
                // V1 : avec un BDD non sécurisée cad avec mots de passe en clair,
                // on peut directement comparer mot de passe saisi et mot de passe de la BDD
                // if ($user->getPassword() == $password) {
                //! V3 : on doit modifier le if précédent car à présent tous les password sont hashés
                // https://www.php.net/manual/fr/function.password-verify.php
                if (password_verify($password, $user->getPassword())) {
                    //! Email et password associé sont bons
                    // OK, on pourra connecter le user
                    // V1 : on affiche "Vous êtes bien connecté"
                    echo "Vous êtes bien connecté";

                    //! V2 Bonus : on ajoute les données (userId et userObject) à la session
                    // On récupère ces 2 données pour les stocker dans la session
                    $_SESSION['userId'] = $user->getId();
                    $_SESSION['userObject'] = $user;
                    echo ' => User id = ' . $_SESSION['userId'];
                } else {
                    //! Le mot de passe n'est pas bon, mais on reste flou côté site
                    // #modeparanocontreleshackers
                    echo "Email et/ou mot de passe incorrects";
                }
            } else {
                //! Dans ce cas, l'email n'a pas été trouvé (dans la BDD, aucun user n'existe avec cet email)
                // L'email n'est pas bon, mais on reste flou côté site
                // #modeparanocontreleshackers
                echo "Email et/ou mot de passe incorrects";
            }
        } else {
            //! Ici, le form est vide car $_POST ne contient aucune donnée
            // (ne risque pas vraiment d'arriver car Require dans le formulaire)
            echo "Merci de renseigner les champs du formulaire";
        }
    }

    //? S06 E06
    /**
     * Méthode qui récupère la liste de tous les users
     * 
     * @return void
     */
    public function userList()
    {
        // Atelier E05 : Etape 2
        // On appelle checkAuthorization() pour que les user admin puissent seulement
        // accéder à cette liste
        //$this->checkAuthorization(['admin']);

        // V2 : plus nécessaire ici car on utilise maintenant les ACL

        // Atelier E05 : Etape 1
        // On récupère tous les users
        $users = AppUser::findAll();

        // On appelle show en lui transmettant la liste ds users
        $this->show('user/user-list', [
            'users' => $users
        ]);
    }

    //? S06 E06
    /**
     * Méthode pour afficher le formulaire d'ajout d'un user
     *
     * @return void
     */
    public function addUser()
    {
        // On restreind l'accès pour ne laisser les droits qu'aux admin
        //$this->checkAuthorization(['admin']);

        $this->show('user/user-add', [
            // Si on prébvoit une évolution du form vers add | update
            // alors on peut déjà passer une instance de AppUser
            'user' => new AppUser,
            'errors' => [],
        ]);
    }
}
