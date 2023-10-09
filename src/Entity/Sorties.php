<?php

namespace App\Entity;

use App\Repository\SortiesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SortiesRepository::class)]
class Sorties
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateHeureDebut = null;

    #[ORM\Column(nullable: true)]
    private ?int $duree = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateLimiteInscription = null;

    #[ORM\Column]
    private ?int $nombreInscriptionMax = null;

    #[ORM\Column(length: 500)]
    private ?string $infoSorties = null;

    #[ORM\Column(length: 255)]
    private ?string $motifAnnulation = null;

    #[ORM\Column(length: 255)]
    private ?string $photoSorties = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    private ?participants $participant_idparticipant = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?sites $site_idsite = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?lieux $lieu_idlieu = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?etats $etat_idetat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): static
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): static
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNombreInscriptionMax(): ?int
    {
        return $this->nombreInscriptionMax;
    }

    public function setNombreInscriptionMax(int $nombreInscriptionMax): static
    {
        $this->nombreInscriptionMax = $nombreInscriptionMax;

        return $this;
    }

    public function getInfoSorties(): ?string
    {
        return $this->infoSorties;
    }

    public function setInfoSorties(string $infoSorties): static
    {
        $this->infoSorties = $infoSorties;

        return $this;
    }

    public function getMotifAnnulation(): ?string
    {
        return $this->motifAnnulation;
    }

    public function setMotifAnnulation(string $motifAnnulation): static
    {
        $this->motifAnnulation = $motifAnnulation;

        return $this;
    }

    public function getPhotoSorties(): ?string
    {
        return $this->photoSorties;
    }

    public function setPhotoSorties(string $photoSorties): static
    {
        $this->photoSorties = $photoSorties;

        return $this;
    }

    public function getParticipantIdparticipant(): ?participants
    {
        return $this->participant_idparticipant;
    }

    public function setParticipantIdparticipant(?participants $participant_idparticipant): static
    {
        $this->participant_idparticipant = $participant_idparticipant;

        return $this;
    }

    public function getSiteIdsite(): ?sites
    {
        return $this->site_idsite;
    }

    public function setSiteIdsite(?sites $site_idsite): static
    {
        $this->site_idsite = $site_idsite;

        return $this;
    }

    public function getLieuIdlieu(): ?lieux
    {
        return $this->lieu_idlieu;
    }

    public function setLieuIdlieu(?lieux $lieu_idlieu): static
    {
        $this->lieu_idlieu = $lieu_idlieu;

        return $this;
    }

    public function getEtatIdetat(): ?etats
    {
        return $this->etat_idetat;
    }

    public function setEtatIdetat(?etats $etat_idetat): static
    {
        $this->etat_idetat = $etat_idetat;

        return $this;
    }
}
