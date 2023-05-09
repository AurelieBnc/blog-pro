<?php

namespace App\Controllers;

use App\Entity\User;

/**
 * Controlleur des users
 */
Class UserController extends AbstractController
{
    public function editAvatar(){

        $file = null;
        $idUser = $_SESSION['id'];

        $editUser = new User;
        $model = new User;
        $user = $model->find($_SESSION['id']);

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
            return $file;
        }

        if($file && $idUser === $user->getId())
        {
            $user = $model->setAvatar($file);
        }

        $model->update($idUser,$user);
        // $userId = $user->lastId();

    }
}