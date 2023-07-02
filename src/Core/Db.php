<?php 

namespace App\Core;

use PDO;
use PDOException;

// Design pattern singleton = only one possibility of instance
class Db extends PDO
{
    // Single instance of the class
    private static $instance;

    private function __construct()
    {
        // Login information
        $dbHost = htmlspecialchars($_ENV['DBHOST']);
        $dbUser = htmlspecialchars($_ENV['DBUSER']);
        $dbPass = htmlspecialchars($_ENV['DBPASS']);
        $dbName = htmlspecialchars($_ENV['DBNAME']);

        // Login DSN
        $_dsn = 'mysql:dbname='.$dbName.';host='.$dbHost;

        // We call the constructor of the PDO class
        try{
            parent::__construct($_dsn, $dbUser, $dbPass);

            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);

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