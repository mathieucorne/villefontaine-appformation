<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SalleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SalleRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['salle:read']],
    denormalizationContext: ['groups' => ['salle:write']]
)]
class Salle
{
    #[Groups(['salle:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['salle:read', 'salle:write'])]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Groups(['salle:read', 'salle:write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $batiment = null;

    #[Groups(['salle:read', 'salle:write'])]
    #[ORM\Column(name: "nb_places_max", type: Types::SMALLINT)]
    private ?int $nbPlacesMax = null;

    /**
     * @var Collection<int, Session>
     */
    #[Groups(['salle:read'])]
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'salle')]
    private Collection $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
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

    public function getBatiment(): ?string
    {
        return $this->batiment;
    }

    public function setBatiment(?string $batiment): static
    {
        $this->batiment = $batiment;

        return $this;
    }

    public function getNbPlacesMax(): ?int
    {
        return $this->nbPlacesMax;
    }

    public function setNbPlacesMax(int $nbPlacesMax): static
    {
        $this->nbPlacesMax = $nbPlacesMax;

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
            $session->setSalle($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getSalle() === $this) {
                $session->setSalle(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }
}
