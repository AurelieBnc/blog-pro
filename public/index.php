<?php
use App\Core\Router as CoreRouter;
use App\Entity\Post;

//on définit une constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

//on importe l'autoloader
require ROOT.'/vendor/autoload.php';
// Autoload::register();

//on instancie le router
$app = new CoreRouter();

//On démarre l'application
$app->start();

$model = new Post;

// $post = $model->findBy(['author'=> 'admin']);
$post = $model->find(1);

var_dump($post);

