<?php

namespace App\Controllers;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;

/**
 * Admin page controller
 */
 Class AdminController extends AbstractController
 {
    public function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $userId = htmlspecialchars($_SESSION['id']);
        $user = new User;
        $usersList = $user->findAll();

        $model = new User;
        $user = $model->find($userId);

        $post = new Post;
        $posts = $post->findAll();

        $comment = new Comment;
        $userDataComment = ['id_user' => $userId];
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

    public function disableUser()
    {
        $disableUserId = $_POST['userId'];
        $model = new User;
        $disableUser = new User;
        $userId = htmlspecialchars($_SESSION['id']);
        $disableUserId = htmlspecialchars($_POST['userId']);
        $isVerified = htmlspecialchars($_POST['is_verified']);


        if (isset($disableUserId) && !empty($disableUserId) && isset($isVerified)) {
            $disableUser = $model->setIs_verified($isVerified);
            $id = "id = ".$disableUserId;
            $model->update($id, $disableUser);

            echo "données bien mise à jour";
        }

        $this->index($userId);
    }

    public function deleteUser()
    {
        $logUser = htmlspecialchars($_SESSION['logUser']);
        $deleteUserId = htmlspecialchars($_POST['userId']);
        $sessionId = htmlspecialchars($_SESSION['id']);

        if ( $logUser === 'admin' && isset($userId) && !empty($userId)) {
            $deleteUser = new User;

            // anonymization of comments
            $data = ['id_user'=> $deleteUserId];
            $modelComment = new Comment;
            $listComments = $modelComment->findBy($data);

            foreach ( $listComments as $comment ) {
                $idUser = "id_user = ".$deleteUserId;
                $comment = $modelComment->setId_user(2);
                $comment = $modelComment->update($idUser, $comment );
            }

            $deleteUser->delete($deleteUserId);
            echo "utilisateur supprimé";
        }

        $this->index($sessionId);
    }
}