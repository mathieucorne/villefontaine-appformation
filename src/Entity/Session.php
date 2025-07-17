<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['session:read']],
    denormalizationContext: ['groups' => ['session:write']]
)]
class Session
{
    #[Groups(['session:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['session:read', 'session:write'])]
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[Groups(['session:read', 'session:write'])]
    #[ORM\Column(name: "heure_debut")]
    private ?\DateTime $heureDebut = null;

    #[Groups(['session:read', 'session:write'])]
    #[ORM\Column(name: "heure_fin")]
    private ?\DateTime $heureFin = null;

    #[Groups(['session:read', 'session:write'])]
    #[ORM\Column(name: "nb_participants_max", type: Types::SMALLINT)]
    private ?int $nbParticipantsMax = null;

    #[Groups(['session:read', 'session:write'])]
    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $statut_session = null;

    #[Groups(['session:read'])]
    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formation $formation = null;

    #[Groups(['session:read'])]
    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Salle $salle = null;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'session', orphanRemoval: true)]
    private Collection $participations;

    /**
     * @var Collection<int, SessionService>
     */
    #[ORM\OneToMany(targetEntity: SessionService::class, mappedBy: 'session', orphanRemoval: true)]
    private Collection $services;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getHeureDebut(): ?\DateTime
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTime $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTime
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTime $heureFin): static
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getNbParticipantsMax(): ?int
    {
        return $this->nbParticipantsMax;
    }

    public function setNbParticipantsMax(int $nbParticipantsMax): static
    {
        $this->nbParticipantsMax = $nbParticipantsMax;

        return $this;
    }

    public function getStatutSession(): ?int
    {
        return $this->statut_session;
    }

    public function setStatutSession(?int $statut_session): static
    {
        $this->statut_session = $statut_session;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): static
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): static
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setSession($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): static
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getSession() === $this) {
                $participation->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SessionService>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(SessionService $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setSession($this);
        }

        return $this;
    }

    public function removeService(SessionService $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getSession() === $this) {
                $service->setSession(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTitre()."(".$this->getHeureDebut()->format("H:i:s d-m-Y").", ".$this->getHeureFin()->format("H:i:s d-m-Y").")";
    }

    public function getTitreComplet() : string {
        if($this->titre) {
            return $this->titre." - ".$this->formation->getTitre();
        }
        return $this->formation->getTitre();
    }

    public function getNbParticipants(): int {
        return count($this->participations);
    }

    public function getNbParticipantsRestants(): int {
        return $this->getNbParticipantsMax() - $this->getNbParticipants();
    }

    public function estComplet(): int {
        return $this->getNbParticipantsRestants() == 0;
    }
}
