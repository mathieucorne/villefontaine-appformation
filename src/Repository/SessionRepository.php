<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
     * @return Session[] Retourne un tableau d'objets Session
     */
    public function findMesSessions(Utilisateur $utilisateur): array {
        return $this -> createQueryBuilder('s')
            ->distinct()
            ->innerJoin('s.participations', 'p')
            ->andWhere('p.utilisateur = :utilisateur')
            ->setParameter('utilisateur', $utilisateur)
            ->getQuery()
            ->getResult();
    }
}
