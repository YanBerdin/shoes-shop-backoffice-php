<?php

// inclusion des dépendances via Composer
// autoload.php = autochargement des classes (convention PSR-4)
require_once '../vendor/autoload.php';

session_start();

// ROUTAGE
$router = new AltoRouter();

if (array_key_exists('BASE_URI', $_SERVER)) {
    // Définir le basePath d'AltoRouter
    // routes correspondant à l'URL, après chemin de sous-répertoire
    $router->setBasePath($_SERVER['BASE_URI']);
} else {
    // sinon valeur par défaut de $_SERVER['BASE_URI'] utilisé par CoreController
    $_SERVER['BASE_URI'] = '/';
}

$router->map(
    'GET',  // méthode
    '/',    // route
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController' // On indique le FQCN de la classe (FQCN = namespace + nom_de_la_classe)
    ],
    'main-home'
);

//* Inclusion des routes depuis un autre fichier 
require_once '../app/Routes/CategoryRouter.php';
require_once '../app/Routes/ProductRouter.php';
require_once '../app/Routes/AppUserRouter.php';

// DISPATCH
// AltoRouter trouve route correspondante à l'URL courante
$match = $router->match();

// Ensuite, dispatcher le code dans la bonne méthode, du bon Controller
// librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404

$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

// Cette fonction permet d'envoyer des arguments au constructeur du Controller utilisé
$dispatcher->setControllersArguments($router, $match);

// Une fois le "dispatcher" configuré, lancer le dispatch qui va exécuter la méthode du controller
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