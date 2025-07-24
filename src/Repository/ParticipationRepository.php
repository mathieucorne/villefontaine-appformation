<?php

namespace App\Repository;

use App\Entity\Participation;
use App\Entity\Session;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Participation>
 */
class ParticipationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participation::class);
    }

    /**
     * @return Participation[] Renvoie un tableau d'objets Participations associé à un Utilisateur
     */
    public function findParticipationsUtilisateur(Utilisateur $utilisateur): array {
        return $this->createQueryBuilder('p')
            ->andWhere('p.utilisateur = :utilisateur')
            ->setParameter('utilisateur', $utilisateur)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Participation Renvoie un objet Participation associé à un Utilisateur et une Session
     */
    public function findParticipation(Utilisateur $utilisateur, Session $session) {
        return $this->findOneBy([
            'utilisateur' => $utilisateur,
            'session' => $session
        ]);
    }

    /**
     * @return bool Inscrit un Utilisateur à une Session en créant une Participation
     */
    public function inscrireUtilisateur(
        Utilisateur $utilisateur, 
        Session $session,
        string $objectifs
    ): bool {
        $participation = $this->findParticipation($utilisateur, $session);

        if ($participation || $session->getNbParticipantsRestants() < 1) {
            return false;
        }

        $newParticipation = new Participation();
        $newParticipation->setUtilisateur($utilisateur);
        $newParticipation->setSession($session);
        $newParticipation->setDateInscription(new \DateTime());
        $newParticipation->setObjectifs($objectifs);
        $newParticipation->setEstPresent(false);

        
        $this->getEntityManager()->persist($newParticipation);
        $this->getEntityManager()->flush();

        return true;
    }

    /**
     * @return bool Désinscrit un Utilisateur à une Session en supprimant une Participation
     */
    public function desinscrireUtilisateur(
        Utilisateur $utilisateur, 
        Session $session
    ): bool {
        $participation = $this->findParticipation($utilisateur, $session);

        if (!$participation) {
            return false;
        }

        $this->getEntityManager()->remove($participation);
        $this->getEntityManager()->flush();
        return true;
    }

    //    /**
    //     * @return Participation[] Returns an array of Participation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Participation
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
