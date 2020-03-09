<?php

namespace App\Repository;

use App\Entity\EditionFestival;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EditionFestival|null find($id, $lockMode = null, $lockVersion = null)
 * @method EditionFestival|null findOneBy(array $criteria, array $orderBy = null)
 * @method EditionFestival[]    findAll()
 * @method EditionFestival[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EditionFestivalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EditionFestival::class);
    }

    // /**
    //  * @return EditionFestival[] Returns an array of EditionFestival objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EditionFestival
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
