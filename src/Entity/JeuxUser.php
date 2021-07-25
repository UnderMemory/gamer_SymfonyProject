<?php

namespace App\Entity;

use App\Repository\JeuxUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JeuxUserRepository::class)
 */
class JeuxUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Jeux::class, inversedBy="jeuxNote")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_jeux;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userNote")
     */
    private $id_user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdJeux(): ?Jeux
    {
        return $this->id_jeux;
    }

    public function setIdJeux(?Jeux $id_jeux): self
    {
        $this->id_jeux = $id_jeux;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note): void
    {
        $this->note = $note;
    }

}
