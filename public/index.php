<?php

// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
// => Donc plus besoin de Use (ex Require) des Models ou Controllers
require_once '../vendor/autoload.php';

/* ------------
--- ROUTAGE ---
-------------*/

// On var dump pour savoir ce que contient $_SERVER
// NB : si on avait un .htaccess, alors via la réécriture d'URL,
// on aurait eu une clé BASE_URI
// Ici, elle n'existe pas

// dd($_SERVER);
// var_dump($_SERVER);
// var_dump('BASE_URI');

// D'où notre page en erreur 404
// Solutions possibles :
// - créer un .htaccess
// - ou remplacer BASE_URI par REQUEST_URI

// création de l'objet router
// Cet objet va gérer les routes pour nous
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter (on le Set)
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,
// afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"
$router->map(
    'GET',  // méthode
    '/',    // route
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController' // On indique le FQCN de la classe (FQCN = namespace + nom_de_la_classe)
    ],
    'main-home'
);

$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'listCategories',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-list'
);

$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'addCategory',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-add'
);

$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'listProducts',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-list'
);

$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'addProduct',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-add'
);

// $router->map(
//     'POST',
//     '/product/add',
//     [
//         'method' => 'createProduct',
//         'controller' => '\App\Controllers\ProductController'
//     ],
//     'product-add'
// );


/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();

// dd($match);

// dd($_SERVER);

// dd($viewData);
// array:3 [
//   "target" => array:2 [
//   "method" => "home"
//   "controller" => "\App\Controllers\MainController"
// ]
// "params" => []
// "name" => "main-home"
// ]