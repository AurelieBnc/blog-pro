<?php 

namespace App\Controllers;

/**
 * Controlleur du système de connexion
 */
Class RegisterController extends AbstractController
{
    public function index()
    {
        $this->twig->display('register/index.twig');
    }

}
