<?php
namespace App\Core;

use App\Controllers\HomeController;
use Exception;

/**
 * Main router
 */
Class Router
{
    public function start()
    {
        try {
            // Get URL
            $uri = htmlspecialchars($_SERVER['REQUEST_URI']);

            // we remove the possible "trailing slash" from the url
            if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {
                $uri = substr($uri, 0, -1);

                // we send a permanent redirect code
                http_response_code(301);

                // we redirect to the url without /
                //header('Location: '.$uri); //ko redirige en boucle car il détecte un slash malgré les conditions.
            }

            // management of url parameters
            $params = [];
            $page = $_GET['p'];

            if (isset($page)) {
                $params = explode('/', $page);
            }
            $controllerName = array_shift($params);

            if ($controllerName !== '') {
                $controller = '\\App\\Controllers\\'.ucfirst($controllerName).'Controller';

                // controller instance if exist
                if (class_exists($controller)) {
                    $controller = new $controller();
                } else {
                    throw new Exception('Aucun controller correspondant');
                }

                foreach($params as $param) {
                    if (isset($params[0]) && $params[0] === $controllerName) {
                        array_shift($params);
                    }
                }

                // we get the second parameter
                $action = (isset($params[0])) ? array_shift($params) : 'index';

                if (method_exists($controller, $action)) {
                    isset($params) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
                } else {
                    header('HTTP/1.0 404 Not Found');
                    throw new Exception("La page recherchée n\'existe pas");
                }

            } else {
                // any parameter, default controller instance
                $controller = new HomeController;
                $controller->index();
            }
        } catch (Exception $e) {
            echo 'Erreur : '.$e->getMessage();
        }
    }
}