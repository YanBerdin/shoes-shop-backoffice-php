<?php 

// Affichage du form user
$router->map(
    'GET',
    '/user/login',
    [
        'method' => 'login',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'user-login'
);

// Traitement du form user
$router->map(
    'POST',
    '/user/login',
    [
        'method' => 'loginUser',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'user-check' //? A mettre aussi ? Voir ALEC
);

//? S06 E06

// Affichage de tous les users
$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'userList',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'user-list' // Dans ACL
);

// Affichage du formulaire de création (ajout) d'un user
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'addUser',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'user-add'  // Dans ACL
);

// Traitement du formulaire de création (ajout) d'un user
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'createUser',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'user-create'  // Dans ACL
);

//? S06 E07
// Route pour afficher le formulaire de gestion des catégories
$router->map(
    'GET',
    '/category/manage',
    [
        'method' => 'homeDisplay',
        'controller' => '\App\Controllers\CategoryController'        
    ],
    'category-manage' // Dans ACL
);

//? S06 E07
// Route pour faire le traitement du formulaire de gestion des catégories
$router->map(
    'POST',
    '/category/manage',
    [
        'method' => 'homeSelect',
        'controller' => '\App\Controllers\CategoryController'        
    ],
    'category-select' // Dans ACL
);
