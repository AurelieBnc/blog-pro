<?php
namespace App\Controllers;

use Twig\Environnement;
use Twig\Loader\FilesystemLoader;

Abstract Class Controller
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        // // on paramètre le dossier contenant nos templates
        // $this->loader = new FilesystemLoader  (ROOT.'/templates');

        // // on paramètre l'environnement Twig
        // $this->twig = new Environnement($this->loader);
    }
}