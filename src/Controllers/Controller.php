<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract Class Controller
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        // on paramètre le dossier contenant nos templates
        $this->loader = new FilesystemLoader(__DIR__.'/../Templates');

        // on paramètre l'environnement Twig
        $this->twig = new Environment($this->loader, [
            'debug' => true,
            'cache' => false, //'../tmp',
        ]);
    }

}