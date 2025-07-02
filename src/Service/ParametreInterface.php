<?php

namespace App\Service;

use App\Repository\ParametreRepository;

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

    public function getParametre(string $key, $default = null) {
        return $this->parametres[$key] ?? $default;
    }

    public function getAllParametres() {
        return $this->parametres;
    }
}
