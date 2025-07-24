<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    normalizationContext: ['groups' => ['utilisateur:read']],
    denormalizationContext: ['groups' => ['utilisateur:write']]
)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(['utilisateur:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[Groups(['utilisateur:read'])]
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    #[ORM\Column]
    private ?string $password = null;

    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    /**
     * @var Collection<int, Participation>
     */
    #[Groups(['utilisateur:read'])]
    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'utilisateur', orphanRemoval: true)]
    private Collection $participations;

    /**
     * @var Collection<int, UtilisateurCompetence>
     */
    #[Groups(['utilisateur:read'])]
    #[ORM\OneToMany(targetEntity: UtilisateurCompetence::class, mappedBy: 'utilisateur', orphanRemoval: true)]
    private Collection $competences;

    /**
     * @var Collection<int, Formation>
     */
    #[ORM\OneToMany(targetEntity: Formation::class, mappedBy: 'formateur', orphanRemoval: true)]
    private Collection $formations;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
        $this->competences = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
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

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

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
            $participation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): static
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getUtilisateur() === $this) {
                $participation->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UtilisateurCompetence>
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(UtilisateurCompetence $competence): static
    {
        if (!$this->competences->contains($competence)) {
            $this->competences->add($competence);
            $competence->setUtilisateur($this);
        }

        return $this;
    }

    public function removeCompetence(UtilisateurCompetence $competence): static
    {
        if ($this->competences->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getUtilisateur() === $this) {
                $competence->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->setFormateur($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): static
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getFormateur() === $this) {
                $formation->setFormateur(null);
            }
        }

        return $this;
    }

    public function getNomComplet(): string {
        return $this->getPrenom()." ".$this->getNom();
    }

    public function __toString()
    {
        return $this->getNomComplet();
    }
}
