<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Formation>
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    /**
     * @return Formation[] Renvoie un tableau d'objets Formation visibles
     */
    public function findFormationsVisibles(): array {
        return $this -> createQueryBuilder('f')
            ->andWhere('f.estVisible = true')
            ->getQuery()
            ->getResult();
    }
}
