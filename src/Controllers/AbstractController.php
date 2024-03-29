<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Core\MyExtensionTwig;
use Twig\Extra\Intl\IntlExtension;

abstract Class AbstractController
{

    private $loader;

    private $page = 'home';

    protected $twig;

    public $root;


    public function __construct()
    {
        $this->root = 'http://localhost/blog-pro/public/';

        // We start a session
        session_start();

        isset($_SESSION) && isset($_SESSION['hasLoggedIn']) && $_SESSION['hasLoggedIn'] === true ?
            $_SESSION['logVisitor'] = false:
            $_SESSION['logVisitor'] = true;

        // Set the folder containing templates
        $this->loader = new FilesystemLoader(__DIR__.'/../Templates');

        // Set Twig Environnement
        $this->twig = new Environment($this->loader, [
            'debug' => true,
            'cache' => false, //'../tmp',
            'auto-reload' => true,
            // 'strict_variables' => true,
            'charset' => 'utf-8',
            // 'ROOT' => 'http://localhost/blog-pro/public/',
        ]);
        $page = htmlspecialchars($_GET['p']);
        // Current page name setting
        if (isset($page))
        {
            $this->page = $page;
        }

        $this->twig->addGlobal('current_page', $this->page);
        $this->twig->addExtension(new MyExtensionTwig());
        $this->twig->addExtension(new IntlExtension());
    }


}
