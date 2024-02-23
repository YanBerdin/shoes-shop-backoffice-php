<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Modèle = table (entité) dans BDD
 * Un objet issu de cette classe = un enregistrement dans cette table
 */
class Type extends CoreModel
{
    /**
     * @var string
     */
    private $name;

    /**
     * Méthode de récupération d'un enregistrement de la table Type en fonction d'un id
     *
     * @param int $typeId ID du type
     * @return Type
     */
    public function find($typeId)
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM `type` WHERE `id` =' . $typeId;

        $pdoStatement = $pdo->query($sql);

        // 1 seul résultat => fetchObject
        $type = $pdoStatement->fetchObject(self::class);

        return $type;
    }

    /**
     * Méthode de récupération de tous les enregistrements de la table type
     *
     * @return Type[]
     */
    public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `type`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Type');

        return $results;
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
