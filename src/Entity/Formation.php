<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
#[ApiResource]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageURL = null;

    #[ORM\Column]
    private ?bool $estVisible = null;

    /**
     * @var Collection<int, Session>
     */
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'formation', orphanRemoval: true)]
    private Collection $sessions;

    /**
     * @var Collection<int, FormationCompetence>
     */
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
}
