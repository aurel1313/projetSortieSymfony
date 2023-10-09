<?php

namespace App\Entity;

use App\Repository\InscriptionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionsRepository::class)]
class Inscriptions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'inscriptions')]
    private ?participants $participant_idparticipant = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?sorties $sortie_idsortie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSortieIdsortie(): ?sorties
    {
        return $this->sortie_idsortie;
    }

    public function setSortieIdsortie(?sorties $sortie_idsortie): static
    {
        $this->sortie_idsortie = $sortie_idsortie;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }
}
