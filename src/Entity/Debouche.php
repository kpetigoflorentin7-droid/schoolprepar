<?php
namespace App\Entity;

use App\Repository\DeboucheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeboucheRepository::class)]
class Debouche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $metier = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $secteur = null;

    #[ORM\Column(nullable: true)]
    private ?int $salaireMoyen = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    // N:1 Filiere
    #[ORM\ManyToOne(inversedBy: 'debouches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Filiere $filiere = null;

    public function getId(): ?int { return $this->id; }
    public function getMetier(): ?string { return $this->metier; }
    public function setMetier(string $v): static { $this->metier = $v; return $this; }
    public function getSecteur(): ?string { return $this->secteur; }
    public function setSecteur(?string $v): static { $this->secteur = $v; return $this; }
    public function getSalaireMoyen(): ?int { return $this->salaireMoyen; }
    public function setSalaireMoyen(?int $v): static { $this->salaireMoyen = $v; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $v): static { $this->description = $v; return $this; }
    public function getFiliere(): ?Filiere { return $this->filiere; }
    public function setFiliere(?Filiere $v): static { $this->filiere = $v; return $this; }
    public function __toString(): string { return $this->metier ?? ''; }
}