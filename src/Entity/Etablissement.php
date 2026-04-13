<?php
namespace App\Entity;

use App\Repository\EtablissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $image = null;

    // Relation N:N avec Filiere — côté propriétaire
    #[ORM\ManyToMany(targetEntity: Filiere::class, inversedBy: 'etablissements')]
    #[ORM\JoinTable(name: 'etablissement_filiere')]
    private Collection $filieres;

    // Relation 1:N vers Evenement
    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: Evenement::class, cascade: ['persist', 'remove'])]
    private Collection $evenements;

    public function __construct()
    {
        $this->filieres   = new ArrayCollection();
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $v): static { $this->nom = $v; return $this; }
    public function getAdresse(): ?string { return $this->adresse; }
    public function setAdresse(?string $v): static { $this->adresse = $v; return $this; }
    public function getVille(): ?string { return $this->ville; }
    public function setVille(?string $v): static { $this->ville = $v; return $this; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $v): static { $this->email = $v; return $this; }
    public function getTelephone(): ?string { return $this->telephone; }
    public function setTelephone(?string $v): static { $this->telephone = $v; return $this; }
    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $v): static { $this->image = $v; return $this; }
    public function getFilieres(): Collection { return $this->filieres; }
    public function addFiliere(Filiere $f): static
    {
        if (!$this->filieres->contains($f)) { $this->filieres->add($f); }
        return $this;
    }
    public function removeFiliere(Filiere $f): static { $this->filieres->removeElement($f); return $this; }
    public function getEvenements(): Collection { return $this->evenements; }
    public function addEvenement(Evenement $e): static
    {
        if (!$this->evenements->contains($e)) { $this->evenements->add($e); $e->setEtablissement($this); }
        return $this;
    }
    public function __toString(): string { return $this->nom ?? ''; }
}