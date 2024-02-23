<?php

namespace App\Controllers;

use App\Models\AppUser;
use App\Controllers\CoreController;


class AppUserController extends CoreController
{
    // Affichage du formulaire de connexion
    public function login()
    {
        $this->show('user/login');
    }

    /**
     * Traitement du formulaire de connexion
     *
     * @return void
     */
    public function loginUser()
    {
        // dump($_POST);
        $errorList = [];

        if (!empty($_POST['email']) && !empty($_POST['password'])) {

            // On récupère les données et on passe par filter_input
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

            // Pour le mot de passe, éviter le sanitize qui risque de retirer des caractères
            $password = filter_input(INPUT_POST, 'password');

            $user = AppUser::findByEmail($email);

            if ($user != false) {
                if (password_verify($password, $user->getPassword())) {
                    // Envoie un en-tête de redirection au navigateur
                    header('Location: /');

                    // Ajouter les données (userId et userObject) à la session
                    $_SESSION['userId'] = $user->getId();
                    $_SESSION['userObject'] = $user;
                    echo ' => User id = ' . $_SESSION['userId'];
                } else {
                    // Le mot de passe n'est pas bon, mais on reste flou côté site
                    $errorList[] = "Email et/ou mot de passe incorrects";
                }
            } else {
                // l'email n'a pas été trouvé dans la BDD
                $errorList[] = "Email et/ou mot de passe incorrects";
            }
        } else {
            $errorList[] = "Merci de renseigner les champs du formulaire !";
        }

        // Affiche la vue login en envoyant le tableau d'erreurs
        $this->show("user/login", [
            "errors" => $errorList
        ]);
    }

    /**
     * Déconnecter le user connecté
     *
     * @return void
     */
    public function logout()
    {
        // Vider les données de session
        session_destroy();

        // Une fois déconnecté, rediriger vers le login
        header("Location: " . $this->router->generate("user-login"));
        exit();
    }

    /**
     * Méthode pour afficher la liste de tous les users
     * 
     * @return void
     */
    public function userList()
    {
        $users = AppUser::findAll();

        $this->show('user/user-list', [
            'users' => $users
        ]);
    }

    /**
     * Afficher le formulaire d'ajout d'un user
     *
     * @return void
     */
    public function addUser()
    {
        $this->show('user/user-add', [
            'user' => new AppUser,
            'errors' => [],
        ]);
    }

    /**
     * Méthode de création d'un user
     *
     * @return void
     */
    public function createUser()
    {
        // Récupèrer les données POST du form
        if (!empty($_POST)) {

            // Les vérifier (filter_input)
            $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
            $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); // FILTER_VALIDATE_EMAIL utilisé par PierreOclock
            $password = filter_input(INPUT_POST, 'password');                  //! Pas de FILTER
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

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

            // Vérifier la complexité du mot de passe
            // $uppercase = preg_match('@[A-Z]@', $password);
            // $lowercase = preg_match('@[a-z]@', $password);
            // $number = preg_match('@[0-9]@', $password);
            // $specialChars = preg_match('@[^\w]@', $password);

            // if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            //     $errorList[] = '⛔ Création refusée ⛔ Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.';
            // }

            // Vérifier la validité du mot de passe
            if (strlen($password) < 5) {
                $errorList[] = "Le mot de passe doit faire au moins 5 caractères.";
            }

            if (empty($errorList)) {
                // Ajout du user en BDD => commencer par créer un nouveau AppUser (ActiveRecord !)
                $modelUser = new AppUser();

                $modelUser->setEmail($email);
                $modelUser->setFirstname($firstname);
                $modelUser->setLastname($lastname);
                $modelUser->setRole($role);
                $modelUser->setStatus($status);

                //* Attention : password saisi en clair dans le formulaire
                // Hasher le password avant de l'insérer en BDD
                // Rappel : en BDD, le password doit être hashé
                // A la saisie du form, récuèrer le password clair, le hasher
                // et comparer le hash au password de la BDD
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);  // (PASSWORD_DEFAULT ou PASSWORD_BCRYPT)
                $modelUser->setPassword($hashedPassword);

                // Appeller la méthode du Model AppUser pour faire l'insertion en BDD
                if ($modelUser->insert()) {
                    // insertion OK => redirection vers la liste des users
                    header("Location: " . $this->router->generate("user-list"));
                    exit();
                } else {
                    // insertion KO => ajouter ereur dans errorList[]
                    // et rediriger vers le form d'ajout
                    $this->show('user/user-add', [
                        'errors' => $errorList,
                        'insertionError' => "Erreur lors de l'insertion en BDD"
                        // extract génère $errors & insertionError
                    ]);
                }
            } else {
                // Ici,au moins 1 erreur au niveau des champs du formulaire
                $modelUser = new AppUser();

                //MAJ les propriétés
                $modelUser->setEmail($email);
                $modelUser->setFirstname($firstname);
                $modelUser->setLastname($lastname);
                $modelUser->setRole($role);
                $modelUser->setStatus($status);

                //* Hasher le password avant de l'insérer en BDD
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $modelUser->setPassword($hashedPassword);
                // Syntaxe + concise
                // $modelUser->setPassword(password_hash($password, PASSWORD_BCRYPT));

                $this->show('user/user-add', [
                    'errors' => $errorList,
                    'user' => $modelUser
                ]);
            }
        }
    }
}
