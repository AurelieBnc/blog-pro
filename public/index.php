<?php
use App\Core\Router as CoreRouter;


// We define a constant containing the root folder of the project
define('ROOT', dirname(__DIR__));

// We import the autoloader
require ROOT.'/vendor/autoload.php';

// We load my branch extension
require ROOT.'/src/Core/MyExtensionTwig.php';

// Load the environment file
Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

// We instantiate the router
$app = new CoreRouter();

// We start the application
$app->start();



