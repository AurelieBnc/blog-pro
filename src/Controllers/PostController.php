<?php
namespace App\Controllers;

use App\Entity\Post;

Class PostController extends AbstractController
{
    public function __construct() {
        parent::__construct();
    }

    /**
     * Methode affichant la liste de tous les posts
     */
    public function index()
    {
        // on instancie le model correspondant à la table des "posts"
        $post = new Post;

        //on va chercher tous les posts
        //todo-ajouter éventuellement la possibilité de désactiver un post en ajoutant une propriété "active" et findBy(['actif' => 1])
        $posts = $post->findAll();
        $this->twig->display('post/index.twig', ['posts' => $posts,'session' => $_SESSION]);
    }

    /**
     * affiche un post en particulier
     */
    public function retailPost(int $id)
    {
        $post = new Post;

        $post = $post->find($id);

        $this->twig->display('post/retailPost.twig', ['post' => $post, 'session' => $_SESSION]);
    }

    public function createPost()
    {
        $model = new Post;

        $post = $model
            ->setTitle($_POST['title'])
            ->setLead($_POST['lead'])
            ->setContent($_POST['content'])
            ->setId_User($_SESSION['id']);


        $model->create($post);
        $lastId = $post->lastId();

        $this->retailPost($lastId);

    }
}