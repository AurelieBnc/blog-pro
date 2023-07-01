<?php

namespace App\Controllers;

use App\Entity\User;
use App\Controllers\MailerController;

/**
 * Connection system controller
 */
Class RegisterController extends AbstractController
{

    public function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $this->twig->display('register/index.twig', ['ROOT' => $this->root,'session' => $_SESSION]);
    }

    public function logIn()
    {
        $post = htmlspecialchars($_POST);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        // Validation du formulaire
        if (isset($email) &&  isset($password))
        {
            // User search
            $user = new User;
            unset($_POST['password']);
            $users = $user->findBy($post);
            $user_exist = false;

            foreach ($users as $user) {
                if (
                    $user['email'] === $email &&
                    password_verify( $password , $user['password'])
                    )
                {
                    $user_exist = true;
                }
            }
            if ($user_exist)
            {
                $_SESSION['logVisitor'] = false;
                $_SESSION['pseudo'] = $user['pseudonym'];
                $_SESSION['id'] = $user['id'];


                // User role verification and redirection
                if ($user['role'] === 'admin' && $user['is_verified'] === '1')
                {
                    echo 'je suis un admin';
                    $_SESSION['hasLoggedIn'] = true;
                    $_SESSION['logUser'] = 'admin';
                    return $this->twig->display('home/index.twig', ['ROOT' => $this->root, 'session' => $_SESSION]);
                }
                if ($user['role'] === 'utilisateur' && $user['is_verified'] === '1')
                {
                    echo 'je suis un utilisateur vérifié';
                    $_SESSION['hasLoggedIn'] = true;
                    $_SESSION['logUser'] = 'user_verified';
                    return $this->twig->display('home/index.twig', ['ROOT' => $this->root, 'session' => $_SESSION]);
                }
                if ($user['role'] === 'utilisateur' && $user['is_verified'] === '0')
                {
                    //todo : destroy the session on the next page or here and return the email address on the next page
                    echo 'je suis un utilisateur non vérifié';
                    $_SESSION['logUser'] = 'user_not_verified';
                    return $this->twig->display('partial/userNotValid.twig', ['ROOT' => $this->root, 'session' => $_SESSION]);
                }
            } else {
                return $this->twig->display('partial/userNotFind.twig', ['ROOT' => $this->root ]);
            }
        }

        return $this->twig->display('partial/pageFormError.twig', ['ROOT' => $this->root ]);
    }

    public function logOut()
    {
        session_destroy();
        unset($_SESSION['logUser']);
        unset($_SESSION['pseudo']);
        unset($_SESSION['id']);
        $_SESSION['logVisitor'] = true;
        $_SESSION['hasLoggedIn'] = false;

        return $this->twig->display('partial/logout.twig', ['ROOT' => $this->root ]);
    }

    public function registerUser()
    {
        // todo : user verification for change of email + forgotten password
        $user = new User;
        $user_exist = null;
        $pseudo_exist = null;
        $file = null;
        $datas = [];

        $email = htmlspecialchars($_POST['email']);
        $pseudonym = htmlspecialchars($_POST['pseudonym']);

        /**
         * We determine if the user already exists with this email address
         */
        if (isset($email) && !empty($email))
        {
            $datas = ['email' => $email];

            $users = $user->findBy($datas);

            foreach ($users as $user) {
                if ($user['email'] === $email)
                {
                    $user_exist = true;
                } else {
                    $user_exist = false;
                }
            }
            $datas = null;

        } else {
            echo "veuillez entre votre email";
        }

        /**
         * We determine if the nickname already exists
         */
        if (isset($pseudonym) && !empty($pseudonym))
        {
            $user = new User;
            $datas = ['pseudonym' => $pseudonym];
            $users = $user->findBy($datas);

            foreach ($users as $user) {
                if ($user['pseudonym'] === $pseudonym) {
                    $pseudo_exist = true;
                } else {
                    $pseudo_exist = false;
                }
            }
        } else {
            echo "veuillez entrer votre pseudonym";
        }

        if ($user_exist) {
            return $this->twig->display('partial/userExist.twig',
                [
                    'ROOT' => $this->root,
                    'email' => $email,
                    ['session' => $_SESSION],
                ]
            );
        }
        if ($pseudo_exist) {
            return $this->twig->display('partial/userExist.twig',
                [
                    'ROOT' => $this->root,
                    'pseudonym' => $pseudonym,
                    ['session' => $_SESSION],
                ]
            );
        }

        if (!$user_exist && !$pseudo_exist) {
            /**
             * avatar image management
             */
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== 4) {
                $tmpName = $_FILES['avatar']['tmp_name'];
                $name = $_FILES['avatar']['name'];
                $size = $_FILES['avatar']['size'];
                $error = $_FILES['avatar']['error'];

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

            /**
             * création de l'utilisateur
             */
            $token = rand(10000000, 90000000);
            $model = new User;

            $lastname = htmlspecialchars($_POST['lastname']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $password = htmlspecialchars($_POST['password']);

            $user = $model
                ->setLastname($lastname)
                ->setFirstname($firstname)
                ->setPseudonym($pseudonym)
                ->setEmail($email)
                ->setPassword(password_hash($password, PASSWORD_BCRYPT))
                ->setToken($token)
                ->setRole('utilisateur')
                ->setIs_verified('0');

            if ($file !== null) {
                $user = $model->setAvatar($file);
            }

                $model->create($user);
                $userId = $user->lastId();
                $mailType = '1';
                /**
                 * Send confirmation email
                 */
                $to   = $_POST['email'];
                $from = $_ENV['USERMAILER'];
                $name = 'Aurelie test blog-pro';
                $subj = 'Confirmation de compte';
                $msg = 'Bienvenue sur Blog-pro,

                Pour activer votre compte, veuillez cliquer sur le lien ci-dessous
                ou copier/coller dans votre navigateur Internet.

                http://localhost/blog-pro/public/index.php?p=mailer/confirmMail/'.urlencode($userId).'/'.urlencode($token).'

                ---------------
                Ceci est un mail automatique, Merci de ne pas y répondre.';
                $smtmailer = new MailerController;
                $error = $smtmailer->smtpmailer($to, $from, $name, $subj, $msg);
                echo "mail envoyé";

                return $this->twig->display('partial/confirmRegister.twig', ['mailType' => $mailType,'ROOT' => $this->root, 'session' => $_SESSION]);
            }
            return $this->twig->display('partial/pageFormError.twig', ['ROOT' => $this->root,'session' => $_SESSION]);
        }
    }
}
