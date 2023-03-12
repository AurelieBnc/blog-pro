<?php
namespace App\Controllers;

/**
 * controlleur de la page d'accueil
 */
Class HomeController extends AbstractController
{
    public function index()
    {
        $this->twig->display('home/index.twig');
    }

    public function contact()
    {
        var_dump('GET = ', $_GET);
        var_dump('POST = ', $_POST);
        $this->twig->display('home/contact.twig',[
            'lastname' => $_POST['lastname'],
            'firstname' => $_POST['firstname'],
            'contentFormContact' => $_POST['content'],
            'email' => $_POST['email'],
    ]);
    }
}