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
        $lastname = htmlspecialchars($_POST['lastname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $content = htmlspecialchars($_POST['content']);
        $email = htmlspecialchars($_POST['email']);
        $datas = [];

        if (isset($lastname) && isset($firstname) && isset($content) && isset($email)) {
            $datas = [
                'lastname' => $lastname,
                'firstname' => $firstname,
                'content' => $content,
                'email' => $email];
        }

        if (!empty($datas))
        {
            $model = new ContactForm;
            $contactForm = $model->hydrate($datas);
            $model->create($contactForm);

            return $this->twig->display('home/contact.twig',[
            'lastname' => $lastname,
            'firstname' => $firstname,
            'contentFormContact' => $content,
            'email' => $email,
            'ROOT' => $this->root
            ]);
        }

        return $this->twig->display('partial/pageFormError.twig');
    }
}