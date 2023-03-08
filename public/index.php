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

// méthode d'hydratation pour utilisation avec méthode POST des forms
$datas = [
    'title' => 'titre hydratée',
    'content' => 'contenu du post',
    'author' => 'admin',
    'slug' => 'slug2',
    'id_user' => 1
];

$post = $model->hydrate($datas);

// $post = $model->findBy(['author'=> 'admin']);

// methode pour créer un post avec set /create
// $post = $model
//     ->setTitle('Nouvel article')
//     ->setContent('Nouveau contenu')
//     ->setAuthor('auteur')
//     ->setSlug('new slug')
//     ->setIdUser('1');

$model->create($post);
var_dump($post);

