<?php

namespace App\Models;

use PDO;
use App\Utils\Database;
use App\Models\CoreModel;

/**
 * Une instance de Product = un produit dans la base de données
 */
class Product extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $rate;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $brand_id;
    /**
     * @var int
     */
    private $category_id;
    /**
     * @var int
     */
    private $type_id;

    /**
     * Méthode de récupération d'un enregistrement de la table Product en fonction de son id
     *
     * @param int $productId ID du produit
     * @return Product
     */
    public function find($productId)
    {
        $pdo = Database::getPDO();

        $sql = "SELECT *
        FROM product
        WHERE id =:id";

        //* query ? exec ?
        // LECTURE = récupration => query()
        // Modification, suppression, ajout => exec()
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->execute([':id' => $productId]);

        // fetchObject() = récupérer 1 seul résultat
        // si plusieurs => fetchAll
        $result = $pdoStatement->fetchObject('App\Models\Product');

        return $result;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Product[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();

        // Interpolation = injection SQL
        $sql = 'SELECT * FROM `product`';

        $pdoStatement = $pdo->query($sql);

        //? $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');
        //? Autre manière ( self::class ); (Pierre Oclock)
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }

    /**
     * Récupérer les 5 produits mises en avant sur la home
     *
     * @return Product[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();

        // Interpolation => injection SQL
        $sql = 'SELECT *
            FROM `product`
            ORDER BY `id`
            LIMIT 5';

        $pdoStatement = $pdo->query($sql);

        // $sql = 'SELECT *
        //     FROM `product`
        //     ORDER BY `id`
        //     LIMIT :limit';

        // Executer la requete (on pourrait aussi utiliser bindvalue cf hier)
        //TODO Marche Pas => Voir Alec
        // FIXME: $pdoStatement->execute([`:limit` => $limit]);
        // Et si j'utilise :
        // $pdoStatement->bindParam(':limit', $limit, PDO::PARAM_INT);
        // $pdoStatement->execute();
        // Je ne peux plus forcer les objets reçus à être de classe Product

        $products = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');

        return $products;
    }

    /**
     * Méthode d'ajout d'un enregistrement dans la table category
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = 'INSERT INTO `product`
            (`name`, `description`, `picture`, `price`, `rate`, `status`, `category_id`, `brand_id`, `type_id`)
            VALUES (:name, :description, :picture, :price, :rate, :status, :category_id, :brand_id, :type_id)
        ';

        $query = $pdo->prepare($sql);

        // Les données attendues sont passées via un array associatif
        $query->execute([
            ':name' => $this->name,
            ':description' => $this->description,
            ':picture' => $this->picture,
            ':price' => $this->price,
            ':rate' => $this->rate,
            ':status' => $this->status,
            ':category_id' => $this->category_id,
            ':brand_id' => $this->brand_id,
            ':type_id' => $this->type_id,
        ]);

        // Vérifier si la requête a retourné 1 résultat
        // (cad si 1 catégorie est insérée dans la table category)
        if ($query->rowCount() > 0) {
            // Récupérer l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            return true;
        }
        // Sinon
        return false;
    }

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
     * Get the value of description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of picture
     *
     * @return  string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param  string  $picture
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of rate
     *
     * @return  int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @param  int  $rate
     */
    public function setRate(int $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of brand_id
     *
     * @return  int
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @param  int  $brand_id
     */
    public function setBrandId(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * Get the value of category_id
     *
     * @return  int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @param  int  $category_id
     */
    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Get the value of type_id
     *
     * @return  int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     *
     * @param  int  $type_id
     */
    public function setTypeId(int $type_id)
    {
        $this->type_id = $type_id;
    }
}
