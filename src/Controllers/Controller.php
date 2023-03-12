<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Core\MyExtensionTwig;

abstract Class Controller
{
    private $loader;
    protected $twig;
    private $page = 'home';

    public function __construct()
    {
        //Set the folder containing templates
        $this->loader = new FilesystemLoader(__DIR__.'/../Templates');

        //Set Twig Environnement
        $this->twig = new Environment($this->loader, [
            'debug' => true,
            'cache' => false, //'../tmp',
        ]);

        //Current page name setting
        if (isset($_GET['p']))
        {
            $this->page = $_GET['p'];
        }
        $this->twig->addGlobal('current_page', $this->page);
        $this->twig->addExtension(new MyExtensionTwig());
    }

}