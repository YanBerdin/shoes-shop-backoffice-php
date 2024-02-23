<?php

namespace App\Models;
// classe abstraite = classe qui a une ou plusieurs méthodes non implémentées ici
// Ces méthodes devront être codées dans les classes filles
// Si une classe fille veut hériter de CoreModel mais n'implemente pas une méthode de CoreModel => 
// On aura une erreur
//TODO  abstract class CoreModel
class CoreModel
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

    //* On déclare ici la (ou les) méthode(s) abstraites
    //* Les classes enfants devront implémenter ces méthdes là
    // J'indique que toute classe qui hérite de CoreModel DOIT IMPERATIVEMENT
    // implémenter une méthode find qui doit etre statique
    // Attention, elle n'oblige rien au niveau du CONTENU de la méthode
    //? abstract static public function find($id);
    //? => Maintenant il faut implémenter find($id) dans CHAQUE Model
    // abstract static function find( $id );
    // abstract static function findAll();
    // abstract function insert();
    // abstract function update();
    // abstract function delete();

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
