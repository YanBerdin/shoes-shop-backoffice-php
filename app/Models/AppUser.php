<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel
{
    private $email;
    private $password;
    private $firstname;
    private $lastname;
    private $role;
    private $status;

    public static function find($id)
    {
        // Mémo : méthode statique, l'objet courant $this n'est pas accessible
        self::getEmail();
    }


    public static function findByEmail($email)
    {
        // Si ok email, retourne une instance de $user
        // Sinon, retourne false

        $pdo = Database::getPDO();

        $sql = "
            SELECT * FROM `app_user`
            WHERE email = :email
        ";

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute([':email' => $email]);

        // fetchObject attend argument type d'objet
        // permet de savoir à quelles propriétés on a acces
        $user = $pdoStatement->fetchObject(self::class);

        // NB : $user peut contenir ou pas un objet User
        if ($user) {
            return $user;
        } else {
            return false;
        }

        // Ternaire
        // (condition) ? execution si condition vérifiée : sinon exécution
        // return ($user) ? $user : false;
    }

    /**
     * Récupérer tous les users
     *
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM `app_user`';

        $pdoStatement = $pdo->query($sql);

        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        // Version + longue
        // $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, AppUser::class);
        // return $results;
    }

    /**
     * Méthode pour ajouter user dans la Table app_user en BDD
     * 
     * @return booléan true if insertion ok, else false
     */
    public function insert()
    {

        $pdo = Database::getPDO();

        $sql = "
        INSERT INTO `app_user`
        (`email`, `password`, `firstname`, `lastname`, `role`, `status`)
        VALUES (:email, :password, :firstname, :lastname, :role, :status)
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->execute([
            ':email' =>  $this->email,
            ':password' => $this->password,
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':role' => $this->role,
            ':status' => $this->status,
        ]);

        // Si au moins 1 ligne a été MAJ
        if ($pdoStatement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
