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
        // On implémente la méthode

        // Exemple d'utilisation : appel de la méthode statique
        // find à l'intérieur de la classe
        // $this ne fonctionnera pas, il faut utiliser à la place self::
        // Pour appeler ici find(), on va donc faire self::find()
        //$this->getEmail(); ==> génère une erreur car ici nous sommes dans une méthode statique, l'objet courant $this n'est pas accessible
        self::getEmail();
    }


    public static function findByEmail($email)
    {
        // Si on trouve un résultat pour l'email, retourner une instance de APPUser
        // Sinon, retourner false

        // Connexion BDD
        $pdo = Database::getPDO();

        // Interpolation = injection SQL
        $sql = "
            SELECT * FROM `app_user`
            WHERE email = :email
        ";

        //! Requete préparée
        $pdoStatement = $pdo->prepare($sql);

        // Executer la requete (on pourrait aussi utiliser bindvalue cf hier)
        $pdoStatement->execute([':email' => $email]);

        // Vu qu'il n'y a qu'1 email prévu en BDD 
        // Utiliser fetchObject => on attend qu'1 résultat
        // fetchObject attend argument type d'objet
        // permet de savoir à quelles propriétés on a acces
        $user = $pdoStatement->fetchObject('App\Models\AppUser'); // <= FQCM

        //! NB : $user peut contenir ou pas un objet User

        // si on trouve un résultat pour l'email, retourner une instance de AppUser
        // sinon, retourner false
        if ($user) {
            return $user;
        } else {
            return false;
        }

        // TODO Version plus courte sur une ligne en ternaire
        //TODO (condition) ? execution si condition vérifiée : exécution sinon
        // return ($user) ? $user : false;

    }

    //?S06 E06
    /**
     * Méthode pour récupérer tous les users
     * Copyright Audrey
     *
     * @return void
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM `app_user`';

        $pdoStatement = $pdo->query($sql);

        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, AppUser::class);

        // Version plus longue
        // $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, AppUser::class);
        // return $results;

        // AppUser::class revient à mettre le FQCN
    }

    //! S06 E06 AM2
    /**
     * Méthode pour ajouter user dans la Table app_user en BDD
     * (Version sans bindvalue)
     * @return booléan true if insertion ok, else false
     */
    public function insert()
    {
        // Copyright Romain

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

    //? Récupéré mais pas utilisé
    // Pierre O'clock => Condition affichage Onglet Liste Utilisateurs dans Menu
    // Méthode pratique qui permet de savoir facile si l'utilisateur a le role admin
    // public function isAdmin()
    // {
        // if ($this->role === "admin")
        //     return true;
        // else
        //     return false;

        //? Version raccourcie
        //?   return $this->role === "admin";
    // }



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
