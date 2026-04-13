<?php
namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    const EN_ATTENTE = 'en_attente';
    const CONFIRME   = 'confirme';
    const ANNULE     = 'annule';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeure = null;

    #[ORM\Column(length: 20)]
    private string $statut = self::EN_ATTENTE;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $motif = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $mode = null; // presentiel, visio, telephone

    // N:1 Utilisateur (élève)
    #[ORM\ManyToOne(inversedBy: 'rendezVousPris')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $eleve = null;

    // N:1 Utilisateur (conseiller)
    #[ORM\ManyToOne(inversedBy: 'rendezVousRecus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $conseiller = null;

    public function getId(): ?int { return $this->id; }
    public function getDateHeure(): ?\DateTimeInterface { return $this->dateHeure; }
    public function setDateHeure(\DateTimeInterface $v): static { $this->dateHeure = $v; return $this; }
    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $v): static { $this->statut = $v; return $this; }
    public function getMotif(): ?string { return $this->motif; }
    public function setMotif(?string $v): static { $this->motif = $v; return $this; }
    public function getMode(): ?string { return $this->mode; }
    public function setMode(?string $v): static { $this->mode = $v; return $this; }
    public function getEleve(): ?Utilisateur { return $this->eleve; }
    public function setEleve(?Utilisateur $v): static { $this->eleve = $v; return $this; }
    public function getConseiller(): ?Utilisateur { return $this->conseiller; }
    public function setConseiller(?Utilisateur $v): static { $this->conseiller = $v; return $this; }

    public function getStatutLabel(): string
    {
        return match($this->statut) {
            self::CONFIRME   => 'Confirmé',
            self::ANNULE     => 'Annulé',
            default          => 'En attente',
        };
    }
    public function getStatutBadge(): string
    {
        return match($this->statut) {
            self::CONFIRME => 'success',
            self::ANNULE   => 'danger',
            default        => 'warning',
        };
    }
}