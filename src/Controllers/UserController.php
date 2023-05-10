<?php

namespace App\Controllers;

use App\Entity\Comment;
use App\Entity\User;

/**
 * Controlleur des users
 */
Class UserController extends AbstractController
{
    public function editAvatar() {

        $file = null;
        $idUser = $_SESSION['id'];
        $editUser = new User;
        $model = new User;

        $comment = new Comment;
        $userDataComment = ['id_user' => $idUser];
        $comments = $comment->findBy($userDataComment);

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== 4) {
            $tmpName = $_FILES['avatar']['tmp_name'];
            $name = $_FILES['avatar']['name'];
            $size = $_FILES['avatar']['size'];
            $error = $_FILES['avatar']['error'];

            // Vérification du type et de la taille du fichier uploader
            $tabExtension = explode('.', $name);
            $extension = strtolower(end($tabExtension));

            $extensions = ['jpg', 'png', 'jpeg', 'gif'];
            $maxSize = 400000;

            if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
                $uniqueName = uniqid('', true);
                $file = $uniqueName.".".$extension;
                move_uploaded_file($tmpName, './images/avatar_upload/'.$file);
            } else {
                //todo détaillé les erreurs
                echo "Mauvaise extension, taille trop grande ou une erreur est survenue";
            }
        }

        if ($file !== null) {
            $editUser = $model->setAvatar($file);
            $model->update($idUser,$editUser);
            echo "avatar mise à jour";
            $editdUserDatas = $model->find($_SESSION['id']);

            return $this->twig->display('home/userPage.twig', ['comments' => $comments,'user' => $editdUserDatas,'ROOT' => $this->root, 'session' => $_SESSION]);
        } else {
            echo "donnée vide";
            $userDatas = $model->find($_SESSION['id']);

            return $this->twig->display('home/userPage.twig', ['comments' => $comments,'user' => $userDatas,'ROOT' => $this->root, 'session' => $_SESSION]);
        }
    }

    public function editUserDatas() {

        $model = new User;
        $idUser = $_SESSION['id'];
        $editUser = new User;
        $datas = [];

        $comment = new Comment;
        $userDataComment = ['id_user' => $idUser];
        $comments = $comment->findBy($userDataComment);

        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $datas = ['email' => $_POST['email']];
        }

        if (isset($_POST['pseudonym']) && !empty($_POST['pseudonym'])) {
            $datas = ['pseudonym' => $_POST['pseudonym']];
        }

        if (isset($_POST['lastname']) && !empty($_POST['lastname'])) {
            $editUser = $model->setLastname($_POST['lastname']);
        }

        if (isset($_POST['firstname']) && !empty($_POST['firstname'])) {
            $editUser = $model->setFirstname($_POST['firstname']);
        }

        if (isset($_POST['pseudonym']) && !empty($_POST['pseudonym'])) {
            $users = $model->findBy($datas);
            foreach ($users as $user) {
                if ($user['pseudonym'] === $_POST['pseudonym']) {
                    echo 'Ce nom d\'utilisateur est déjà pris.';
                } else {
                    $editUser = $model->setPseudonym($_POST['pseudonym']);
                    echo " pseudo ok";
                }
            }
        }

        //todo : faire la confirmation de mail
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $users = $model->findBy($datas);
            foreach ($users as $user) {
                if ($user['email'] === $_POST['email']) {
                    echo 'Cet email est déjà associé à un compte.';
                } else {
                    $editUser = $model->setEmail($_POST['email']);
                    echo "email ok";
                }
            }
            echo "Cet email est déjà associé à un compte";
        }

        if (!empty($datas)) {
            $model->update($idUser, $editUser);
            echo "données bien mise à jour";
            $editdUserDatas = $model->find($_SESSION['id']);

            return $this->twig->display('home/userPage.twig', ['comments' => $comments,'user' => $editdUserDatas,'ROOT' => $this->root, 'session' => $_SESSION]);
        } else {
            echo "donnée vide";
            $userDatas = $model->find($_SESSION['id']);

            return $this->twig->display('home/userPage.twig', ['comments' => $comments,'user' => $userDatas,'ROOT' => $this->root, 'session' => $_SESSION]);
        }
    }
}