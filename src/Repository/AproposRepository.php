<?php

namespace App\Repository;

use App\Entity\Apropos;
/* La classe EntityRepository est une classe de base qui peut être étendue pour créer un référentiel de données pour une entité spécifique. */
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
/* La classe ManagerRegistry est une classe de base dans Doctrine qui fournit un mécanisme pour accéder aux gestionnaires d'entités dans une application */
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Apropos>
 *
 * @method Apropos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apropos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apropos[]    findAll()
 * @method Apropos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AproposRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apropos::class);
    }

    public function save(Apropos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Apropos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Apropos[] Returns an array of Apropos objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Apropos
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
