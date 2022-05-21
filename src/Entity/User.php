<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Ce champ ne doit pas être vide."),
      Assert\NotNull(),
      Assert\Length(
          min: 2,
          max: 25,
          minMessage: "Votre nom d'utilisateur doit contenir au moins 2 caractères.",
          maxMessage: "Votre nom d'utilisateur doit avoir moins de 25 caractères.")]
    private string $login;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(
        min: 6,
        max: 50,
        minMessage: "Votre mot de passe doit contenir au moins 6 caractères.",
        maxMessage: "Votre mot de passe doit avoir moins de 50 caractères."),
      Assert\NotBlank(message: "Ce champ ne doit pas être vide."),
      Assert\NotNull()]
    private string $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Ce champ ne doit pas être vide."),
      Assert\NotNull()]
    #[Assert\Email(message: "Veuillez saisir une adresse email valide. Ex : John.Doe@google.com")]
    private string $mail;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private \DateTimeImmutable $registratedAt;

    #[ORM\Column(type: 'json')]
    #[Assert\NotNull()]
    private array $roles = [];

    #[ORM\Column(type: 'boolean')]
    private bool $isAcceptedTerms = false;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Trick::class, orphanRemoval: true)]
    private ArrayCollection $tricks;

    public function __construct() {
        $this->registratedAt = new \DateTimeImmutable();
        $this->tricks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getRegistratedAt(): ?\DateTimeImmutable
    {
        return $this->registratedAt;
    }

    public function setRegistratedAt(\DateTimeImmutable $registratedAt): self
    {
        $this->registratedAt = $registratedAt;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = "ROLE_USER";
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    public function eraseCredentials()
    {

    }

    public function getIsAcceptedTerms(): ?bool
    {
        return $this->isAcceptedTerms;
    }

    public function setIsAcceptedTerms(bool $isAcceptedTerms): self
    {
        $this->isAcceptedTerms = $isAcceptedTerms;

        return $this;
    }

    /**
     * @return Collection<int, Trick>
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Trick $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setUser($this);
        }

        return $this;
    }

    public function removeTrick(Trick $trick): self
    {
        if ($this->tricks->removeElement($trick)) {
            // set the owning side to null (unless already changed)
            if ($trick->getUser() === $this) {
                $trick->setUser(null);
            }
        }

        return $this;
    }
}
