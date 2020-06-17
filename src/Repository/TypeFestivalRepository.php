<?php

namespace App\Repository;

use App\Entity\TypeFestival;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeFestival|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeFestival|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeFestival[]    findAll()
 * @method TypeFestival[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeFestivalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeFestival::class);
    }

    /**
    * @return TypeFestival[] Returns an array of TypeFestival objects
    */
    public function findAllDesc()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'Desc')
            ->getQuery()
            ->getResult()
        ;
    }
    

    // /**
    //  * @return TypeFestival[] Returns an array of TypeFestival objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeFestival
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
