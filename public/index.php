<?php
use App\Core\Router as CoreRouter;
use App\Entity\Post;
use App\Entity\User;

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
// $datas = [
//     'title' => 'titre modifié',
//     'content' => 'contenu du post',
//     'author' => 'admin',
//     'slug' => 'slug3',
//     'id_user' => 1,
// ];

// $post = $model->hydrate($datas);

// $model->delete(3);

// $post = $model->findBy(['author'=> 'admin']);

// methode pour créer un post avec set /create
// $post = $model
//     ->setTitle('Nouvel article')
//     ->setContent('Nouveau contenu')
//     ->setAuthor('auteur')
//     ->setSlug('new slug')
//     ->setIdUser('1');

// $model->create($post);
// var_dump($post);
$model = new User;

$user = $model
    ->setLastname('bouh')
    ->setFirstname('ploup')
    ->setPseudonym('piou')
    ->setEmail('a@a.fr')
    ->setPassword(password_hash('azerty',PASSWORD_BCRYPT))
    ->setRole('utilisateur')
    ->setIs_verified('0');

$model->create($user);

