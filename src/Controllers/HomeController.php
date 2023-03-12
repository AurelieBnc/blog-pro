<?php
namespace App\Controllers;

/**
 * controlleur de la page d'accueil
 */
Class HomeController extends Controller
{
    public function index()
    {
        $this->twig->display('home/index.twig');
    }

}