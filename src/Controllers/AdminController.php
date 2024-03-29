<?php

namespace App\Controllers;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Exception;

/**
 * Admin page controller
 */
 Class AdminController extends AbstractController
 {


    public function __construct() {
        parent::__construct();
    }


    /**
     * admin page index
     */
    public function index(): ?self
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

        return $this->twig->display('admin/index.twig', [
            'user' => $user,
            'users' => $usersList,
            'posts' => $posts,
            'comments' => $comments,
            'ROOT' => $this->root,
            'session' => $_SESSION
        ]);
    }


    /**
     * function to deactivate a user
     */
    public function disableUser(): ?self
    {
        $disableUserId = htmlspecialchars($_POST['userId']);
        $model = new User;
        $disableUser = new User;
        $userId = htmlspecialchars($_SESSION['id']);
        $disableUserId = htmlspecialchars($_POST['userId']);
        $isVerified = htmlspecialchars($_POST['is_verified']);


        if (isset($disableUserId) && !empty($disableUserId) && isset($isVerified)) {
            $disableUser = $model->setIs_verified($isVerified);
            $idUser = "id = ".$disableUserId;
            $model->update($idUser, $disableUser);

            echo "données bien mise à jour";
        } else {
            throw new Exception("Une erreur est survenue, l'action n'a pas pu être effectuée.");
        }

        return $this->index($userId);
    }


    /**
     * function to delete an user and and anonymize their comments
     */
    public function deleteUser(): ?self
    {
        $logUser = htmlspecialchars($_SESSION['logUser']);
        $deleteUserId = htmlspecialchars($_POST['userId']);
        $sessionId = htmlspecialchars($_SESSION['id']);

        if ($logUser === 'admin' && isset($deleteUserId) && !empty($deleteUserId)) {
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

        } else {
            throw new Exception("Une erreur est survenue, la suppression n'a pas pu être effectuée.");
        }

        return $this->index($sessionId);
    }


}
