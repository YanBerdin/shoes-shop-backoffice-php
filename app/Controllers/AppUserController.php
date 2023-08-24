<?php

namespace App\Controllers;

use App\Models\AppUser;

class AppUserController extends CoreController
{
    public function login()
    {
        $this->show('user/login');
    }

    public function loginUser()
    {
        // dump($_POST);
    }
}
