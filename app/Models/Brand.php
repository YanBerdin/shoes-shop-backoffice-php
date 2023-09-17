<?php

namespace App\Models;

use App\Models\CoreModel;
use PDO; // Natif donc pas de chemin nécéssaire
use App\Utils\Database; // use => Chemin jusqu'à fichier (sans extension)

/**
 * Un modèle représente une table (un entité) dans notre base
 *
 * Un objet issu de cette classe réprésente un enregistrement dans cette table
 */
class Brand extends CoreModel
{
    // Les propriétés représentent les champs
    // Attention il faut que les propriétés aient le même nom (précisément) que les colonnes de la table

    /**
     * @var string
     */
    private $name;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Brand en fonction d'un id donné
     *
     * @param int $brandId ID de la marque
     * @return Brand
     */
    public function find($brandId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        // Interpolation = injection SQL
        $sql = 'SELECT * 
                FROM brand
                WHERE `id` = :id';
        // WHERE id = ' . $brandId;


        // exécuter notre requête
        // Non préparée
        // $pdoStatement = $pdo->query($sql);
        $pdoStatement = $pdo->prepare($sql);

        // On exécute la requête préparée en passant les données attendues
        // Les données attendues sont passées via un array associatif
        $pdoStatement->execute([
            ':id' => $brandId,
        ]);

        // un seul résultat => fetchObject
        $brand = $pdoStatement->fetchObject('App\Models\Brand');
        //?                     fetchObject( self::class ); (Pierre Oclock) Alec : Mieux ?

        // retourner le résultat
        return $brand;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table brand
     *
     * @return Brand[]
     */
    public function findAll()
    {
        $pdo = Database::getPDO();

        // Interpolation = injection SQL
        $sql = 'SELECT * FROM `brand`';

        // $pdoStatement = $pdo->query($sql);
        $pdoStatement = $pdo->prepare($sql);

        // On exécute la requête préparée
        $pdoStatement->execute();

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Brand');

        return $results;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table brand
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        //! Ecriture de la requête INSERT INTO
        // $sql = "
        //     INSERT INTO `brand` (name)
        //     VALUES ('{$this->name}')
        // ";

        $sql = "INSERT INTO `brand` (name)
            VALUES (:name)";

        //!utiliser la méthode prepare() => requêtes préparées
        $pdoStatement = $pdo->prepare($sql);

        // Execution de la requête d'insertion (exec, pas query)
        // $insertedRows = $pdo->exec($sql);

        //! On exécute la requête préparée
        $pdoStatement->execute();

        // Si au moins une ligne ajoutée
        // if ($insertedRows > 0) {
        if ($pdoStatement > 0) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Méthode permettant de mettre à jour un enregistrement dans la table brand
     * L'objet courant doit contenir l'id, et toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        //? Ecriture de la requête UPDATE
        //? Interpolation = injection SQL
        // $sql = "
        //     UPDATE `brand`
        //     SET
        //         name = '{$this->name}',
        //         updated_at = NOW()
        //     WHERE id = {$this->id}
        // ";

        $sql = "UPDATE `brand`
            SET
                name = :name,
                updated_at = NOW()
            WHERE id = :id";

        //!prepare() pour faire des requêtes préparées
        $pdoStatement = $pdo->prepare($sql);

        //! On exécute la requête préparée
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


        // Execution de la requête de mise à jour (exec, pas query)
        // $updatedRows = $pdo->exec($sql);
        //? Plus besoin d'utiliser exec/query ?


        // On retourne VRAI, si au moins une ligne ajoutée
        return ($pdoStatement > 0);

        //TODO Gérer erreurs ?
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
