<?php
namespace App\Controllers;

use App\Entity\ContactForm;

/**
 * controlleur de la page d'accueil
 */
Class HomeController extends AbstractController
{
    public function index()
    {
        var_dump('index session :', $_SESSION);
        $this->twig->display('home/index.twig', ['session' => $_SESSION]);
    }

    public function contact()
    {
        if(!empty($_POST))
        {
            $model = new ContactForm;
            $contactForm = $model->hydrate($_POST);
            $model->create($contactForm);

            return $this->twig->display('home/contact.twig',[
            'lastname' => $_POST['lastname'],
            'firstname' => $_POST['firstname'],
            'contentFormContact' => $_POST['content'],
            'email' => $_POST['email'],
            'ROOT' => 'http://localhost/blog-pro/public/'
            ]);

        }

        return $this->twig->display('partial/pageFormError.twig');
    }

    public function userPage()
    {
        return $this->twig->display('home/userPage.twig', [ 'session' => $_SESSION]);
    }
}                //todo créer une variable global pour la root