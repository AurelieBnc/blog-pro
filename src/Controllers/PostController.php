<?php
namespace App\Controllers;

use App\Entity\Post;

Class PostController extends AbstractController
{
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
        //var_dump($posts);
        $this->twig->display('post/index.twig', ['posts' => $posts]);
    }

    // public function post($id)
    // {
    //     $this->twig->display('post/index.twig/'.$id);
    // }

}