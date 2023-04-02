<?php
namespace App\Core;

use App\Controllers\HomeController;

/**
 * Main router
 */
Class Router
{
    public function start()
    {
        // Get URL
        $uri = $_SERVER['REQUEST_URI'];

        // we remove the possible "trailing slash" from the url
        if(!empty($uri) && $uri != '/' && $uri[-1] === "/"){
            $uri = substr($uri, 0, -1);

            // we send a permanent redirect code
            http_response_code(301);

            // we redirect to the url without /
            //header('Location: '.$uri); //ko redirige en boucle car il détecte un slash malgré les conditions.
        }

        // management of url parameters
        $params = [];
        if(isset($_GET['p'])){
            $params = explode('/', $_GET['p']);
        }

        if($params[0] !== ''){
            $controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)).'Controller';

            // controller instance if exist
            if(class_exists($controller)){
                $controller = new $controller();
            }

            // we get the second parameter
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if(method_exists($controller, $action)){
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            }else{
                // http_response_code(404);
                // echo 'La page recherchée n\'existe pas';
                header('HTTP/1.0 404 Not Found');
                echo "cette page n'existe pas";
            }

        }else{
            //any parameter, default controller instance
            $controller = new HomeController;
            $controller->index();
        }
    }
}