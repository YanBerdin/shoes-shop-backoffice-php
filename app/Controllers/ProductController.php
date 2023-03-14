<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends CoreController
{
    public function listProducts()
    {
        // On demande au Product Model d'interroger la BDD
        // pour remonter tous les produits
        $products = Product::findAll();

        $this->show('product/product-list', [
            'products' => $products
        ]);
    }

    public function addProduct()
    {
        $this->show('product/product-add');
    }
}