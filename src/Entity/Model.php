<?php

namespace App\Entity;

use App\Core\Db;
use Exception;
use PDO;
use PDOStatement;

class Model extends Db
{

    protected $table;

    private $db;

    private $last_id = null;

    public function runQuery(string $sql, array $attributs = null): PDOStatement
    {
    $this->db = Db::getInstance();
    $this->db->exec("SET NAMES 'utf8';");

    if ($attributs !== null) {
        $query = $this->db->prepare($sql);
        $query->execute($attributs);
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


    /**
     * @return array|bool
     */
    public function find(int $idModel)
    {
        /**@var string $rqtSql */
        switch ($this->table) {
            case "user":
                $rqtSql = 'SELECT * FROM user WHERE id = ';
                break;
            case "comment":
                $rqtSql = 'SELECT * FROM comment WHERE id = ';
                break;
            case "contactform":
                $rqtSql = 'SELECT * FROM contactform WHERE id = ';
                break;
            case "post":
                $rqtSql = 'SELECT * FROM post WHERE id = ';
                break;
            default:
                throw new Exception('Cette table n\'est pas reconnue');
                break;
        }
        return $this->runQuery($rqtSql.$idModel)->fetch();
    }


    public function findAll(): array
    {
        /**@var string $rqtSql */
        switch ($this->table) {
            case "user":
                $rqtSql = 'SELECT * FROM user';
                break;
            case "comment":
                $rqtSql = 'SELECT * FROM comment';
                break;
            case "contactform":
                $rqtSql = 'SELECT * FROM contactform';
                break;
            case "post":
                $rqtSql = 'SELECT * FROM post';
                break;
            default:
                throw new Exception('Cette table n\'est pas reconnue');
                break;
        }

        return $this->runQuery($rqtSql)->fetchAll();
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

        /**@var string $rqtSql */
        switch ($this->table) {
            case "user":
                $rqtSql = 'SELECT * FROM user WHERE ';
                break;
            case "comment":
                $rqtSql = 'SELECT * FROM comment WHERE ';
                break;
            case "contactform":
                $rqtSql = 'SELECT * FROM contactform WHERE ';
                break;
            case "post":
                $rqtSql = 'SELECT * FROM post WHERE ';
                break;
            default:
                throw new Exception('Cette table n\'est pas reconnue');
                break;
        }

        return $this->runQuery($rqtSql. $list_champs, $valeurs)->fetchAll();
    }


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

        /**@var string $rqtSql */
        switch ($this->table) {
            case "user":
                $rqtSql = 'INSERT INTO user';
                break;
            case "comment":
                $rqtSql = 'INSERT INTO comment';
                break;
            case "contactform":
                $rqtSql = 'INSERT INTO contactform';
                break;
            case "post":
                $rqtSql = 'INSERT INTO post';
                break;
            default:
                throw new Exception('Cette table n\'est pas reconnue');
                break;
        }

        return $this->runQuery($rqtSql.' ('. $list_champs.') VALUES('.$list_nb_champs.')', $valeurs);
    }


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


        /**@var string $rqtSql */
        switch ($this->table) {
            case "user":
                $rqtSql = 'UPDATE user';
                break;
            case "comment":
                $rqtSql = 'UPDATE comment';
                break;
            case "contactform":
                $rqtSql = 'UPDATE contactform';
                break;
            case "post":
                $rqtSql = 'UPDATE post';
                break;
            default:
                throw new Exception('Cette table n\'est pas reconnue');
                break;
        }

        return $this->runQuery($rqtSql.' SET '. $list_champs.' WHERE '.$id, $valeurs);
    }


    public function delete(int $id): PDOStatement
    {
        /**@var string $rqtSql */
        switch ($this->table) {
            case "user":
                $rqtSql = 'DELETE FROM user';
                break;
            case "comment":
                $rqtSql = 'DELETE FROM comment';
                break;
            case "contactform":
                $rqtSql = 'DELETE FROM contactform';
                break;
            case "post":
                $rqtSql = 'DELETE FROM post';
                break;
            default:
                throw new Exception('Cette table n\'est pas reconnue');
                break;
        }

        return $this->runQuery($rqtSql.' WHERE id=?', [$id]);
    }


}
