<?php
// namespace App\Routes;

use App\Controllers\AppUserController;

// Affichage du form user
$router->map(
    'GET',
    '/user/login',
    [
        'method' => 'login',
        'controller' => AppUserController::class // '\App\Controllers\AppUserController'
    ],
    'user-login' // acces public
);

// Traitement du form user
$router->map(
    'POST',
    '/user/login',
    [
        'method' => 'loginUser',
        'controller' => AppUserController::class // '\App\Controllers\AppUserController'
    ],
    'user-check' // acces public
);

//? S06 E06

// Affichage de tous les users
$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'userList',
        'controller' => AppUserController::class // '\App\Controllers\AppUserController'
    ],
    'user-list' // Dans ACL
);

// Affichage du formulaire de création (ajout) d'un user
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'addUser',
        'controller' => AppUserController::class // '\App\Controllers\AppUserController'
    ],
    'user-add'  // Dans ACL
);

// Traitement du formulaire de création (ajout) d'un user
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'createUser',
        'controller' => AppUserController::class // '\App\Controllers\AppUserController'
    ],
    'user-create'  // Dans ACL
);

//? PierreOclock
$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => AppUserController::class // '\App\Controllers\AppUserController'
    ],
    'user-logout'
);
