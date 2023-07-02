<?php
namespace App\Entity;

use App\Entity\Model;
use DateTime;

Class Post extends Model
{

    protected $id;

    protected $title;

    protected $lead;

    protected $content;

    protected $created_at;

    protected $update_date;

    protected $id_user;


    public function __construct()
    {
        $this->table = 'post';
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


    public function getTitle(): string
    {
        return $this->title;
    }


    public function setTitle(string $title): self
    {
        $this->title = $title;

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


    public function getUpdate_date(): DateTime
    {
        return $this->update_date;
    }


    public function setUpdate_date(DateTime $update_date): self
    {
        $this->update_date = $update_date;

        return $this;
    }


    public function getId_user(): int
    {
        return $this->id_user;
    }


    public function setId_user(int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }


    public function getLead(): int
    {
        return $this->lead;
    }


    public function setLead(int $lead): self
    {
        $this->lead = $lead;

        return $this;
    }


}
