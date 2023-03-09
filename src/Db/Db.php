<?php 

namespace App\Db;

use PDO;
use PDOException;

//Design patterne singleton = une seule possibilité d'instance
class Db extends PDO
{
    // Instance unique de la classe
    private static $instance;

    private function __construct()
    {
        // Informations de connexion
        $dbHost = $_ENV['DBHOST'];
        $dbUser = $_ENV['DBUSER'];
        $dbPass = $_ENV['DBPASS'];
        $dbName = $_ENV['DBNAME'];

        // DSN de connexion
        $_dsn = 'mysql:dbname='.$dbName.';host='.$dbHost;

        // On appelle le constructeur de la classe PDO
        try{
            parent::__construct($_dsn, $dbUser, $dbPass);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SEET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance():self
    {
        if(self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

}