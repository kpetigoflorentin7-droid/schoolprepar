<?php
namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\Table(name: 'utilisateur')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $telephone = null;

    // RDV pris (en tant qu'élève)
    #[ORM\OneToMany(mappedBy: 'eleve', targetEntity: RendezVous::class)]
    private Collection $rendezVousPris;

    // RDV reçus (en tant que conseiller)
    #[ORM\OneToMany(mappedBy: 'conseiller', targetEntity: RendezVous::class)]
    private Collection $rendezVousRecus;

    public function __construct()
    {
        $this->rendezVousPris  = new ArrayCollection();
        $this->rendezVousRecus = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $v): static { $this->nom = $v; return $this; }
    public function getPrenom(): ?string { return $this->prenom; }
    public function setPrenom(string $v): static { $this->prenom = $v; return $this; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $v): static { $this->email = $v; return $this; }
    public function getUserIdentifier(): string { return (string) $this->email; }
    public function getRoles(): array { return array_unique(array_merge($this->roles, ['ROLE_USER'])); }
    public function setRoles(array $r): static { $this->roles = $r; return $this; }
    public function getPassword(): string { return $this->password; }
    public function setPassword(string $v): static { $this->password = $v; return $this; }
    public function getTelephone(): ?string { return $this->telephone; }
    public function setTelephone(?string $v): static { $this->telephone = $v; return $this; }
    public function eraseCredentials(): void {}
    public function getRendezVousPris(): Collection { return $this->rendezVousPris; }
    public function getRendezVousRecus(): Collection { return $this->rendezVousRecus; }
    public function getNomComplet(): string { return $this->prenom.' '.$this->nom; }
    public function __toString(): string { return $this->getNomComplet(); }
}