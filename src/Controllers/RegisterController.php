<?php

namespace App\Controllers;

use App\Entity\User;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Controlleur du système de connexion
 */
Class RegisterController extends AbstractController
{
    public function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $this->twig->display('register/index.twig', ['session' => $_SESSION]);
    }

    public function logIn()
    {
        // Validation du formulaire
        if (isset($_POST['email']) &&  isset($_POST['password']))
        {
            // Recherche de l'utilisateur
            $user = new User;
            $password = $_POST['password'];
            unset($_POST['password']);
            $users = $user->findBy($_POST);
            $user_exist = false;

            foreach ($users as $user) {
                if (
                    $user['email'] === $_POST['email'] &&
                    password_verify( $password , $user['password'])
                    )
                {
                    $user_exist = true;
                }
            }
            if ( $user_exist )
            {
                $_SESSION['logVisitor'] = false;
                $_SESSION['pseudo'] = $user['pseudonym'];
                $_SESSION['id'] = $user['id'];


                // Vérification du role de l'utilisateur et redirection
                if ($user['role'] === 'admin' && $user['is_verified'] === '1')
                {
                    //todo :  bug => n'affiche pas la bonne route dans l'url mais suis bien la bonne url (admin)??
                    echo 'je suis un admin';
                    $_SESSION['hasLoggedIn'] = true;
                    $_SESSION['logUser'] = 'admin';
                    return $this->twig->display('admin/index.twig', ['ROOT' => $this->root, 'session' => $_SESSION]);
                }
                if ($user['role'] === 'utilisateur' && $user['is_verified'] === '1')
                {
                    echo 'je suis un utilisateur vérifié';
                    $_SESSION['hasLoggedIn'] = true;
                    $_SESSION['logUser'] = 'user_verified';
                    return $this->twig->display('home/userPage.twig', ['ROOT' => $this->root, 'session' => $_SESSION]);
                }
                if ($user['role'] === 'utilisateur' && $user['is_verified'] === '0')
                {
                    //todo detruire la session sur la page suivante ou ici et renvoyé l'adresse mail sur la page suivante
                    echo 'je suis un utilisateur non vérifié';
                    $_SESSION['logUser'] = 'user_not_verified';
                    return $this->twig->display('register/userNotValid.twig', ['ROOT' => $this->root, 'session' => $_SESSION]);
                }
            } else {
                //todo modifier la page d'erreur
                return $this->twig->display('register/partial/userNotFind.twig', ['ROOT' => $this->root ]);
            }
        }

        return $this->twig->display('partial/pageFormError.twig', ['ROOT' => $this->root ]);
    }

    public function logOut()
    {
        session_destroy();
        $_SESSION['logVisitor'] = true;
        $_SESSION['hasLoggedIn'] = false;
        return $this->twig->display('register/logout.twig', ['ROOT' => $this->root ]);
    }

    public function register()
    {
        // todo :  vérifier que le pseudo existe déjà
        // todo : vérficiation de l'utilisateur par mail + mdp oublié
        // fix : ne reconnais pas la colonne max files
        // todo : sécurisation des données entrées par l'utilisateur avec  'firstname' => htmlspecialcchars($_POST['firstname']),
        $user = new User;
        $user_exist = null;
        $file = null;

        /**
         * Nous déterminons si l'utilisateur existe déjà avec cette adresse mail
         */
        if ( isset($_POST['email']) )
        {
            $datas = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
            ];

            $users = $user->findBy($datas);
            foreach ($users as $user) {
                if ( $user['email'] === $_POST['email'] )
                {
                    $user_exist = true;
                } else {
                    $user_exist = false;
                }
            }
        }

        if ( $user_exist ) {
            return $this->twig->display('register/userExist.twig', [
                'ROOT' => $this->root,
                'email' => $_POST['email'],
                ['session' => $_SESSION],
            ]
        );

        } elseif (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== 4 ) {

            /**
             * gestion de l'image d'avatar
             */
            $tmpName = $_FILES['avatar']['tmp_name'];
            $name = $_FILES['avatar']['name'];
            $size = $_FILES['avatar']['size'];
            $error = $_FILES['avatar']['error'];

            // Vérification du type et de la taille du fichier uploader
            $tabExtension = explode('.', $name);
            $extension = strtolower(end($tabExtension));

            $extensions = ['jpg', 'png', 'jpeg', 'gif'];
            $maxSize = 400000;

            if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
                $uniqueName = uniqid('', true);
                $file = $uniqueName.".".$extension;
                move_uploaded_file($tmpName, './images/avatar_upload/'.$file);
            }
            else{
                //todo détaillé les erreurs
                echo "Mauvaise extension, taille trop grande ou une erreur est survenue";
            }
            return $file;
        }

        if (!$user_exist)
        {
            /**
             * création de l'utilisateur
             */
            $model = new User;

            $user = $model
                ->setLastname($_POST['lastname'])
                ->setFirstname($_POST['firstname'])
                ->setPseudonym($_POST['pseudonym'])
                ->setEmail($_POST['email'])
                ->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT))
                ->setRole('utilisateur')
                ->setIs_verified('0');

            if($file)
            {
                $user = $model->setAvatar($file);
            }

            //$model->create($user);

            //sendMail($_POST['email']);

            //Create a new PHPMailer instance
            $mail = new PHPMailer();
            //Set who the message is to be sent from
            $mail->setFrom('aurelie.beninca@gmail.com', 'John Doe');
            //Set an alternative reply-to address
            $mail->addReplyTo('replyto@example.com', 'First Last');
            //Set who the message is to be sent to
            $mail->addAddress($_POST['email']);
            //Set the subject line
            $mail->Subject = 'PHPMailer mail() test';
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML(file_get_contents(ROOT.'/src/Templates/home/contents.html'));
            //Replace the plain text body with one created manually
            $mail->AltBody = 'This is a plain-text message body';
            //Attach an image file
            // $mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message sent!';
            }

            return $this->twig->display('register/confirmRegister.twig', ['ROOT' => $this->root, 'session' => $_SESSION]);
        }
    }
}
