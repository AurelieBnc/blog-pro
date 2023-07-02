<?php
namespace App\Entity;

use App\Entity\Model;

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


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of pseudonym
     */
    public function getPseudonym()
    {
        return $this->pseudonym;
    }

    /**
     * Set the value of pseudonym
     *
     * @return  self
     */
    public function setPseudonym($pseudonym)
    {
        $this->pseudonym = $pseudonym;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of is_verified
     */
    public function getIs_verified()
    {
        return $this->is_verified;
    }

    /**
     * Set the value of is_verified
     *
     * @return  self
     */
    public function setIs_verified($is_verified)
    {
        $this->is_verified = $is_verified;

        return $this;
    }

    /**
     * Get the value of avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of registration_date
     */
    public function getRegistration_date()
    {
        return $this->registration_date;
    }

    /**
     * Set the value of registration_date
     *
     * @return  self
     */
    public function setRegistration_date($registration_date)
    {
        $this->registration_date = $registration_date;

        return $this;
    }

    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}