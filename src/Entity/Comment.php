<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ApiResource]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 500)]
    private $content;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'boolean')]
    private $moderationStatus;

    #[ORM\ManyToOne(targetEntity: Ressource::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $ressource;

    #[ORM\ManyToOne(targetEntity: Citizen::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('ressource:read')]
    private $author;

    #[ORM\ManyToOne(targetEntity: Citizen::class, inversedBy: 'moderatedComments')]
    private $moderator;


    public function __toString()
    {
        return $this->content;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getModerationStatus(): ?bool
    {
        return $this->moderationStatus;
    }

    public function setModerationStatus(bool $moderationStatus): self
    {
        $this->moderationStatus = $moderationStatus;

        return $this;
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

    public function getAuthor(): ?Citizen
    {
        return $this->author;
    }

    public function setAuthor(?Citizen $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getModerator(): ?Citizen
    {
        return $this->moderator;
    }

    public function setModerator(?Citizen $moderator): self
    {
        $this->moderator = $moderator;

        return $this;
    }
}
