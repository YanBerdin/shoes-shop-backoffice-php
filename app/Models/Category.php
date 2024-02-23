<?php

namespace App\Models;

use PDO;
use App\Utils\Database;

class Category extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }

    /**
     * Méthode de récupération d'un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function find($categoryId)
    {
        $pdo = Database::getPDO();

        // Requete Préparée
        // Version avec marqueurs nommés (un marqueur nommé sera de la forme : ':string')
        // Les marqueurs seront remplacés par des données que l'on récupérera via la 2nde requête (execute)
        $sql = 'SELECT * FROM `category` WHERE `id` = :id';
        $pdoStatement = $pdo->prepare($sql);

        // Les données attendues passées via un array associatif
        $pdoStatement->execute([
            ':id' => $categoryId,
        ]);

        // 1 seul résultat => fetchObject
        $category = $pdoStatement->fetchObject('App\Models\Category');

        return $category;
    }

    /**
     * Méthode de récupération de tous les enregistrements de la table category
     *
     * @return Category[]
     */
    // static : permet d'appeler la méthode directement sur la classe sans l'instancier
    // Category::findAll()
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }

    /**
     * Méthode de récupération des 5 catégories à afficher sur homepage
     *
     * @return Category[]
     */
    public static function findAllHomepage()
    {
        // RAPPEL
        // On peut appeler directement getPDO() sur la classe Database 
        // car getPDO() est une méthode statique (définie par : public static function ...)
        $pdo = Database::getPDO();
        // Sinon, on aurait dû faire :
        // $database = new Database();
        // $database->getPDO();

        $sql = 'SELECT *
            FROM `category`
            WHERE `home_order` > 0
            ORDER BY `home_order` ASC
            LIMIT 5
        ';             // ASC pas tres utile => déjà par defaut

        $pdoStatement = $pdo->query($sql);

        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $categories;
    }

    /**
     * Méthode d'ajout d'un enregistrement dans la table category
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return booléan
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        //* Rappel Important pour se prémunir des injections SQL
        // @see https://www.php.net/manual/fr/pdo.prepared-statements.php
        // @see https://portswigger.net/web-security/sql-injection (exemples avec SELECT)
        // @see https://stackoverflow.com/questions/681583/sql-injection-on-insert (exemples avec INSERT INTO)

        // Version avec marqueurs non nommés
        /*
        $sql = '
            INSERT INTO `category`
            (name, subtitle, picture)
            VALUES (?, ?, ?)
        ';
        */

        $sql = 'INSERT INTO `category`
            (`name`, `subtitle`, `picture`)
            VALUES (:name, :subtitle, :picture)
        ';

        $query = $pdo->prepare($sql);

        $query->execute([
            ':name' => $this->name,
            ':subtitle' => $this->subtitle,
            ':picture' => $this->picture
        ]);

        // Vérifier si la requête a retourné 1 résultat
        // Si 1 nouvelle catégorie est insérée dans la table category
        if ($query->rowCount() > 0) {
            // Récupérer l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            return true;
        }
        // Sinon
        return false;
    }


    /**
     * Méthode de MAJ d'une catégorie.
     *
     * @return booléan
     */
    public function update()
    {
        $pdo = Database::getPDO();

        // Interpolation => Injection SQL
        $sql = "
            UPDATE `category`
            SET
            name = :name,
            subtitle = :subtitle,
            picture = :picture,
            updated_at = NOW()
            WHERE id = :id
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':name', $this->name);
        $pdoStatement->bindValue(':subtitle', $this->subtitle);
        $pdoStatement->bindValue(':picture', $this->picture);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        $pdoStatement->execute();

        if ($pdoStatement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
        // Version + courte
        // return ($pdoStatement->rowCount() > 0);
    }

    /**
     * Méthode de MAJ des valeurs de home_order des catégories
     * Par défaut, toutes les catégories auront un home_order à 0
     * Ensuite, valeurs récupérées du formulaire pour les 5 catégories à mettre en avant
     *
     * @param Array $ids Liste des id des catégories à mettre en avant
     * @return void La fonction execute mais ne renvoie rien
     */
    public static function updateHomeOrder($ids)
    {
        // On se connecte à la BDD
        $pdo = Database::getPDO();

        //! On fait les mises à jour nécessaires
        // - passer tous les home_order à 0
        // - mettre les bonnes valeurs dans les 5 catégories correspondantes
        // Contrairement à d'habitude, on passe ici par des marqueurs anonymes (?)
        // car toutes les données sont semblables (ce sont toutes des id)
        $sql = 'UPDATE `category` SET `home_order` = 0;
            UPDATE `category` SET `home_order` = 1 WHERE id = ?;
            UPDATE `category` SET `home_order` = 2 WHERE id = ?;
            UPDATE `category` SET `home_order` = 3 WHERE id = ?;
            UPDATE `category` SET `home_order` = 4 WHERE id = ?;
            UPDATE `category` SET `home_order` = 5 WHERE id = ?;
        ';

        //FIXME: Alec
        //     $sql = 'UPDATE `category`
        //    SET `home_order` = CASE 
        // 	  when id = ? then 1
        // 	  when id = ? then 2
        // 	  when id = ? then 3
        // 	  when id = ? then 4
        // 	  when id = ? then 5
        // 	  ELSE `home_order`	
        //         END ';

        $query = $pdo->prepare($sql);

        //! On exécute les requêtes
        // $ids est un array d'id, par exemple : [1, 3, 2, 5, 4]
        // La méthode execute attend un array ==> on peut donc directement passer $ids
        $query->execute($ids);

        //TODO Versions plus abouties :
        //TODO - mettre un try / catch sur l'exécution des requêtes
        //TODO - ajouter un return true / false => le controller testera la valeur retournée
        //TODO (ajout d'une gestion d'erreurs)
        //TODO il faudra que toutes les lignes (5) soient MAJ
    }
}
