<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CitizenRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CitizenRepository::class)]
#[ApiResource]
class Citizen
{

    CONST ROLE_USER='ROLE_USER';
    CONST ROLE_ADMIN='ROLE_ADMIN';
    CONST ROLE_SUPERADMIN='ROLE_SUPERADMIN';
    CONST ROLE_MODERATOR='ROLE_MODERATOR';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('citizen:read')]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups('citizen:read')]
    private $email;

    #[ORM\Column(type: 'json')]
    #[Groups('citizen:read')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups('citizen:read')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('citizen:read')]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('citizen:read')]
    private $lastName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('citizen:read')]
    private $streetName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('citizen:read')]
    private $streetNumber;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('citizen:read')]
    private $postalCode;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('citizen:read')]
    private $city;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('citizen:read')]
    private $country;


    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comment::class)]
    #[Groups('citizen:read')]
    private $comments;



    #[ORM\OneToMany(mappedBy: 'submitter', targetEntity: Ressource::class)]
    #[Groups('citizen:read')]
    private $submittedRessources;


    //active or inactive account
    #[ORM\Column(type: 'boolean')]
    #[Groups('citizen:read')]
    private $status;

    #[ORM\OneToMany(mappedBy: 'moderator', targetEntity: Ressource::class)]
    #[Groups('citizen:read')]
    private $moderatedRessources;

    #[ORM\OneToMany(mappedBy: 'moderator', targetEntity: Comment::class)]
    private $moderatedComments;

    #[ORM\OneToMany(mappedBy: 'citizen', targetEntity: Favorite::class)]
    #[Groups('citizen:read')]
    private $favorites;

    #[ORM\OneToMany(mappedBy: 'citizenSharedWith', targetEntity: Sharing::class)]
    private $sharings;


    public function __construct()
    {
        $this->comments = new ArrayCollection();

        $this->submittedRessources = new ArrayCollection();

        $this->moderatedRessources = new ArrayCollection();
        $this->moderatedComments = new ArrayCollection();

        $this->favorites = new ArrayCollection();
        $this->sharings = new ArrayCollection();

    }

    public function __toString()
    {
        return $this->firstName;
        //." ".$this->lastName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(?string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

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
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Ressource>
     */
    public function getSubmittedRessources(): Collection
    {
        return $this->submittedRessources;
    }

    public function addSubmittedRessource(Ressource $submittedRessource): self
    {
        if (!$this->submittedRessources->contains($submittedRessource)) {
            $this->submittedRessources[] = $submittedRessource;
            $submittedRessource->setSubmitter($this);
        }

        return $this;
    }

    public function removeSubmittedRessource(Ressource $submittedRessource): self
    {
        if ($this->submittedRessources->removeElement($submittedRessource)) {
            // set the owning side to null (unless already changed)
            if ($submittedRessource->getSubmitter() === $this) {
                $submittedRessource->setSubmitter(null);
            }
        }

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

    /**
     * @return Collection<int, Ressource>
     */
    public function getModeratedRessources(): Collection
    {
        return $this->moderatedRessources;
    }

    public function addModeratedRessource(Ressource $moderatedRessource): self
    {
        if (!$this->moderatedRessources->contains($moderatedRessource)) {
            $this->moderatedRessources[] = $moderatedRessource;
            $moderatedRessource->setModerator($this);
        }

        return $this;
    }

    public function removeModeratedRessource(Ressource $moderatedRessource): self
    {
        if ($this->moderatedRessources->removeElement($moderatedRessource)) {
            // set the owning side to null (unless already changed)
            if ($moderatedRessource->getModerator() === $this) {
                $moderatedRessource->setModerator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getModeratedComments(): Collection
    {
        return $this->moderatedComments;
    }

    public function addModeratedComment(Comment $moderatedComment)
    {
        if (!$this->moderatedComments->contains($moderatedComment)) {
            $this->moderatedComments[] = $moderatedComment;
            $moderatedComment->setModerator($this);
        }
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
            $favorite->setCitizen($this);
        }
        return $this;
    }


    public function removeModeratedComment(Comment $moderatedComment)
    {
        if ($this->moderatedComments->removeElement($moderatedComment)) {
            // set the owning side to null (unless already changed)
            if ($moderatedComment->getModerator() === $this) {
                $moderatedComment->setModerator(null);
            }
        }
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getCitizen() === $this) {
                $favorite->setCitizen(null);

            }
        }

        return $this;
    }



    public function becomeModerator()
    {
        $roles = $this->getRoles();
        if (array_search($this::ROLE_MODERATOR, $roles) === false) {
            array_push($roles, $this::ROLE_MODERATOR);
            dump($roles);

            $this->setRoles($roles);
        }

        return $this;
    }

    public function becomeAdmin()
    {
        $roles = $this->getRoles();
        if (array_search($this::ROLE_ADMIN, $roles) === false) {
            array_push($roles, $this::ROLE_ADMIN);
            $this->setRoles($roles);
        }

        return $this;
    }


    public function becomeSuperAdmin()
    {
        $roles = $this->getRoles();

        if (array_search($this::ROLE_SUPERADMIN, $roles) === false) {
            array_push($roles, $this::ROLE_SUPERADMIN);
            if (array_search($this::ROLE_ADMIN, $roles) === false) {
                array_push($roles, $this::ROLE_ADMIN);
            }
            $this->setRoles($roles);
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
            $sharing->setCitizenSharedWith($this);
        }

        return $this;
    }

    public function removeSharing(Sharing $sharing): self
    {
        if ($this->sharings->removeElement($sharing)) {
            // set the owning side to null (unless already changed)
            if ($sharing->getCitizenSharedWith() === $this) {
                $sharing->setCitizenSharedWith(null);
            }
        }

        return $this;
    }

}
