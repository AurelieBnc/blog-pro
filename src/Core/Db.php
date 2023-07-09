<?php

namespace App\Core;

use PDO;
use PDOException;

class Db extends PDO
{

    private static $instance;


    private function __construct()
    {
        $dbHost = htmlspecialchars($_ENV['DBHOST']);
        $dbUser = htmlspecialchars($_ENV['DBUSER']);
        $dbPass = htmlspecialchars($_ENV['DBPASS']);
        $dbName = htmlspecialchars($_ENV['DBNAME']);

        $_dsn = 'mysql:dbname='.$dbName.';host='.$dbHost;

        try{
            parent::__construct($_dsn, $dbUser, $dbPass);

            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);

        }catch(PDOException $e){
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
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
