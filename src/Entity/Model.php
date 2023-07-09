<?php

namespace App\Entity;

use App\Core\Db;
use PDOStatement;

class Model extends Db
{

    protected $table;

    private $db;

    private $last_id = null;


    public function runQuery(string $sql, array $attributs = null): void
    {
    $this->db = Db::getInstance();
    $this->db->exec("SET NAMES 'utf8';");


    if ($attributs !== null) {
        $query = $this->db->prepare($sql);
        //$query->bindParam(1, $attributs[0]);
        $query->execute($attributs);
        // foreach ($attributs as $valeur){
        //     $champ =+ 1;
        //     $query->bindParam($champ, $valeur);
        // }
        // // $query->bindParam(':thisTable', $this->table);

        // $query->execute();
        if($this->db->lastInsertId()) {
            $this->last_id = $this->db->lastInsertId();
        }
        return $query;

        } else {
            $query = $this->db->query($sql);
            if($this->db->lastInsertId()) {
                $this->last_id = $this->db->lastInsertId();
            }
            return $query;
        }
    }


    public function lastId(): int
    {
        return $this->last_id;
    }


    public function find(int $idModel): array
    {
        return $this->runQuery('SELECT * FROM '.$this->table.' WHERE id = '.$idModel)->fetch();
    }


    public function findAll(): array
    {
        // $value[] = $this->table;
        // var_dump($value);
        $query = $this->runQuery('SELECT * FROM '.$this->table);
        return $query->fetchAll();
    }


    public function findBy(array $datas): array
    {
        $champs = [];
        $valeurs= [];

        foreach($datas as $champ => $valeur){
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        $list_champs= implode(' AND ', $champs);

        return $this->runQuery('SELECT * FROM '.$this->table.' WHERE '. $list_champs, $valeurs)->fetchAll();
    }

//ok
    public function create(Model $model): PDOStatement
    {
        $champs = [];
        $nbchamps = [];
        $valeurs= [];

        foreach ($model as $champ => $valeur) {
            if ($valeur !== null && $champ !== 'db' && $champ !=='table')
            {
                $champs[] = $champ;
                $nbchamps[] = "?";
                $valeurs[] = $valeur;
            }
        }

        $list_champs= implode(', ', $champs);
        $list_nb_champs = implode(', ', $nbchamps);

        return $this->runQuery('INSERT INTO '.$this->table.' ('. $list_champs.') VALUES('.$list_nb_champs.')', $valeurs);
    }

//ok
    public function hydrate(array $datas): self
    {
        foreach ($datas as $key => $value)
        {
            $setter = 'set'.ucfirst($key);

            if (method_exists($this, $setter))
            {
                $this->$setter($value);
            }
        }
        return $this;
    }


    public function update(string $id, Model $model): PDOStatement
    {
        $champs = [];
        $valeurs= [];

        foreach ($model as $champ => $valeur){
            if ($valeur !== null && $champ !== 'db' && $champ !=='table')
            {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }

        }

        $list_champs= implode(', ', $champs);

        return $this->runQuery('UPDATE '.$this->table.' SET '. $list_champs.' WHERE '.$id, $valeurs);
    }


    public function delete(int $id): PDOStatement
    {
        return $this->runQuery('DELETE FROM '.$this->table.' WHERE id=?', [$id]);
    }


}
