<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController
{
    /**
     * Méthode de la page d'accueil et pages statiques
     *
     * @return void
     */
    public function home()
    {
        // objets transmis dans home (besoin uniquement sur Homepage)
        $categories = Category::findAllHomepage();

        // Idem pour products
        $products = Product::findAllHomepage();

        $this->show('main/home', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
}












//-------------------------------------------------------------------------------------------------------
// Version 0 - Master
// namespace App\Controllers;

// // Si j'ai besoin du Model Category
// // use App\Models\Category;

// class MainController extends CoreController
// {
//     /**
//      * Méthode s'occupant de la page d'accueil
//      *
//      * @return void
//      */
//     public function home()
//     {
//         // On appelle la méthode show() de l'objet courant
//         // En argument, on fournit le fichier de Vue
//         // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
//         $this->show('main/home');
//     }
// }
