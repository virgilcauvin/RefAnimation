<?php

namespace App\Repository;

use App\Entity\Search;
use App\Entity\Festival;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Festival|null find($id, $lockMode = null, $lockVersion = null)
 * @method Festival|null findOneBy(array $criteria, array $orderBy = null)
 * @method Festival[]    findAll()
 * @method Festival[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FestivalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Festival::class);
    }

    /**
     * @return Festival[]
     */
    public function findSearch(Search $search)
    {
        $query = $this->createQueryBuilder('p');

        if ($search->getByText()) {
            $query = $query
            ->andWhere('p.nom LIKE :byText')
            ->orWhere('p.ville LIKE :byText')
            ->setParameter('byText', '%' . $search->getByText() . '%' ); 
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @return Festival[]
     */
    public function findLatest(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.updated_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Festival[]
     */
    public function findOldest(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.updated_at', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
    * @return Festival[] Returns an array of Festival objects in AlphaBetical order
    */
    
    public function findByABOrder()
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Festival[] Returns an array of Festival objects in  inverse AlphaBetical order
    */
    
    public function findByZYOrder()
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.nom', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Festival[] Returns an array of Festival objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Festival
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
