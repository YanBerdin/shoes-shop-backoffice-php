<?php

namespace App\Controllers;

use App\Models\AppUser;
use App\Controllers\CoreController;

class AppUserController extends CoreController
{
    // Affichage du formulaire
    public function login()
    {
        $this->show('user/login');
    }

    // Traitement du formulaire
    // public function loginUser()
    // {
        // dump($_POST);
    // }

    public function loginUser()
    {
        dump($_POST);

        if (!empty($_POST)) {
            // Manière de récupérer les données simplement via $_POST
            // $email = $_POST['email'];
            // $password = $_POST['password'];

            // On récupère les données et on passe par filter_input
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');

        }
    }
}