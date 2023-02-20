<?php
//on importe l'autoloader
require '../vendor/autoload.php';
// Autoload::register();

use App\Router as CoreRouter;

//on définit une constante contenant le dossier racine du projet
// define('ROOT', dirname(__DIR__));

//on instancie le router
$app = new CoreRouter();

//On démarre l'application
$app->start();
