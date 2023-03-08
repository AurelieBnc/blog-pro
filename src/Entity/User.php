<?php
namespace App\Entity;

use App\Entity\Model;

Class User extends Model
{

    public function __construct()
    {
        echo "je suis un utilisateur";
        $this->table = 'user';
    }
}