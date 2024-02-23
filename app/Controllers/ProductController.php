<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Type;


class ProductController extends CoreController
{
    /**
     * Liste tous les produits
     *
     * @return void
     */
    public function listProducts()
    {
        $products = Product::findAll();

        $this->show('product/product-list', [
            'products' => $products
        ]);
    }

    /**
     * Ajoute un nouveau produit
     */
    public function addProduct()
    {
        $modelBrand = new Brand();
        $brands = $modelBrand->findAll();

        $modelCategory = new Category();
        $categories = $modelCategory->findAll();

        $modelType = new Type();
        $types = $modelType->findAll();

        $this->show('product/product-add', [
            'brands' => $brands,
            'categories' => $categories,
            'types' => $types
        ]);
    }

    /**
     * Crée un nouveau produit.
     *
     * @return void
     */
    public function createProduct()
    {

        if (!empty($_POST)) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);
            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT);
            $rate = filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_NUMBER_INT);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
            $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_SANITIZE_NUMBER_INT);
            $type_id = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_NUMBER_INT);

            $errorList = [];

            // Vérifier pour chaque champ si :
            // - le champ n'est pas null
            // - et le champ est valide : si le champ ne passe pas le test filter_input alors filter_input renvoie "false"

            if (empty($name)) {
                $errorList[] = 'Merci de renseigner le nom du produit';
            }

            if ($name === false) {
                $errorList[] = 'Merci de renseigner un nom valide';
            }

            if (empty($description)) {
                $errorList[] = 'Merci de renseigner la description du produit';
            }

            if ($description === false) {
                $errorList[] = 'Merci de renseigner une description valide';
            }

            if (empty($picture)) {
                $errorList[] = 'Merci de renseigner l\'image du produit';
            }

            if ($picture === false) {
                $errorList[] = 'Merci de renseigner une image valide';
            }

            if (empty($price)) {
                $errorList[] = 'Merci de renseigner le prix du produit';
            }

            if ($price === false) {
                $errorList[] = 'Merci de renseigner un prix valide';
            }

            if (empty($rate)) {
                $errorList[] = 'Merci de renseigner la note du produit';
            }

            if ($rate === false) {
                $errorList[] = 'Merci de renseigner une note valide';
            }

            if (empty($status)) {
                $errorList[] = 'Merci de renseigner le statut du produit';
            }

            if ($status === false) {
                $errorList[] = 'Merci de renseigner un statut valide';
            }

            if (empty($category_id)) {
                $errorList[] = 'Merci de renseigner la catégorie du produit';
            }

            // Pas indispensable (affichage catégories via select dans le form)
            if ($category_id === false) {
                $errorList[] = 'Merci de renseigner une catégorie valide';
            }

            if (empty($type_id)) {
                $errorList[] = 'Merci de renseigner le type du produit';
            }

            // Pas indispensable (affichage types via select dans le form)
            if ($type_id === false) {
                $errorList[] = 'Merci de renseigner un type valide';
            }

            if (empty($brand_id)) {
                $errorList[] = 'Merci de renseigner la marque du produit';
            }

            // Pas indispensable (affichage marques via select dans le form)
            if ($brand_id === false) {
                $errorList[] = 'Merci de renseigner une marque valide';
            }

            if (empty($errorList)) {

                $modelProduct = new Product();

                // MAJ des propriétés de l'instance)
                $modelProduct->setName($name);
                $modelProduct->setDescription($description);
                $modelProduct->setPicture($picture);
                $modelProduct->setPrice($price);
                $modelProduct->setRate($rate);
                $modelProduct->setStatus($status);
                $modelProduct->setCategoryId($category_id);
                $modelProduct->setBrandId($brand_id);
                $modelProduct->setTypeId($type_id);

                $isInsert = $modelProduct->insert(); // $isInsert contient un booléen

                if ($isInsert) {  // $isInsert vaut true
                    // Redirection vers la liste des produits
                    header("Location: " . $this->router->generate("product-list"));
                    // exit() après une redirection
                    exit(); 
                } else {
                    $errorList[] = 'La création du produit a échoué';
                }
            } else {
                // Ici, au moins 1 erreur
                // - pré-remplir les input du form avec les données qui ont été saisies
                // - afficher les erreurs

                $modelProduct = new Product();

                $modelProduct->setName($name);
                $modelProduct->setDescription($description);
                $modelProduct->setPicture($picture);
                $modelProduct->setPrice($price);
                $modelProduct->setRate($rate);
                $modelProduct->setStatus($status);
                $modelProduct->setCategoryId($category_id);
                $modelProduct->setBrandId($brand_id);
                $modelProduct->setTypeId($type_id);

                $this->show('product/product-add', [
                    'product' => $modelProduct,
                    'errors' => $errorList
                ]);
            }
        }
    }
}
