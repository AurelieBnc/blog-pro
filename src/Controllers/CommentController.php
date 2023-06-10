<?php
namespace App\Controllers;

use App\Entity\Comment;
use App\Entity\Post;

Class CommentController extends AbstractController
{
    public function addComment()
    {
        $model = new Comment;

        $comment = $model
            ->setContent($_POST['content'])
            ->setIs_enabled('0')
            ->setId_User($_POST['userId'])
            ->setId_Post($_POST['postId']);

        $model->create($comment);

        $post = new Post;
        $post = $post->find($_POST['postId']);

        $this->twig->display('post/retailPost.twig', ['ROOT' => $this->root,'post' => $post, 'session' => $_SESSION]);
    }
}