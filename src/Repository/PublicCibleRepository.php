<?php

namespace App\Repository;

use App\Entity\PublicCible;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PublicCible|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicCible|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicCible[]    findAll()
 * @method PublicCible[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicCibleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicCible::class);
    }

    // /**
    //  * @return PublicCible[] Returns an array of PublicCible objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PublicCible
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
