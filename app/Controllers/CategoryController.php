<?php

namespace App\Controllers;

// Pour l'étape 2 de l'atelier E01
// On a besoin du Model Category
use App\Models\Category;

class CategoryController extends CoreController   //   <=   <=   extends pour heritage
{
    public function listCategories()
    {
        // Etape 1 : on appelle show() en lui passant le template
        // à utiliser pour l'affichage
        // $this->show('category/category-list');

        // Etape 2 : on utilise le Model pour intégrer la BDD
        // Une manière de faire
        // $modelCategory = new Category();
        // $categories = $modelCategory->findAll();

        // On veut appeler la méthode findAll() du Model Category
        // Cette méthode findAll() étant à présent "static", on peut l'appeler directement
        // via le model Category
        $categories = Category::findAll();

        // On appelle show() en lui passant via l'array (second argument passé) les données
        // contenues $categories
        $this->show('category/category-list', [
            'categories' => $categories
        ]);

    }

    public function addCategory()
    {
        $this->show('category/category-add');
    }
}