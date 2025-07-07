<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
#[ApiResource]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, UtilisateurCompetence>
     */
    #[ORM\OneToMany(targetEntity: UtilisateurCompetence::class, mappedBy: 'competence', orphanRemoval: true)]
    private Collection $utilisateurs;

    /**
     * @var Collection<int, FormationCompetence>
     */
    #[ORM\OneToMany(targetEntity: FormationCompetence::class, mappedBy: 'competence', orphanRemoval: true)]
    private Collection $formations;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, UtilisateurCompetence>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(UtilisateurCompetence $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->setCompetence($this);
        }

        return $this;
    }

    public function removeUtilisateur(UtilisateurCompetence $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getCompetence() === $this) {
                $utilisateur->setCompetence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormationCompetence>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(FormationCompetence $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->setCompetence($this);
        }

        return $this;
    }

    public function removeFormation(FormationCompetence $formation): static
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getCompetence() === $this) {
                $formation->setCompetence(null);
            }
        }

        return $this;
    }
}
