<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ParametreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParametreRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['parametre:read']],
    denormalizationContext: ['groups' => ['parametre:write']]
)]
class Parametre
{
    #[Groups(['parametre:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['parametre:read', 'parametre:write'])]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Groups(['parametre:read', 'parametre:write'])]
    #[ORM\Column(length: 255)]
    private ?string $valeur = null;

    #[Groups(['parametre:read', 'parametre:write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaires = null;

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

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(?string $commentaires): static
    {
        $this->commentaires = $commentaires;

        return $this;
    }
}
