<?php

namespace App\Repository;

use App\Entity\Formation;
use App\Entity\Service;
use App\Entity\Utilisateur;
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
     * @return Formation[] Renvoie un tableau d'objets Formation dont au moins une Session est associée à un Service donné, qui inclut les Sessions auxquelles l'Utilisateur participe et les Sessions non pleines auxquelles l'Utilisateur ne participe pas
     */
    public function findFormationsDisponiblesPourService(Utilisateur $utilisateur, Service $service): array {
        return $this -> createQueryBuilder('f')
            ->distinct()
            ->innerJoin('f.sessions', 's')
            ->innerJoin('s.services', 'ss')
            ->leftJoin('s.participations', 'p')
            ->andWhere('f.estVisible = true')
            ->andWhere('ss.service = :service')
            ->andWhere('s.nbParticipantsMax IS NULL OR SIZE(s.participations) < s.nbParticipantsMax OR p.utilisateur = :utilisateur')
            ->setParameter('utilisateur', $utilisateur)
            ->setParameter('service', $service)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Formation[] Returns an array of Formation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Formation
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
