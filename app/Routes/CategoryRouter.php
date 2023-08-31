<?php

// Route pour afficher la liste des catégories
$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'listCategories',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-list'
);

// Route pour afficher le formulaire d'ajout/Modif d'une catégorie
$router->map(
    'GET',
    '/category/add-update',
    [
        'method' => 'addCategory',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-add-update' // Dans ACL
);


// Route pour faire le traitement du formulaire de création d'une catégorie
$router->map(
    'POST',
    '/category/add-update',
    [
        'method' => 'createOrUpdateCategory',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-create' // TODO ajouter -update et MAJ liens dans TPL
);  // Dans ACL

// Route pour afficher le formulaire de modification d'une catégorie
$router->map(
    'GET',
    '/category/add-update/[i:id]',
    [
        'method' => 'editCategory',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-edit' // Dans ACL
);

// Route pour faire le traitement du formulaire 
// de modification d'une catégorie
$router->map(
    'POST',
    '/category/add-update/[i:id]',
    [
        'method' => 'createOrUpdateCategory',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-update'  // Dans ACL
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
