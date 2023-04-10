<?php 

namespace App\Controllers;

use App\Entity\User;

/**
 * Controlleur du système de connexion
 */
Class RegisterController extends AbstractController
{
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
            $users = $user->findBy($_POST);
            $user_exist = false;

            foreach ($users as $user) {
                if (
                    $user['email'] === $_POST['email'] &&
                    $user['password'] === $_POST['password']
                    )
                {
                    $user_exist = true;
                }
            }
            if ( $user_exist )
            {
                $_SESSION['logVisitor'] = false;
                $_SESSION['pseudo'] = $user['pseudonym'];


                // Vérification du role de l'utilisateur et redirection
                if ($user['role'] === 'admin' && $user['is_verified'] === '1')
                {
                    //todo :  bug => n'affiche pas la bonne route dans l'url mais suis bien la bonne url (admin)??
                    echo 'je suis un admin';
                    $_SESSION['hasLoggedIn'] = true;
                    $_SESSION['logUser'] = 'admin';var_dump('SESSION', $_SESSION);
                    return $this->twig->display('admin/index.twig', ['ROOT' => 'http://localhost/blog-pro/public/', 'session' => $_SESSION]);
                }
                if ($user['role'] === 'utilisateur' && $user['is_verified'] === '1')
                {
                    echo 'je suis un utilisateur vérifié';
                    $_SESSION['hasLoggedIn'] = true;
                    $_SESSION['logUser'] = 'user_verified';var_dump('SESSION ', $_SESSION);
                    return $this->twig->display('home/userPage.twig', ['ROOT' => 'http://localhost/blog-pro/public/', 'session' => $_SESSION]);
                }
                if ($user['role'] === 'utilisateur' && $user['is_verified'] === '0')
                {
                    //todo detruire la session sur la page suivante ou ici et renvoyé l'adresse mail sur la page suivante
                    echo 'je suis un utilisateur non vérifié';
                    $_SESSION['logUser'] = 'user_not_verified'; var_dump('SESSION start', $_SESSION);
                    return $this->twig->display('register/userNotValid.twig', ['ROOT' => 'http://localhost/blog-pro/public/', 'session' => $_SESSION]);
                }
            } else {
                //todo modifier la page d'erreur
                return $this->twig->display('partial/userNotFind.twig', ['ROOT' => 'http://localhost/blog-pro/public/']);
            }
        }

        return $this->twig->display('partial/pageFormError.twig', ['ROOT' => 'http://localhost/blog-pro/public/']);
    }

    public function logOut()
    {
        session_destroy();var_dump('SESSION destroy', $_SESSION);
        $_SESSION['logVisitor'] = true;
        $_SESSION['hasLoggedIn'] = false;
        return $this->twig->display('register/logout.twig', ['ROOT' => 'http://localhost/blog-pro/public/']);
    }
}
