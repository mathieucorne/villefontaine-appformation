<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ApiResource]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?\DateTime $heure_debut = null;

    #[ORM\Column]
    private ?\DateTime $heure_fin = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $nb_participants_max = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $statut_session = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formation $formation = null;

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
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTime $heure_debut): static
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTime
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTime $heure_fin): static
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function getNbParticipantsMax(): ?int
    {
        return $this->nb_participants_max;
    }

    public function setNbParticipantsMax(int $nb_participants_max): static
    {
        $this->nb_participants_max = $nb_participants_max;

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
}
