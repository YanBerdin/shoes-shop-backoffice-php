<?php

namespace App\Models;

use App\Models\CoreModel;
use PDO;
use App\Utils\Database;

/**
 * Un modèle représente une table (entité) de la BDD
 * Un objet issu de cette classe = un enregistrement dans cette table
 */
class Brand extends CoreModel
{
    /**
     * @var string
     */
    private $name;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Brand en fonction d'un id
     *
     * @param int $brandId ID de la marque
     * @return Brand
     */
    public function find($brandId)
    {
        $pdo = Database::getPDO();

        // Interpolation = injection SQL
        $sql = 'SELECT * 
                FROM brand
                WHERE `id` = :id';

        $pdoStatement = $pdo->prepare($sql);

        // Données attendues passées via array associatif
        $pdoStatement->execute([
            ':id' => $brandId,
        ]);

        // 1 seul résultat => fetchObject
        $brand = $pdoStatement->fetchObject(self::class);

        return $brand;
    }

    /**
     * Méthode pour récupérer tous les enregistrements de la table brand
     *
     * @return Brand[]
     */
    public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `brand`';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute();
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }

    /**
     * Méthode d'ajout d'un enregistrement dans la table brand
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return booléan
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "INSERT INTO `brand` (name)
            VALUES (:name)";
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute();

        // Si au moins 1 ligne ajoutée
        if ($pdoStatement > 0) {
            // Récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            return true;
        }
        return false;
    }

    /**
     * Méthode de MAJ d'un enregistrement dans la table brand
     * L'objet courant doit contenir l'id, et toutes les données à ajouter :
     * 1 propriété => 1 colonne dans la table
     *
     * @return booléan
     */
    public function update()
    {
        $pdo = Database::getPDO();

        $sql = "UPDATE `brand`
            SET
                name = :name,
                updated_at = NOW()
            WHERE id = :id";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->execute([
            ':name' => $this->name,
            ':id' => $this->id,
        ]);

        // Avec bindvalue :
        // Remplacement des paramètres de la requête
        // $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        // $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        // Exécution de la requête préparée
        // $pdoStatement->execute();

        // On retourne VRAI, si au moins une ligne ajoutée
        return ($pdoStatement > 0);

        //TODO Gérer erreurs
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
}
