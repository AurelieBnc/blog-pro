<?php

namespace App\Controllers;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;

/**
 * Controlleur de la page admin
 */
 Class AdminController extends AbstractController
 {
    public function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $user = new User;
        $usersList = $user->findAll();

        $model = new User;
        $user = $model->find($_SESSION['id']);

        $post = new Post;
        $posts = $post->findAll();

        $comment = new Comment;
        $userDataComment = ['id_user' => $_SESSION['id']];
        $comments = $comment->findBy($userDataComment);

        $this->twig->display('admin/index.twig', [
            'user' => $user,
            'users' => $usersList,
            'posts' => $posts,
            'comments' => $comments,
            'ROOT' => $this->root,
            'session' => $_SESSION
        ]);
    }

    public function newPost()
    {
        $this->twig->display('admin/createPost.twig', ['ROOT' => $this->root,'session' => $_SESSION]);
    }

    public function manageUser()
    {
        $this->twig->display('admin/manageUser.twig', ['ROOT' => $this->root,'session' => $_SESSION]);
    }
}