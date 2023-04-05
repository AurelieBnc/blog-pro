<?php
namespace App\Controllers;

use App\Entity\ContactForm;
use App\Entity\User;

/**
 * controlleur de la page d'accueil
 */
Class HomeController extends AbstractController
{
    public function index()
    {
        $this->twig->display('home/index.twig', ['ROOT' => 'http://localhost/blog-pro/public/']);
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

        return $this->twig->display('partial/pageFormError.twig', ['ROOT' => 'http://localhost/blog-pro/public/']);
    }

    public function userPage()
    {
        // Validation du formulaire
        if (isset($_POST['email']) &&  isset($_POST['password']))
        {
            // Recherche de l'utilisateur
            $user = new User;
            $users = $user->findBy($_POST);
            $user_exist = false;

            foreach ($users as $user) {
                if (
                    $user['email'] === $_POST['email'] &&
                    $user['password'] === $_POST['password']
                    )
                {
                    $user_exist = true;
                }
            }
            if ( $user_exist )
            {
                // Vérification du role de l'utilisateur et redirection
                if ($user['role'] === 'admin' && $user['is_verified'] === '1')
                {
                    //todo :  bug => n'affiche pas la bonne route dans l'url mais suis bien la bonne url (admin)??
                    echo 'je suis un admin';
                    return $this->twig->display('admin/index.twig', ['ROOT' => 'http://localhost/blog-pro/public/']);
                }
                if ($user['role'] === 'utilisateur' && $user['is_verified'] === '1')
                {
                    echo 'je ne suis pas un admin';
                    return $this->twig->display('home/userPage.twig', ['ROOT' => 'http://localhost/blog-pro/public/']);
                }

            } else {
                //todo modifier la page d'erreur
                return $this->twig->display('partial/userNotFind.twig', ['ROOT' => 'http://localhost/blog-pro/public/']);
            }
        }

        return $this->twig->display('partial/pageFormError.twig', ['ROOT' => 'http://localhost/blog-pro/public/']);
    }
}                //todo créer une variable global pour la root