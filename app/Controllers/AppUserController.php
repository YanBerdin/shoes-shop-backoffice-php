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
                //? Peut importe qu'on ai hashé avec PASSWORD_BCRYPT ou PASSWORD_DEFAULT
                // password_verifiy le reconnaitra automatiquement
                if (password_verify($password, $user->getPassword())) {
                    //! Email et password associé sont bons
                    // OK, on pourra connecter le user
                    // V1 : on affiche "Vous êtes bien connecté"

                    // echo "Vous êtes bien connecté";
                    header('Location: /');

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

    //! Méthode de déconnexion du user connecté
    //? Pierre Oclock
    public function logout()
    {
        // Déconnecter un utilisateur revient a "oublier" quel coffre ouvre sa clé
        //  ou
        // Vider le contenu du coffre

        // Ici, on va garder la même clé mais vider le coffre
        // Ici unset détruit la clé 'user' du tableau de session
        // FIXME: //? ALEC ?
        // TODO Avec unset => BUG => Undefined $_SESSION['userObject']
        // TODO Pourtant Ok sur PierreOclock
        // FIXME: unset( $_SESSION['userObject'] );

        // On pourrait aussi détruire tout le coffre
        session_destroy();

        // Une fois déconnecté, rediriger vers le login
        // header( "Location: ".$this->router->generate( "user-login" ) );
        header('Location: /user/login');
        exit;
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
        // On appelle checkAuthorization() pour que seul un user admin
        // ait la permission d'accéder à cette liste
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
        //? ⛔ Etape 4 ⛔ 
        // On limite l'accès pour ne laisser les droits qu'aux admin
        //? Etape 6 checkAuthorization commenté 
        //? CoreController s'en occupe
        //$this->checkAuthorization(['admin']);

        $this->show('user/user-add', [
            //! Si on prébvoit une évolution du form vers add | update
            // alors on peut déjà passer une instance de AppUser
            // même avec un objet user vide => Pas d'erreur
            'user' => new AppUser,
            'errors' => [],
        ]);
    }

    public function createUser()
    {
        //? ⛔ Etape 4 ⛔ 
        // On limite l'accès pour ne laisser les droits qu'aux admin
        //? Etape 6 checkAuthorization commenté 
        //? CoreController s'en occupe
        // $this->checkAuthorization(['admin']);

        //! 1- On récupère les données POST du form
        if (!empty($_POST)) {
            // $firstname = $_POST['firstname'];     = Récupérer sans vérifier 
            // ...

            //! 2- On les vérifie (filter_input)
            $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
            $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); //FIXME: FILTER_VALIDATE_EMAIL utilisé par PierreOclock => Mieux ? Alec ?
            $password = filter_input(INPUT_POST, 'password');                  //FIXME: Pas de FILTER => Alec ?
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

            //! 3- On check les éventuelles erreurs
            // (s'il y en a, alors on les stocke dans un array $errorList)
            $errorList = [];

            if (empty($firstname)) {
                $errorList[] = '⛔ Création refusée ⛔ Merci de renseigner le prénom';
            }

            if ($firstname === false) {
                $errorList[] = '⛔ Création refusée ⛔ Merci de renseigner un prénom valide';
            }

            if (empty($lastname)) {
                $errorList[] = '⛔ Création refusée ⛔ Merci de renseigner le nom';
            }

            if ($lastname === false) {
                $errorList[] = '⛔ Création refusée ⛔ Merci de renseigner un nom valide';
            }

            if (empty($email)) {
                $errorList[] = "⛔ Création refusée ⛔ Merci de renseigner l'email";
            }

            if ($email === false) {
                $errorList[] = '⛔ Création refusée ⛔ Merci de renseigner un email valide';
            }

            if (empty($password)) {
                $errorList[] = '⛔ Création refusée ⛔ Merci de renseigner le mot de passe';
            }

            if ($password === false) {
                $errorList[] = '⛔ Création refusée ⛔ Merci de renseigner un mot de passe valide';
            }

            if (empty($role)) {
                $errorList[] = '⛔ Création refusée ⛔ Merci de renseigner le rôle';
            }

            if ($role === false) {
                $errorList[] = '⛔ Création refusée ⛔ Merci de renseigner un rôle valide';
            }

            if (empty($status)) {
                $errorList[] = '⛔ Création refusée ⛔ Merci de renseigner le statut';
            }

            if ($status === false) {
                $errorList[] = '⛔ Création refusée ⛔ Merci de renseigner un statut valide';
            }

            //? Version Pierre Oclock -------------------------------------------------------------
            // Si au moins un des champs n'est pas rempli ou si un des filtres a échoué
            //   if( !$email || !$password || !$firstname || !$lastname || !$role || !$status )
            //   {
            //     $errorList[] = "Tous les champs sont obligatoires";
            //   }

            //! Vérification de la validité du mot de passe
            if (strlen($password) < 5) {
                $errorList[] = "Le mot de passe doit faire au moins 5 caractères.";
            }
            // FIXME:
            // TODO Bonus : Vérifier la complexite ++ (voir Mega Bonus de l'atelier E06)
            //? FIN de Version Pierre Oclock-------------------------------------------------------


            //! Avant d'aller plus loin, on vérifiera si on a aucune erreur
            // (et si c'est le cas, on arrête le processus)
            if (empty($errorList)) {
                // On n'a rencontré aucune erreur

                //! 4- s'il n'y en a pas ==> on continue
                // on appelle le Model pour faire l'insertion
                // Ajout du user en BDD, on commence par créer un nouveau AppUser (ActiveRecord !)
                $modelUser = new AppUser();

                // On set les valeurs 
                //(cad on met les valeurs récupérées du form dans les propriétés de la nouvelle instance)
                // On met à jour les propriétés (Copyright Fanny)
                $modelUser->setEmail($email);
                $modelUser->setFirstname($firstname);
                $modelUser->setLastname($lastname);
                $modelUser->setRole($role);
                $modelUser->setStatus($status);

                //! Attention : le password est saisi en clair dans le formulaire
                //! On doit hasher le password avant de l'insérer en BDD
                // Rappel : en BDD, tous nos password doivent être hashés
                // A la saisie du form, on récuère le password clair qu'on va hasher
                // ET on va comparer le hash au password de la BDD
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);  //? PASSWORD_DEFAULT (utilisé par Pierre Oclock) Mieux ? Alec ?
                $modelUser->setPassword($hashedPassword);

                //FIXME: Faut il vérifier que le nombre de caractères saisi === nbr enregistré BDD ? FIXME: Alec ?

                // On appelle la méthode du Model AppUser pour faire l'insertion en BDD
                if ($modelUser->insert()) {
                    // insertion OK ==> on redirige vers la liste des user
                    header('Location: /user/list');
                    exit;
                } else {
                    //! insertion KO => message d'erreur 
                    //! (et ajouter une ereur dans errorList)
                    // et on redirige vers le form d'ajout
                    $this->show('user/user-add', [
                        'errors' => $errorList,
                        'insertionError' => "Erreur lors de l'insertion en BDD"
                        // extract génère $errors & insertionError
                    ]);
                }
            } else {
                //! Ici, on a au moins 1 erreur au niveau des champs du formulaire
                $modelUser = new AppUser();

                // On met à jour les propriétés (Copyright Fanny)
                $modelUser->setEmail($email);
                $modelUser->setFirstname($firstname);
                $modelUser->setLastname($lastname);
                $modelUser->setRole($role);
                $modelUser->setStatus($status);

                //TODO On doit hasher le password avant de l'insérer en BDD
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $modelUser->setPassword($hashedPassword);

                // Autre manière plus directe d'écrire les 2 lignes ci-dessus
                // $modelUser->setPassword(password_hash($password, PASSWORD_BCRYPT));

                $this->show('user/user-add', [
                    'errors' => $errorList,
                    'user' => $modelUser
                ]);
            }
        }
    }
}
