<?php
namespace App\Entity;

use App\Entity\Model;
use DateTime;

Class User extends Model
{

    protected $id;

    protected $lastname;

    protected $firstname;

    protected $pseudonym;

    protected $email;

    protected $password;

    protected $token;

    protected $role;

    protected $is_verified;

    protected $avatar;

    protected $registration_date;


    public function __construct()
    {
        $this->table = 'user';
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


    public function getPseudonym(): string
    {
        return $this->pseudonym;
    }


    public function setPseudonym(string $pseudonym): self
    {
        $this->pseudonym = $pseudonym;

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


    public function getPassword(): string
    {
        return $this->password;
    }


    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getRole(): string
    {
        return $this->role;
    }


    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }


    public function getIs_verified(): int
    {
        return $this->is_verified;
    }


    public function setIs_verified(int $is_verified): self
    {
        $this->is_verified = $is_verified;

        return $this;
    }


    public function getAvatar(): string
    {
        return $this->avatar;
    }


    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }


    public function getRegistration_date(): DateTime
    {
        return $this->registration_date;
    }


    public function setRegistration_date(DateTime $registration_date): self
    {
        $this->registration_date = $registration_date;

        return $this;
    }


    public function getToken(): int
    {
        return $this->token;
    }


    public function setToken(int $token): self
    {
        $this->token = $token;

        return $this;
    }


}
