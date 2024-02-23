<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController
{
    /**
     * Méthode qui sera exécutée pour l'affichage de toutes les cartégories du site
     *
     * @return void
     */
    public function listCategories()
    {
        $categories = Category::findAll();

        $this->show('category/category-list', [
            'categories' => $categories
        ]);
    }


    /**
     * Méthode pour afficher le formulaire d'ajout d'une catégorie
     *
     * @return void
     */
    public function addCategory()
    {
        $this->show('category/category-add-update', [
            'category' => new Category()
        ]);
    }

    /**
     * Créer ou modifier une catégorie en BDD
     *
     * @param int | null $categoryId
     * @return void
     */
    public function createOrUpdateCategory($categoryId = null)
    {
        // Si mode create => pas d'id
        // Sinon mode update => id
        $isUpdate = isset($categoryId);

        // les clés sont données par la valeur des attributs name des champs du form
        if (!empty($_POST)) {
            // Récupèrer les données postées
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
            $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);

            // Gérer les éventuelles erreurs
            $errorList = [];

            // Jamais confiance à l'utilisateur
            // vérifier pour chaque champ
            // - Si le champ n'est pas null
            // - et si le champ est valide

            if (empty($name)) {
                $errorList[] = 'Merci de renseigner le nom de la catégorie';
            }

            if ($name === false) {
                $errorList[] = 'Merci de renseigner un nom valide';
            }

            if (empty($subtitle)) {
                $errorList[] = 'Merci de renseigner le sous-titre de la catégorie';
            }

            if ($subtitle === false) {
                $errorList[] = 'Merci de renseigner un sous-titre valide';
            }

            if (empty($picture)) {
                $errorList[] = 'Merci de renseigner l\'image de la catégorie';
            }

            if ($picture === false) {
                $errorList[] = 'Merci de renseigner une image valide';
            }

            if (empty($errorList)) {

                // ici pas d'erreur
                if ($isUpdate) {
                    // mode update récupérer la catégorie à mettre à jour
                    $modelCategory = Category::find($categoryId);
                } else {
                    // mode create => créer une instance de Category
                    $modelCategory = new Category();
                }

                //* Active Record = Utiliser le model pour interagir avec la BDD
                // Renseigner les valeurs pour chaque propriété correspondante dans l'instance.
                $modelCategory->setName($name);
                $modelCategory->setSubtitle($subtitle);
                $modelCategory->setPicture($picture);

                // Tester de nouveau le mode (create / update) pour appeler la méthode
                // correspondante du Model
                if ($isUpdate) {
                    $isUpdateOk = $modelCategory->update();

                    if ($isUpdateOk) {
                        // Redirection vers la category modifiée
                        header("Location: /category/add-update/{$categoryId}");

                        exit(); //* exit() apres Redirection
                    } else {
                        $errorList[] = 'La modification de la catégorie a échoué';
                    }
                } else { // Sinon = Mode Create
                    $isInsertOk = $modelCategory->insert();
                    // $isInsert contient un booléen (true / false)

                    if ($isInsertOk) {
                        // header(location) permet de sortir du comportement action=""
                        // donc de ne pas pouvoir re-soumettre le formulaire
                        header("Location: " . $this->router->generate("category-list"));

                        exit(); //* exit() apres Redirection
                    } else {
                        $errorList[] = 'La création de la catégorie a échoué';
                    }
                }
            } else {
                // Ici, au moins une erreur
                // Rester sur le formulaire et transmettre à show() les champs saisis et erreurs obtenues
                // Pour que plus tard, le template récupère ces données pour :
                // - pré-remplir les input du form avec les données qui ont été saisies
                // - afficher les erreurs

                $modelCategory = new Category();

                $modelCategory->setName($name);
                $modelCategory->setSubtitle($subtitle);
                $modelCategory->setPicture($picture);

                // extract() permet de récupérer $category et $errors
                $this->show('category/category-add-update', [
                    'category' => $modelCategory,
                    'errors' => $errorList
                ]);
            }
        }
    }

    /**
     * Méthode pour MAJ une catégorie
     *
     * @return void
     */
    public function editCategory($categoryId)
    {
        // Récupèrer la catégorie à modifier
        $category = Category::find($categoryId);
        $this->show('category/category-add-update', [
            'category' => $category,
            'categoryId' => $categoryId
        ]);
    }

    /**
     * Méthode pour afficher formulaire de gestion des catégories
     *
     * @return void
     */
    public function homeDisplay()
    {
        // findAll() est statique =>  l'appeler directement sur la classe via l'opérateur "::"
        $categories = Category::findAll();

        $this->show('category/manage', [
            'categories' => $categories
        ]);
    }

    /**
     * Méthode pour sélectionner 5 catégories à présenter sur la page d'accueil
     */
    public function homeSelect()
    {
        //dump($_POST['emplacement']);

        // Récupèrer les données postées
        $emplacements = filter_input(INPUT_POST, 'emplacement', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

        // MAJ la valeur du home_order de CHAQUE categorie
        // $emplacements est un array contenant des int (id)
        Category::updateHomeOrder($emplacements);

        header("Location: " . $this->router->generate("category-list"));

        exit();
    }
}
