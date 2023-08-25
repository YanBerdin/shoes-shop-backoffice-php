<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Type;


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
        // $this->show('product/product-add');

        // On récupère la liste complète des catégories, marques et types
        // à transmettre à show, et donc au template
        // On récupère toutes les marques
        $modelBrand = new Brand();
        $brands = $modelBrand->findAll();

        // On récupère toutes les catégories
        $modelCategory = new Category();
        $categories = $modelCategory->findAll();

        // On récupère tous les types
        $modelType = new Type();
        $types = $modelType->findAll();

        $this->show('product/product-add', [
            'brands' => $brands,
            'categories' => $categories,
            'types' => $types
        ]);
    }

    public function createProduct() // idem createCategory() adaptée
    {
        //! Autorisation
        //? On utilise la méthode checkAuthorization() pour vérifier si le user 
        //? a les droits (permissions) pour accéder à la page
        // On doit lui passer en argument un array des roles authorisés pour cette page
        // Ici, les rôles admin et catalog-manager auront les permissions
        //? Cas ou  à le droit d'accès à tpl category-list
        $this->checkAuthorization(['admin', 'catalog-manager']);

        // dump($_POST);

        // On doit vérifier que $_POST n'est pas vide et contient bien les clés
        // les clés sont données par la valeur des attributs name des champs du form
        // nos clés : name, subtitle et picture
        if (!empty($_POST)) {
            // On peut passer directement la string de l'attribut name car on utilise la fonction
            // PHP filter_input
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);
            // On complète avec tous les name récupérés du form
            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT);
            $rate = filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_NUMBER_INT);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
            $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_SANITIZE_NUMBER_INT);
            $type_id = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_NUMBER_INT);

            // On doit gérer les éventuelles erreurs
            // On créer un array (vide) qui stockera les erreurs
            $errorList = [];

            // On ne fait jamais confiance à l'utilisateur
            // On va vérifier pour chaque champ si :
            // - le champ n'est pas null
            // - et le champ est valide : si le champ ne passe pas le test du filter_input (via le 3ème argument FILTER_SANITIZE_...) alors filter_input renvoie "false"

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

            // Pas nécessaire car on affiche les catégories via un select dans le form
            if ($category_id === false) {
                $errorList[] = 'Merci de renseigner une catégorie valide';
            }

            if (empty($type_id)) {
                $errorList[] = 'Merci de renseigner le type du produit';
            }

            // Pas nécessaire car on affiche les types via un select dans le form
            if ($type_id === false) {
                $errorList[] = 'Merci de renseigner un type valide';
            }

            if (empty($brand_id)) {
                $errorList[] = 'Merci de renseigner la marque du produit';
            }

            // Pas nécessaire car on affiche les marques via un select dans le form
            if ($brand_id === false) {
                $errorList[] = 'Merci de renseigner une marque valide';
            }

            // Avant de créer la nouvelle catégorie, on doit vérfier si on a eu une ou plusieurs erreurs
            // cad si $errorList n'est pas vide
            if (empty($errorList)) {
                // On utilise le model pour interagir avec la BDD
                $modelProduct = new Product();

                // On va setter (appeler les setters) pour mettre les valeurs des inputs 
                // dans chaque propriété de l'objet Category
                // (en d'autres termes : on met à jour les propriétés de l'instance)
                $modelProduct->setName($name);
                $modelProduct->setDescription($description);
                $modelProduct->setPicture($picture);
                $modelProduct->setPrice($price);
                $modelProduct->setRate($rate);
                $modelProduct->setStatus($status);
                $modelProduct->setCategoryId($category_id);
                $modelProduct->setBrandId($brand_id);
                $modelProduct->setTypeId($type_id);

                // Le model exécutera la nouvelle méthode insert()
                $isInsert = $modelProduct->insert();
                // $isInsert contient un booléen (true / false)

                // Si l'insertion est OK => redirection vers category/list
                if ($isInsert) {    // $isInsert vaut true
                    // Redirection vers category/list
                    header('Location: /product/list');
                } else {
                    // Sinon => message d'erreur et redirection vers le form (pas besoin ici car notre attribut action du form est vide, et donc on reste sur la page)
                    $errorList[] = 'La création du produit a échoué';
                }
            } else {
                //! Ici, on a au moins une erreur
                // On reste sur le formulaire et on souhaite transmettre à show() les champs saisis et les erreurs obtenues
                // Pour que plus tard, le template récupère ces données pour :
                // - pré-remplir les input du form avec les données qui ont été saisies
                // - afficher les erreurs

                // 1. On instancie un model Catégory
                $modelProduct = new Product();

                // 2. On sette les propriétés de Category
                $modelProduct->setName($name);
                $modelProduct->setDescription($description);
                $modelProduct->setPicture($picture);
                $modelProduct->setPrice($price);
                $modelProduct->setRate($rate);
                $modelProduct->setStatus($status);
                $modelProduct->setCategoryId($category_id);
                $modelProduct->setBrandId($brand_id);
                $modelProduct->setTypeId($type_id);

                // 3. On appelle la méthode show() en lui passanrt les données (cad valeurs des champs + erreur(s))
                // Dans le template category-add, on récupère $viewData['category'] et $viewData['errors']
                //! et via extract() : $product et $errors
                $this->show('product/product-add', [
                    'product' => $modelProduct,
                    'errors' => $errorList
                ]);

                // TODO : utiliser les données dans le template pour gérer l'affichage
            }
        }
    }
}
