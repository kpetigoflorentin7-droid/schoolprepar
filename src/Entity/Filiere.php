<?php
namespace App\Entity;

use App\Repository\FiliereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FiliereRepository::class)]
class Filiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $domaine = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conditionsAdmission = null;

    #[ORM\Column(nullable: true)]
    private ?int $duree = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $image = null;

    // Relation N:N avec Etablissement — côté inverse
    #[ORM\ManyToMany(targetEntity: Etablissement::class, mappedBy: 'filieres')]
    private Collection $etablissements;

    // Relation 1:N vers Debouche
    #[ORM\OneToMany(mappedBy: 'filiere', targetEntity: Debouche::class, cascade: ['persist', 'remove'])]
    private Collection $debouches;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
        $this->debouches      = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $v): static { $this->nom = $v; return $this; }
    public function getDomaine(): ?string { return $this->domaine; }
    public function setDomaine(?string $v): static { $this->domaine = $v; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $v): static { $this->description = $v; return $this; }
    public function getConditionsAdmission(): ?string { return $this->conditionsAdmission; }
    public function setConditionsAdmission(?string $v): static { $this->conditionsAdmission = $v; return $this; }
    public function getDuree(): ?int { return $this->duree; }
    public function setDuree(?int $v): static { $this->duree = $v; return $this; }
    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $v): static { $this->image = $v; return $this; }
    public function getEtablissements(): Collection { return $this->etablissements; }
    public function getDebouches(): Collection { return $this->debouches; }
    public function addDebouche(Debouche $d): static
    {
        if (!$this->debouches->contains($d)) { $this->debouches->add($d); $d->setFiliere($this); }
        return $this;
    }
    public function __toString(): string { return $this->nom ?? ''; }
}