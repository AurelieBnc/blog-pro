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
        $this->twig->display('home/index.twig');
    }

    public function contact()
    {

        if(!empty($_POST))
        {
            $this->twig->display('home/contact.twig',[
            'lastname' => $_POST['lastname'],
            'firstname' => $_POST['firstname'],
            'contentFormContact' => $_POST['content'],
            'email' => $_POST['email'],
            ]);

            $model = new ContactForm;
            $contactForm = $model->hydrate($_POST);
            $model->create($contactForm);
        }

        $this->twig->display('partial/pageFormError.twig');
    }

}