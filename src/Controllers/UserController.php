<?php

namespace App\Controllers;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Post;
use App\Controllers\MailerController;

/**
 * User Controller
 */
Class UserController extends AbstractController
{
    public function editAvatar()
    {
        $file = null;
        $idUser = htmlspecialchars($_SESSION['id']);
        $editUser = new User;
        $model = new User;

        $comment = new Comment;
        $userDataComment = ['id_user' => $idUser];
        $comments = $comment->findBy($userDataComment);

        $post = new Post;
        $posts = $post->findAll();

        $fileError = $_FILES['avatar'] ? $_FILES['avatar']['error'] : null;

        if (isset($_FILES['avatar']) && $fileError !== 4) {
            $tmpName = htmlspecialchars($_FILES['avatar']['tmp_name']);
            $name = htmlspecialchars($_FILES['avatar']['name']);
            $size = $_FILES['avatar']['size'];
            $error = htmlspecialchars($_FILES['avatar']['error']);

            // Checking uploader file type and size
            $tabExtension = explode('.', $name);
            $extension = strtolower(end($tabExtension));

            $extensions = ['jpg', 'png', 'jpeg', 'gif'];
            $maxSize = 400000;

            if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
                $uniqueName = uniqid('', true);
                $file = $uniqueName.".".$extension;
                move_uploaded_file($tmpName, './images/avatar_upload/'.$file);
            } else {
                // todo : detailed errors
                echo "Mauvaise extension, taille trop grande ou une erreur est survenue";
            }
        }

        if ($file !== null) {
            $id = "id = ".$idUser;
            $editUser = $model->setAvatar($file);
            $model->update($id, $editUser);
            echo "avatar mise à jour";
            $editdUserDatas = $model->find($idUser);

            return $this->twig->display('admin/index.twig', [
                'posts' => $posts,
                'comments' => $comments,
                'user' => $editdUserDatas,
                'ROOT' => $this->root,
                'session' => $_SESSION
            ]);

        } else {
            echo "donnée vide";
            $userDatas = $model->find($idUser);

            return $this->twig->display('admin/index.twig', [
                'posts' => $posts,
                'comments' => $comments,
                'user' => $userDatas,
                'ROOT' => $this->root,
                'session' => $_SESSION
            ]);
        }
    }

    public function editUserDatas()
    {
        $model = new User;
        $idUser = htmlspecialchars($_SESSION['id']);
        $editUser = new User;
        $datas = [];

        $comment = new Comment;
        $userDataComment = ['id_user' => $idUser];
        $comments = $comment->findBy($userDataComment);

        $post = new Post;
        $posts = $post->findAll();

        $email = htmlspecialchars($_POST['email']);
        $pseudonym = htmlspecialchars($_POST['pseudonym']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $firstname = htmlspecialchars($_POST['firstname']);

        if (isset($email) && !empty($email)) {
            $datas = ['email' => $email];
            $editUser = $model->setEmail($email);
        }

        if (isset($pseudonym) && !empty($pseudonym)) {
            $datas = ['pseudonym' => $_POST['pseudonym']];
            $editUser = $model->setPseudonym($pseudonym);
        }

        if (isset($lastname) && !empty($lastname)) {
            $editUser = $model->setLastname($lastname);
        }

        if (isset($firstname) && !empty($firstname)) {
            $editUser = $model->setFirstname($firstname);
        }

        if (isset($pseudonym) && !empty($pseudonym)) {
            $users = $model->findBy($datas);
            foreach ($users as $user) {
                if ($user['pseudonym'] === $pseudonym && $pseudonym !== null) {
                    echo 'Ce nom d\'utilisateur est déjà pris.';
                } else {
                    $editUser = $model->setPseudonym($pseudonym);
                    echo " pseudo ok";
                }
            }
        }

        // todo : confirm email
        if (isset($email) && !empty($email)) {
            $users = $model->findBy($datas);
            foreach ($users as $user) {
                if ($user['email'] === $email && $email !== null ) {
                    echo 'Cet email est déjà associé à un compte.';
                } else {
                    $editUser = $model->setEmail($email);
                    echo "email ok";
                }
            }
        }

        $userId = htmlspecialchars($_SESSION['id']);
        if (!empty($editUser)) {
            $id = "id = ".$idUser;
            $model->update($id, $editUser);
            echo "données bien mise à jour";
            $editdUserDatas = $model->find($userId);

            return $this->twig->display('admin/index.twig', [
                'posts' => $posts,
                'comments' => $comments,
                'user' => $editdUserDatas,
                'ROOT' => $this->root,
                'session' => $_SESSION
            ]);

        } else {
            echo "donnée vide";
            $userDatas = $model->find($userId);

            return $this->twig->display('admin/index.twig', [
                'posts' => $posts,
                'comments' => $comments,
                'user' => $userDatas,
                'ROOT' => $this->root,
                'session' => $_SESSION
            ]);
        }
    }

    public function editPassword()
    {
        $actualPassword = htmlspecialchars($_POST['actualPassword']);
        $newPassword = htmlspecialchars($_POST['newPassword']);

        if (!empty($actualPassword) && !empty($newPassword)
            && isset($actualPassword) && isset($newPassword))
        {
            $idUser = htmlspecialchars($_SESSION['id']);
            $actualPassword = $actualPassword;
            $newPassword = $newPassword;

            $model = new User;
            $user = $model->find($idUser);


            if (password_verify( $actualPassword , $user['password']))
            {
                $id = "id = ".$idUser;
                $model = new User;
                $user = $model
                    ->setPassword(password_hash($newPassword, PASSWORD_BCRYPT))
                    ->setIs_verified('0');
                $model->update($id, $user);

                //todo : finish user verification for email change
                $mailType = '2';
                // $token = $user['token'];
                // /**
                //  * Send confirmation email
                //  */
                // $to   = $user->getEmail();
                // $from = $_ENV['USERMAILER'];
                // $name = 'Aurelie test blog-pro';
                // $subj = 'Confirmation de compte';
                // $msg = 'Bienvenue sur Blog-pro,

                // Pour activer votre nouvelle adresse mail, veuillez cliquer sur le lien ci-dessous
                // ou copier/coller dans votre navigateur Internet.

                // http://localhost/blog-pro/public/index.php?p=mailer/confirmMail/'.urlencode($idUser).'/'.urlencode($token).'

                // ---------------
                // Ceci est un mail automatique, Merci de ne pas y répondre.';
                // $smtmailer = new MailerController;
                // $error = $smtmailer->smtpmailer($to, $from, $name, $subj, $msg);
                // echo "mail envoyé";

                return $this->twig->display('partial/confirmRegister.twig', ['mailtype' => $mailType,'ROOT' => $this->root, 'session' => $_SESSION]);
            }

            $comment = new Comment;
            $userDataComment = ['id_user' => $idUser];
            $comments = $comment->findBy($userDataComment);

            $post = new Post;
            $posts = $post->findAll();

            return $this->twig->display('admin/index.twig', [
                'posts' => $posts,
                'comments' => $comments,
                'user' => $user,
                'ROOT' => $this->root,
                'session' => $_SESSION
            ]);

        }
    }

    public function deleteUser()
    {
        $userId = htmlspecialchars($_SESSION['id']);
        $modelUser = new User;
        $user = $modelUser->find($userId);
        $password = htmlspecialchars($_POST['password']);

        if (password_verify( $password , $user['password']))
        {
            //anonnymisation des commentaires
            $data = ['id_user'=> $userId];
            $modelComment = new Comment;
            $listComments = $modelComment->findBy($data);

            foreach ( $listComments as $comment ) {
                $id = "id_user = ".$userId;
                $comment = $modelComment->setId_user(2);
                $comment = $modelComment->update($id, $comment );
            }

            $modelUser->delete($userId);

            //destruction de la session existante + reinitialisation des variables de Session
            session_destroy();
            $_SESSION['logVisitor'] = true;
            $_SESSION['hasLoggedIn'] = false;

            return $this->twig->display('home/index.twig', ['ROOT' => $this->root, 'session' => $_SESSION]);

        }
        echo "mot de passe incorrect";
    }
}