<?php
namespace App\Controllers;

use App\Entity\Comment;
use App\Entity\ContactForm;
use App\Entity\Post;
use App\Entity\User;

/**
 * home page controller
 */
Class HomeController extends AbstractController
{
    public function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $model = new User;
        $user = new User;
        if(isset($_SESSION['id'])){
            $user = $model->find($_SESSION['id']);
        }

        return $this->twig->display('home/index.twig', ['user' => $user, 'ROOT' => $this->root,'session' => $_SESSION]);
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
            'ROOT' => $this->root
            ]);
        }

        return $this->twig->display('partial/pageFormError.twig');
    }
}