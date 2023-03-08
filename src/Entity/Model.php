<?php

namespace App\Entity;

use App\Db\Db;

class Model extends Db
{
    //Table de la base de données
    protected $table;

    // Instance de Db
    private $db;

    public function runQuery(string $sql, array $attributs = null)
    {
    // On récupére l'instance de Db
    $this->db = Db::getInstance();

        // On vérifie si on a des attributs
        if ($attributs !== null) {
            //requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            //requête simple
            return $this->db->query($sql);
        }
    }

    // READ
    public function find(int $id)
    {
        return $this->runQuery('SELECT * FROM '.$this->table.' WHERE id = '.$id)->fetch();
    }

    public function findAll()
    {
        $query = $this->runQuery('SELECT * FROM '.$this->table);
        return $query->fetchAll();
    }

    public function findBy(array $datas)
    {
        $champs = [];
        $valeurs= [];

        //On boucle pour éclater le tableau
        foreach($datas as $champ => $valeur){
            //SELECT * FROM annonces WHERE id = ? AND  test = ?
            //bindValue(1, valeur)
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        //On transforme le tableau champts en une chaine de caractéres
        $list_champs= implode(' AND ', $champs);

        //on exédute la requête
        return $this->runQuery('SELECT *FROM '.$this->table.' WHERE '. $list_champs, $valeurs)->fetchAll();
    }

   // CREATE
    public function create(Model $model)
    {

        $champs = [];
        $nbchamps = [];
        $valeurs= [];

        //On boucle pour éclater le tableau
        foreach ($model as $champ => $valeur){
            //INSERT INTO post (titre, content, author ect) VALUES (?, ?, ?)
            if ($valeur != null && $champ != 'db' && $champ !='table')
            {
                $champs[] = "$champ";
                $nbchamps[] = "?";
                $valeurs[] = $valeur;
            }

        }

        //On transforme le tableau champts en une chaine de caractéres
        $list_champs= implode(', ', $champs);
        $list_nb_champs = implode(', ', $nbchamps);

        //on exédute la requête
        return $this->runQuery('INSERT INTO '.$this->table.' ('. $list_champs.') VALUES('.$list_nb_champs.')', $valeurs);
    }

    public function hydrate(array $datas)
    {
        foreach ($datas as $key => $value)
        {
            //on récupère le setter correspondant à la clé (key)
            $setter = 'set'.ucfirst($key);

            //on vérifie si le setter existe
            if (method_exists($this, $setter))
            {
                //on appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }
}