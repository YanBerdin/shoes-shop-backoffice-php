<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

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
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function find($categoryId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        //? Requete non préparée
        //? $sql = 'SELECT * FROM `category` WHERE `id` =' . $categoryId;
        // exécuter notre requête
        //? $pdoStatement = $pdo->query($sql);

        //! Requete Préparée (Alec)
        // Version avec marqueurs nommés (un marqueur nommé sera de la forme : ':string')
        // Les marqueurs seront remplacés par des données que l'on récupérera via la 2nde requête (execute)
        $sql = 'SELECT * FROM `category` WHERE `id` = :id';

        // V2 : on utilise la méthode prepare() pour faire des requêtes préparées
        $pdoStatement = $pdo->prepare($sql);

        // On exécute la requête préparée en passant les données attendues
        // Les données attendues sont passées via un array associatif
        $pdoStatement->execute([
            ':id' => $categoryId,
        ]);



        // un seul résultat => fetchObject
        $category = $pdoStatement->fetchObject('App\Models\Category');

        // retourner le résultat
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     *
     * @return Category[]
     */
    // On ajoute le mot-clé "static" pour rendre la méthode findAll() statique
    // Avantage : on peut appeler la méthode directement sur la classe sans l'instancier
    // Category::findAll()
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');
        // Autre manière (vue avec Renaud)
        // $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'Category::class');

        return $results;
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
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

        // ci-dessous => ASC n'est pas tres utile => c'est comme ça par defaut

        $sql = '
            SELECT *
            FROM `category`
            WHERE `home_order` > 0
            ORDER BY `home_order` ASC
            LIMIT 5
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $categories;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table category
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // V2 : on a récupéré la méthode déjà codée dans le model Category
        // On va modifier la requete et son exécution pour ajouter une sécurité
        // Ecriture de la requête INSERT INTO
        /*
        $sql = "
            INSERT INTO `category` (name)
            VALUES ('{$this->name}')
        ";
        */

        // On passe maintenant (V2) sur deux requêtes pour ne pas avoir 1 seule requête contenant la query string et les données
        // - 1ère requête : prepare()
        // - 2nd requête : execute()
        // Important pour se prémunir des injections SQL
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

        // Version avec marqueurs nommés (un marqueur nommé sera de la forme : ':string')
        // Les marqueurs seront remplacés par des données que l'on récupérera via la 2nde requête (execute)
        $sql = '
            INSERT INTO `category`
            (`name`, `subtitle`, `picture`)
            VALUES (:name, :subtitle, :picture)
        ';

        // Execution de la requête d'insertion (exec, pas query)
        // $insertedRows = $pdo->exec($sql);
        // V2 : on utilise la méthode prepare() pour faire des requêtes préparées
        $query = $pdo->prepare($sql);

        // On exécute la requête préparée en passant les données attendues
        // Les données attendues sont passées via un array associatif
        $query->execute([
            ':name' => $this->name,
            ':subtitle' => $this->subtitle,
            ':picture' => $this->picture
        ]);

        // Si au moins une ligne ajoutée
        // if ($insertedRows > 0) {
        // V2 : on n'utilise plus $pdo->exec($querySql) mais une requête préparée
        // => on n'a plus accès à insertedRows
        // On va utilser la méthode rowCount() sur la query
        // On vérifie si la requête a retourné 1 résultat (cad si on a bien inséré 1 novelle catégorie dans la table category)
        if ($query->rowCount() > 0) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }


    public function update()
    {
        $pdo = Database::getPDO();

        //! Interpolation (Injection SQL)
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

        // Version plus courte
        // retourne true si la condition est vraie, sinon false
        // return ($pdoStatement->rowCount() > 0);
    }

    //? S06 E07
    /**
     * Méthode qui met à jour les valeurs de home_order des catégories
     * Par défaut, toutes les catégories auront un home_order à 0
     * Ensuite, on mettra les valeurs récupérées du form dans les 5 catégories
     * à mettre en avant
     *
     * @param Array $ids Liste des id des catégories à mettre en avant
     * @return void        La fonction execute mais ne renvoie rien
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
        $sql = '
            UPDATE `category` SET `home_order` = 0;
            UPDATE `category` SET `home_order` = 1 WHERE id = ?;
            UPDATE `category` SET `home_order` = 2 WHERE id = ?;
            UPDATE `category` SET `home_order` = 3 WHERE id = ?;
            UPDATE `category` SET `home_order` = 4 WHERE id = ?;
            UPDATE `category` SET `home_order` = 5 WHERE id = ?;
        ';

        //! On prépare les requêtes $query pourrait être $pdoStatement
        // $query ou $pdoStatement
        $query = $pdo->prepare($sql);

        //! On exécute les requêtes
        // $ids est un array d'id, par exemple : [1, 3, 2, 5, 4]
        // La méthode execute attend un array ==> on peut donc directement passer $ids
        $query->execute($ids);

        //TODO Versions plus abouties possible :
        //TODO - mettre un try / catch sur l'exécution des requêtes
        //TODO - ajouter un return true / false ==> le controller testera la valeur retournée
        //TODO (ajout d'une gestion d'erreurs)
        //TODO il faudra que toutes les lignes (5) soient MAJ
    }
}
