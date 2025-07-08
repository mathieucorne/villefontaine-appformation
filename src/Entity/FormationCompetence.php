<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FormationCompetenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FormationCompetenceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['formationcompetence:read']],
    denormalizationContext: ['groups' => ['formationcompetence:write']]
)]
class FormationCompetence
{
    #[Groups(['formationcompetence:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['formationcompetence:read', 'formationcompetence:write'])]
    #[ORM\ManyToOne(inversedBy: 'competences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formation $formation = null;

    #[Groups(['formationcompetence:read', 'formationcompetence:write'])]
    #[ORM\ManyToOne(inversedBy: 'formations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Competence $competence = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): static
    {
        $this->competence = $competence;

        return $this;
    }
}
