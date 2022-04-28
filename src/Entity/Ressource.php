<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RessourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RessourceRepository::class)]
#[ApiResource]
class Ressource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $author;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'string', length: 5000, nullable: true)]

    private $url;

    #[ORM\Column(type: 'integer')]

    private $views;

    #[ORM\Column(type: 'integer')]

    private $searches;

    #[ORM\Column(type: 'integer')]

    private $shares;

    #[ORM\Column(type: 'datetime')]

    private $submitDate;

    //active or inactive Ressource
    #[ORM\Column(type: 'boolean')]

    private $status;

    #[ORM\Column(type: 'boolean')]

    private $moderationStatus;

    #[ORM\Column(type: 'datetime', nullable: true)]

    private $moderationDate;

    #[ORM\OneToMany(mappedBy: 'ressource', targetEntity: Comment::class, orphanRemoval: true)]

    private $comments;

    #[ORM\ManyToOne(targetEntity: Citizen::class, inversedBy: 'submittedRessources')]
    #[ORM\JoinColumn(nullable: false)]

    private $submitter;

    #[ORM\ManyToOne(targetEntity: RessourceCategory::class, inversedBy: 'ressources')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\ManyToOne(targetEntity: RessourceType::class, inversedBy: 'ressources')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\ManyToMany(targetEntity: RelationType::class, inversedBy: 'ressources')]

    private $relationType;

    #[ORM\Column(type: 'string', length: 255)]

    private $title;

    #[ORM\ManyToOne(targetEntity: Citizen::class, inversedBy: 'moderatedRessources')]

    private $moderator;

    #[ORM\OneToMany(mappedBy: 'ressource', targetEntity: Favorite::class)]

    private $favorites;

    #[ORM\OneToMany(mappedBy: 'ressource', targetEntity: Sharing::class, orphanRemoval: true)]
    private $sharings;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->relationType = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->sharings = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getViews(): ?string
    {
        return $this->views;
    }

    public function setViews(string $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getSearches(): ?int
    {
        return $this->searches;
    }

    public function setSearches(int $searches): self
    {
        $this->searches = $searches;

        return $this;
    }

    public function getShares(): ?int
    {
        return $this->shares;
    }

    public function setShares(int $shares): self
    {
        $this->shares = $shares;

        return $this;
    }

    public function getSubmitDate(): ?\DateTimeInterface
    {
        return $this->submitDate;
    }

    public function setSubmitDate(\DateTimeInterface $submitDate): self
    {
        $this->submitDate = $submitDate;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

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

    public function getModerationDate(): ?\DateTimeInterface
    {
        return $this->moderationDate;
    }

    public function setModerationDate(\DateTimeInterface $moderationDate): self
    {
        $this->moderationDate = $moderationDate;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setRessource($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRessource() === $this) {
                $comment->setRessource(null);
            }
        }

        return $this;
    }


    public function getSubmitter(): ?Citizen
    {
        return $this->submitter;
    }

    public function setSubmitter(?Citizen $submitter): self
    {
        $this->submitter = $submitter;

        return $this;
    }

    public function getCategory(): ?RessourceCategory
    {
        return $this->category;
    }

    public function setCategory(?RessourceCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getType(): ?RessourceType
    {
        return $this->type;
    }

    public function setType(?RessourceType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, RelationType>
     */
    public function getRelationType(): Collection
    {
        return $this->relationType;
    }

    public function addRelationType(RelationType $relationType): self
    {
        if (!$this->relationType->contains($relationType)) {
            $this->relationType[] = $relationType;
        }

        return $this;
    }

    public function removeRelationType(RelationType $relationType): self
    {
        $this->relationType->removeElement($relationType);

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setRessource($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getRessource() === $this) {
                $favorite->setRessource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sharing>
     */
    public function getSharings(): Collection
    {
        return $this->sharings;
    }

    public function addSharing(Sharing $sharing): self
    {
        if (!$this->sharings->contains($sharing)) {
            $this->sharings[] = $sharing;
            $sharing->setRessource($this);
        }

        return $this;
    }

    public function removeSharing(Sharing $sharing): self
    {
        if ($this->sharings->removeElement($sharing)) {
            // set the owning side to null (unless already changed)
            if ($sharing->getRessource() === $this) {
                $sharing->setRessource(null);
            }
        }

        return $this;
    }
}
