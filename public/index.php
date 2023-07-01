<?php
use App\Core\Router as CoreRouter;
use App\Entity\Post;
use App\Entity\User;

// we define a constant containing the root folder of the project
define('ROOT', dirname(__DIR__));

// we import the autoloader
require ROOT.'/vendor/autoload.php';

// we load my branch extension
require ROOT.'/src/Core/MyExtensionTwig.php';


// load the environment file
Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

// we instantiate the router
$app = new CoreRouter();

// We start the application
$app->start();


//////////////// Test Db connect & methods
// $model = new Post;

// // hydration method for use with POST method of forms
// $datas = [
//     'title' => 'titre post test',
//     'content' => 'contenu du post',
//     'author' => 'admin',
//     'slug' => 'slugTESTpost',
//     'id_user' => 1,
// ];

// $post = $model->hydrate($datas);
// $model->create($post);
// var_dump($post);

// $model->delete(4);

// $post = $model->findBy(['author'=> 'admin']);

// methode pour créer un post avec set /create
// $post = $model
//     ->setTitle('Nouvel article')
//     ->setContent('Nouveau contenu')
//     ->setAuthor('auteur')
//     ->setSlug('new slug')
//     ->setId_User('1');

// $model->create($post);
// var_dump($post);

// $model = new User;

// $user = $model
//     ->setLastname('bouh')
//     ->setFirstname('ploup')
//     ->setPseudonym('piou')
//     ->setEmail('a@a.fr')
//     ->setPassword(password_hash('azerty',PASSWORD_BCRYPT))
//     ->setRole('utilisateur')
//     ->setIs_verified('0');

// $model->create($user);

