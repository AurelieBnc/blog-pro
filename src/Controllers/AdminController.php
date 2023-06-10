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

    public function disableUser()
    {
        $disableUserId = $_POST['userId'];
        $model = new User;
        $disableUser = new User;

        if (isset($_POST['userId']) && !empty($_POST['userId']) && isset($_POST['is_verified'])) {
            $disableUser = $model->setIs_verified($_POST['is_verified']);
            $id = "id = ".$disableUserId;
            $model->update($id, $disableUser);
            echo "données bien mise à jour";

        }

        $this->index($_SESSION['id']);
    }

    public function deleteUser()
    {
        if ($_SESSION['logUser'] === 'admin' && isset($_POST['userId']) && !empty($_POST['userId'])) {

            $deleteUserId = $_POST['userId'];
            $deleteUser = new User;

            //anonnymisation des commentaires
            $data = ['id_user'=> $deleteUserId];
            $modelComment = new Comment;
            $listComments = $modelComment->findBy($data);

            foreach ( $listComments as $comment ) {
                $id = "id_user = ".$deleteUserId;
                $comment = $modelComment->setId_user(2);
                $comment = $modelComment->update($id, $comment );
            }

            $deleteUser->delete($deleteUserId);
            echo "utilisateur supprimé";
        }

        $this->home($_SESSION['id']);
    }
}