<?php
namespace App\Controllers;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;

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

        $comment = new Comment;
        $postDataComment = ['id_post' => $_POST['postId']];
        $comments = $comment->findBy($postDataComment);

        $user = new User;
        $users = $user->findAll();

        $this->twig->display('post/retailPost.twig', [
            'ROOT' => $this->root,
            'post' => $post,
            'session' => $_SESSION,
            'comments' => $comments,
            'users' => $users
        ]);

    }

    public function disableComment()
    {
        $userId = $_SESSION['id'];
        $commentId = $_POST['commentId'];
        $isEnabled = $_POST['is_enabled'];
        $model = new Comment;
        $disableComment = new Comment;

        if (isset($userId) && !empty($commentId) && isset($isEnabled))
        {
            $disableComment = $model->setIs_enabled($isEnabled);
            $id = "id = ".$commentId;
            $model->update($id, $disableComment);
            echo "données bien mise à jour";
        }

        $postId = $_POST['postId'];
        $model = new Post;
        $post = $model->find($postId);

        $comment = new Comment;
        $postDataComment = ['id_post' => $_POST['postId']];
        $comments = $comment->findBy($postDataComment);

        $user = new User;
        $users = $user->findAll();

        $this->twig->display('post/retailPost.twig', [
            'ROOT' => $this->root,
            'post' => $post,
            'session' => $_SESSION,
            'comments' => $comments,
            'users' => $users
        ]);

    }

    public function deleteComment()
    {
        $userId = $_SESSION['id'];
        $commentId = $_POST['commentId'];
        $model = new Comment;

        $model->delete($commentId);

        $postId = $_POST['postId'];
        $model = new Post;
        $post = $model->find($postId);

        $comment = new Comment;
        $userDataComment = ['id_user' => $userId];
        $comments = $comment->findBy($userDataComment);

        $user = new User;
        $users = $user->findAll();

        $this->twig->display('post/retailPost.twig', [
            'ROOT' => $this->root,
            'post' => $post,
            'session' => $_SESSION,
            'comments' => $comments,
            'users' => $users
        ]);
    }
}