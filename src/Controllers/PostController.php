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

    /**
     * affiche un post en particulier
     */
    public function retailPost(int $id)
    {
        $post = new Post;

        $post = $post->find($id);

        $this->twig->display('post/retailPost.twig', ['post' => $post]);
    }

}