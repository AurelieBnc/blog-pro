<?php
namespace App\Entity;

use App\Entity\Model;

Class Post extends Model
{
    public function __construct()
    {
        $this->table = 'post';
    }
}