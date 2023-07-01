<?php

namespace App\Entity;

use App\Core\Db;

class Model extends Db
{
    // Database table
    protected $table;

    // DB instance
    private $db;
    private $last_id = null;

    public function runQuery(string $sql, array $attributs = null)
    {
    // We get the instance of Db
    $this->db = Db::getInstance();
    $this->db->exec("SET NAMES 'utf8';");

        // We check if we have attributes
        if ($attributs !== null) {
            // prepared statement
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            if($this->db->lastInsertId()) {
                $this->last_id = $this->db->lastInsertId();
            }
            return $query;
        } else {
            // Simple query
            $query = $this->db->query($sql);
            if($this->db->lastInsertId()) {
                $this->last_id = $this->db->lastInsertId();
            }
            return $query;
        }
    }

    public function lastId()
    {
        return $this->last_id;
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

        // We loop to explode the array
        foreach($datas as $champ => $valeur){
            // SELECT * FROM annonces WHERE id = ? AND  test = ?
            // bindValue(1, valeur)
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        // We transform the array fields into a string of characters
        $list_champs= implode(' AND ', $champs);

        // Execute the request
        return $this->runQuery('SELECT *FROM '.$this->table.' WHERE '. $list_champs, $valeurs)->fetchAll();
    }

   // CREATE
    public function create(Model $model)
    {

        $champs = [];
        $nbchamps = [];
        $valeurs= [];

        // We loop to explode the array
        foreach ($model as $champ => $valeur){
            // INSERT INTO post (titre, content, author ect) VALUES (?, ?, ?)
            if ($valeur != null && $champ != 'db' && $champ !='table')
            {
                $champs[] = $champ;
                $nbchamps[] = "?";
                $valeurs[] = $valeur;
            }

        }

        // We transform the array fields into a string of characters
        $list_champs= implode(', ', $champs);
        $list_nb_champs = implode(', ', $nbchamps);

        // Execute the request
        return $this->runQuery('INSERT INTO '.$this->table.' ('. $list_champs.') VALUES('.$list_nb_champs.')', $valeurs);
    }

    public function hydrate(array $datas)
    {
        foreach ($datas as $key => $value)
        {
            // We retrieve the setter corresponding to the key (key)
            $setter = 'set'.ucfirst($key);

            // We check if the setter exists
            if (method_exists($this, $setter))
            {
                // We call the setter
                $this->$setter($value);
            }
        }
        return $this;
    }

    // UPDATE
    public function update(string $id, Model $model)
    {
        $champs = [];
        $valeurs= [];

        // We loop to explode the table
        foreach ($model as $champ => $valeur){
            // UPDATE post SET titre = ?, content = ?, author =? .. WHERE id = ?
            if ($valeur != null && $champ != 'db' && $champ !='table')
            {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }

        }

        // We transform the array fields into a string of characters
        $list_champs= implode(', ', $champs);

        // Execute the request
        return $this->runQuery('UPDATE '.$this->table.' SET '. $list_champs.' WHERE '.$id, $valeurs);
    }

    // DELETE
    public function delete(int $id)
    {
        return $this->runQuery('DELETE FROM '.$this->table.' WHERE id=?', [$id]);
    }
}