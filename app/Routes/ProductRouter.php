<?php
// Route pour afficher la liste des produits
$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'listProducts',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-list'
);

// Route pour afficher le formulaire de création d'un produit
$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'addProduct',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-add'
);

// Route pour faire le traitement du formulaire et créer un produit
$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'createProduct',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-create'  // Dans ACL
);

