<?php
namespace App\Core;

Class Router
{
    public function start()
    {
        echo "je suis le routeur \n";

        //http://blog-pro/controleur/methode/parametres
        //http://blog-pro/list-post/post/id
        //http://blog-pro/index.php?=list-post/post/id

        //pour ça besoin de créer un fichier .htaccess
        var_dump($_GET);
    }
}