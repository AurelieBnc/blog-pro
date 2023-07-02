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

        $content = htmlspecialchars($_POST['content']);
        $userId = htmlspecialchars($_POST['userId']);
        $postId = htmlspecialchars($_POST['postId']);

        if (isset($content) && isset($userId) && isset($postId) ) {
            $comment = $model
                ->setContent($content)
                ->setIs_enabled('0')
                ->setId_User($userId)
                ->setId_Post($postId);

            $model->create($comment);
        }


        $post = new Post;
        $post = $post->find($postId);

        $comment = new Comment;
        $userDataComment = ['id_post' => $postId];
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

    public function disableComment()
    {
        $commentId = htmlspecialchars($_POST['commentId']);
        $isEnabled = htmlspecialchars($_POST['is_enabled']);
        $userId = $_SESSION['id'];

        $model = new Comment;
        $disableComment = new Comment;

        if (isset($userId) && !empty($commentId) && isset($isEnabled))
        {
            $disableComment = $model->setIs_enabled($isEnabled);
            $idUser = "id = ".$commentId;
            $model->update($idUser, $disableComment);
            echo "données bien mise à jour";
        }

        $postId = htmlspecialchars($_POST['postId']);
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

    public function deleteComment()
    {
        $commentId = htmlspecialchars($_POST['commentId']);;

        $model = new Comment;
        $model->delete($commentId);

        $postId = htmlspecialchars($_POST['postId']);
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
}