<?php

namespace App\Controllers;

// Pour l'étape 2 de l'atelier E01
// On a besoin du Model Category
use App\Models\Category;
use App\Controllers\CoreController;

class CategoryController extends CoreController   // <= extends pour heritage
{
    public function listCategories()
    {
        // Etape 1 : on appelle show() en lui passant le template
        // à utiliser pour l'affichage
        // $this->show('category/category-list');

        // Etape 2 : on utilise le Model pour intégrer la BDD
        // Une manière de faire (cf S05)
        // $modelCategory = new Category();
        // $categories = $modelCategory->findAll();

        // On veut appeler la méthode findAll() du Model Category
        // Cette méthode findAll() étant à présent "static",
        // => on peut l'appeler directement sur la classe
        // via le model Category
        $categories = Category::findAll();

        // On appelle show() 
        // => en lui passant via l'array (second argument passé)
        // => les données contenues dans $categories
        $this->show('category/category-list', [
            'categories' => $categories
        ]);
    }

    public function addCategory()
    {
        // $this->show('category/category-add');

        // On passe une instance du Model Category à show
        // pour avoir accès à $category dans le template
        // Cela servira à faire appel aux données
        // (ex : $category->getName())
        $this->show('category/category-add-update', [
            'category' => new Category()
        ]);
    }

    public function createCategory()
    {
        // dump($_POST);

        // On doit vérifier que $_POST n'est pas vide et contient bien les clés
        // les clés sont données par la valeur des attributs name des champs du form
        // nos clés : name, subtitle et picture
        if (!empty($_POST)) {
            // On peut passer directement la string de l'attribut name car on utilise la fonction
            // PHP filter_input
            // $name = filter_input(INPUT_POST, $_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
            $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);

            // TODO
            // On doit gérer les éventuelles erreurs
            // On créer un array (vide) qui stockera les erreurs
            $errorList = [];

            // On ne fait jamais confiance à l'utilisateur
            // On va vérifier pour =>  chaque champ <= :
            // - Si le champ n'est pas null
            // - et si le champ est valide : si le champ ne passe pas le test du filter_input (via le 3ème argument FILTER_SANITIZE_...) 
            // alors filter_input renvoie "false"

            if (empty($name)) { // Si le champ name est vide (empty)
                $errorList[] = 'Merci de renseigner le nom de la catégorie';
            }

            if ($name === false) { // Si le champ est valide (via le 3ème argumt FILTER_SANITIZE_...)
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


            // Avant de créer la nouvelle catégorie, 
            // on doit vérfier si on a eu une ou plusieurs erreurs
            // cad si $errorList n'est pas vide
            if (empty($errorList)) {

                // On utilise le model pour interagir avec la BDD

                // setter pour update les valeurs de chaque propriété de l'objet Category
                // Si insertion OK => Message OK + redirection vers category/list
                // Sinon => message d'erreur + redirection vers le formulaire

                // Pour insérer en BDD, je crée une nouvelle instance du Model correspondant (=> Category)

                // 1. On instancie un model Category
                $modelCategory = new Category();

                // Active Record = On utilise le model pour interagir avec la BDD

                // 2. On sette les propriétés de Category
                // Renseigner les valeurs pour chaque propriété correspondante dans l'instance.
                // Setter (appeler les setters) pour mettre les valeurs des inputs 
                // dans chaque propriété de l'objet Category
                $modelCategory->setName($name);
                $modelCategory->setSubtitle($subtitle);
                $modelCategory->setPicture($picture);

                // Le model exécutera la nouvelle méthode insert()
                $isInsert = $modelCategory->insert();
                // $isInsert contient un booléen (true / false)

                // Si l'insertion est OK => redirection vers category/list
                if ($isInsert) {
                    // Redirection vers category/list 
                    header('Location: /category/list');
                } else {
                    // Sinon => message d'erreur et redirection vers le form 
                    // (pas besoin ici car notre attribut action du form est vide, et donc on reste sur la page)
                    // (action="" dans le formulaire )
                    $errorList[] = 'La création de la catégorie a échoué';
                }
            } else {
                // Ici, on a au moins une erreur
                // On reste sur le formulaire et on souhaite transmettre à show() les champs saisis et les erreurs obtenues
                // Pour que plus tard, le template récupère ces données pour :
                // - pré-remplir les input du form avec les données qui ont été saisies
                // - afficher les erreurs

                // 1. On instancie un model Catégory
                $modelCategory = new Category();

                // 2. On sette les propriétés de Category
                $modelCategory->setName($name);
                $modelCategory->setSubtitle($subtitle);
                $modelCategory->setPicture($picture);

                // 3. On appelle la méthode show() en lui passanrt les données (cad valeurs des champs + erreur(s))
                // Dans le template category-add, on récupère $viewData['category'] et $viewData['errors']
                // et via extract() : $category et $errors
                $this->show('category/category-add', [
                    'category' => $modelCategory,
                    'errors' => $errorList
                ]);

                // TODO : utiliser les données dans le template pour gérer l'affichage
            }
        }
    }
}
