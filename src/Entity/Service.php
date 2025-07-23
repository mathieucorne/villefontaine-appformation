<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['service:read']],
    denormalizationContext: ['groups' => ['service:write']]
)]
class Service
{
    #[Groups(['service:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['service:read', 'service:write'])]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Groups(['service:read', 'service:write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[Groups(['service:read'])]
    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'service', orphanRemoval: true)]
    private Collection $utilisateurs;

    /**
     * @var Collection<int, Visibilite>
     */
    #[Groups(['service:read'])]
    #[ORM\OneToMany(targetEntity: Visibilite::class, mappedBy: 'service', orphanRemoval: true)]
    private Collection $visibilites;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->visibilites = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->setService($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getService() === $this) {
                $utilisateur->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Visibilite>
     */
    public function getSessionSessions(): Collection
    {
        return $this->visibilites;
    }

    public function addSessionSession(Visibilite $visibilite): static
    {
        if (!$this->visibilites->contains($visibilite)) {
            $this->visibilites->add($visibilite);
            $visibilite->setService($this);
        }

        return $this;
    }

    public function removeSessionSession(Visibilite $visibilite): static
    {
        if ($this->visibilites->removeElement($visibilite)) {
            // set the owning side to null (unless already changed)
            if ($visibilite->getService() === $this) {
                $visibilite->setService(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }
}
