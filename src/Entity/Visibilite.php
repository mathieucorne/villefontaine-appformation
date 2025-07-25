<?php

namespace App\Entity;
 
use App\Repository\VisibiliteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisibiliteRepository::class)]
class Visibilite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'visibilites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $session = null;

    #[ORM\ManyToOne(inversedBy: 'visibilites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
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

    public function __toString()
    {
        return $this->getSession()->__toString().", ".$this->getService()->__toString();
    }
}
