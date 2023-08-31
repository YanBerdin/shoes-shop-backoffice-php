<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil et Pages statiques
     *
     * @return void
     */
    public function home()
    {
        // objets transmis dans home car besoin uniquement sur Home 
        // Sinon on l'aurait mis dans show() de CoreController

        // On utilise le Model Category pour afficher les 5 catégories à mettre en avant
        $categories = Category::findAllHomepage();

        // Idem au niveau des products
        $products = Product::findAllHomepage();

    //? Bonus PierreOclock : n'afficher que les 3 premiers éléments de chaque tableau
    // $allCategories = array_slice( $allCategories, 0, 3 );
    // $allProducts   = array_slice( $allProducts,   0, 3 );

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
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
