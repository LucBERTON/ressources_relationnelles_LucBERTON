<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SharingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SharingRepository::class)]
#[ApiResource]
class Sharing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Ressource::class, inversedBy: 'sharings')]
    #[ORM\JoinColumn(nullable: false)]
    private $ressource;

    #[ORM\ManyToOne(targetEntity: Citizen::class, inversedBy: 'sharings')]
    private $citizenSharedWith;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRessource(): ?Ressource
    {
        return $this->ressource;
    }

    public function setRessource(?Ressource $ressource): self
    {
        $this->ressource = $ressource;

        return $this;
    }

    public function getCitizenSharedWith(): ?Citizen
    {
        return $this->citizenSharedWith;
    }

    public function setCitizenSharedWith(?Citizen $citizenSharedWith): self
    {
        $this->citizenSharedWith = $citizenSharedWith;

        return $this;
    }
}
