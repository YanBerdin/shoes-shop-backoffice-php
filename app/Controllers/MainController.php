<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController
{
    /**
     * Méthode d'affichage de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        // (besoin uniquement sur Homepage)
        $categories = Category::findAllHomepage();

        // Idem pour products
        $products = Product::findAllHomepage();

        $this->show('main/home', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
