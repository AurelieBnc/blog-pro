<?php
namespace App\Controllers;

use App\Entity\Comment;
use App\Entity\ContactForm;
use App\Entity\Post;
use App\Entity\User;

/**
 * controlleur de la page d'accueil
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

    public function userPage()
    {
        if (!empty($_SESSION['id'])) {
            $model = new User;
            $user = $model->find($_SESSION['id']);
            $userData = ['id_user' =>$_SESSION['id']];

            $post = new Post;
            $posts = $post->findAll();

            $comment = new Comment;
            $comments = $comment->findBy($userData);

            return $this->twig->display('admin/index.twig', [
                'posts' => $posts,
                'comments' => $comments,
                'user' => $user,
                'ROOT' => $this->root,
                'session' => $_SESSION
            ]);

        } else {

            return $this->twig->display('register/index.twig', ['ROOT' => $this->root, 'session' => $_SESSION]);
        }

    }
}