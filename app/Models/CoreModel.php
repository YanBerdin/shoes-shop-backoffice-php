<?php

namespace App\Models;

// Classe mère de tous les Models
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les Models
class CoreModel


//! V2 : On ajoute le mot-clé abstract pour indiquer que CoreModel
//! est une classe abstraite
//! classe abstraite = classe qui a une ou plusieurs méthodes non implémentées (cad pas codées ici)
//! Ces méthodes devront être codées dans les classes filles
//! Si une classe fille veut hériter de CoreModel mais n'implemente pas une méthode de CoreModel => 
//! On aura une erreur
//TODO Abstract vu en Bonus
//? abstract class CoreModel
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;

    //! On déclare ici la (ou les) méthode(s) abstraites
    //! Les classes enfants devront implémenter ces méthdes là
    //? abstract static public function find($id);
    //?
    //TODO => Maintenant il faut implémenter find($id) dans CHAQUE Model


    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}
