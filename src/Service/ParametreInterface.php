<?php

namespace App\Service;

use App\Repository\ParametreRepository;

/**
 * Interface pour la gestion de Paramètres
 */
class ParametreInterface
{
    private array $parametres;

    public function __construct(ParametreRepository $repository)
    {
        $this->parametres = [];

        foreach ($repository->findAll() as $param ) {
            $this->parametres[$param->getNom()] = $param->getValeur();
        }
    }

    /** 
     * @return string Retourne un tableau d'objets Parametre
    */
    public function getParametre(string $key, ?string $default = null) : string {
        return $this->parametres[$key] ?? $default;
    }

    /** 
     * @return Parametre[] Retourne un tableau d'objets Parametre
    */
    public function getAllParametres(): array {
        return $this->parametres;
    }
}
