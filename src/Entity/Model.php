<?php

namespace App\Entity;

use App\Core\Db;

class Model extends Db
{
    //Table de la base de données
    protected $table;

    //Instance de Db
    private $db;

    public function runQuery(string $sql, array $attributs = null)
    {
    //On récupére l'instance de Db
    $this->db = Db::getInstance();
    $this->db->exec("SET NAMES 'utf8';");

        //On vérifie si on a des attributs
        if ($attributs !== null) {
            // requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            //Requête simple
            return $this->db->query($sql);
        }
    }

    //READ
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

        //On exédute la requête
        return $this->runQuery('SELECT *FROM '.$this->table.' WHERE '. $list_champs, $valeurs)->fetchAll();
    }

   //CREATE
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
                $champs[] = $champ;
                $nbchamps[] = "?";
                $valeurs[] = $valeur;
            }

        }

        //On transforme le tableau champts en une chaine de caractéres
        $list_champs= implode(', ', $champs);
        $list_nb_champs = implode(', ', $nbchamps);

        //On exédute la requête
        return $this->runQuery('INSERT INTO '.$this->table.' ('. $list_champs.') VALUES('.$list_nb_champs.')', $valeurs);
    }

    public function hydrate(array $datas)
    {
        foreach ($datas as $key => $value)
        {
            //On récupère le setter correspondant à la clé (key)
            $setter = 'set'.ucfirst($key);

            //On vérifie si le setter existe
            if (method_exists($this, $setter))
            {
                //On appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }

    //UPDATE
    public function update(int $id, Model $model)
    {
        $champs = [];
        $valeurs= [];

        //On boucle pour éclater le tableau
        foreach ($model as $champ => $valeur){
            //UPDATE post SET titre = ?, content = ?, author =? .. WHERE id = ?
            if ($valeur != null && $champ != 'db' && $champ !='table')
            {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }

        }
        $valeurs[] = $id;

        //On transforme le tableau champts en une chaine de caractéres
        $list_champs= implode(', ', $champs);

        //On exédute la requête
        return $this->runQuery('UPDATE '.$this->table.' SET '. $list_champs.' WHERE id = ?', $valeurs);
    }

    //DELETE
    public function delete(int $id)
    {
        return $this->runQuery('DELETE FROM '.$this->table.' WHERE id=?', [$id]);
    }
}