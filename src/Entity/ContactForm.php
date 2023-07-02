<?php
namespace App\Entity;

use App\Entity\Model;
use DateTime;

Class ContactForm extends Model
{

    protected $id;

    protected $lastname;

    protected $firstname;

    protected $email;

    protected $content;

    protected $created_at;


    public function __construct()
    {
        $this->table = 'contactform';
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }


    public function getLastname(): string
    {
        return $this->lastname;
    }


    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }


    public function getFirstname(): string
    {
        return $this->firstname;
    }


    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }


    public function getEmail(): string
    {
        return $this->email;
    }


    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getContent(): string
    {
        return $this->content;
    }


    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }


    public function getCreated_at(): DateTime
    {
        return $this->created_at;
    }


    public function setCreated_at(DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }


}
