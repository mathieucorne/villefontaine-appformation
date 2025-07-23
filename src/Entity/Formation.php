<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['formation:read']],
    denormalizationContext: ['groups' => ['formation:write']]
)]
class Formation
{
    #[Groups(['formation:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['formation:read', 'formation:write'])]
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[Groups(['formation:read', 'formation:write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Groups(['formation:read', 'formation:write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageURL = null;

    #[Groups(['formation:read', 'formation:write'])]
    #[ORM\Column]
    private ?bool $estVisible = null;

    
    #[ORM\ManyToOne(inversedBy: 'formations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $formateur = null;

    /**
     * @var Collection<int, Session>
     */
    #[Groups(['formation:read'])]
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'formation', orphanRemoval: true)]
    private Collection $sessions;

    /**
     * @var Collection<int, FormationCompetence>
     */
    #[Groups(['formation:read'])]
    #[ORM\OneToMany(targetEntity: FormationCompetence::class, mappedBy: 'formation', orphanRemoval: true)]
    private Collection $competences;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->competences = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImageURL(): ?string
    {
        return $this->imageURL;
    }

    public function setImageURL(?string $imageURL): static
    {
        $this->imageURL = $imageURL;

        return $this;
    }

    public function isEstVisible(): ?bool
    {
        return $this->estVisible;
    }

    public function setEstVisible(bool $estVisible): static
    {
        $this->estVisible = $estVisible;

        return $this;
    }

    
    public function getFormateur(): ?Utilisateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Utilisateur $formateur): static
    {
        $this->formateur = $formateur;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setFormation($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getFormation() === $this) {
                $session->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormationCompetence>
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(FormationCompetence $competence): static
    {
        if (!$this->competences->contains($competence)) {
            $this->competences->add($competence);
            $competence->setFormation($this);
        }

        return $this;
    }

    public function removeCompetence(FormationCompetence $competence): static
    {
        if ($this->competences->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getFormation() === $this) {
                $competence->setFormation(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTitre();
    }

    public function getNbSessions(): int {
        return count($this->sessions);
    }

    public function getNbSessionsNonPleines(): int {
        $sessionsNonPleines = array();
        foreach($this->sessions as $session) {
            if(!$session->estComplet()) {
                array_push($sessionsNonPleines, $session);
            }
        }

        return count($sessionsNonPleines);
    }

    public function getSessionsVisibles(Utilisateur $utilisateur): array {
        $sessionsVisibles = array();
        foreach($this->sessions as $session) {
            if($session->estVisible($utilisateur)) {
                array_push($sessionsVisibles, $session);
            }
        }
        return $sessionsVisibles;
    }

    public function getNbParticipantsMaxTotaux() {
        $NbParticipantsTotaux = 0;
        foreach($this->sessions as $session) {
            $NbParticipantsTotaux = $NbParticipantsTotaux + $session->getNbParticipantsMax();
        }
        return $NbParticipantsTotaux;
    }

    public function getNbParticipantsTotaux() {
        $NbParticipantsTotaux = 0;
        foreach($this->sessions as $session) {
            $NbParticipantsTotaux = $NbParticipantsTotaux + $session->getNbParticipants();
        }
        return $NbParticipantsTotaux;
    }
}
