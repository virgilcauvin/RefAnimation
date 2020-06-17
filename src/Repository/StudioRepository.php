<?php

namespace App\Repository;

use App\Entity\Search;
use App\Entity\Studio;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Studio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Studio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Studio[]    findAll()
 * @method Studio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Studio::class);
    }

    /**
     * @return Studio[]
     */
    public function findSearch(Search $search)
    {
        $query = $this->createQueryBuilder('p');

        if ($search->getByText()) {
            $query = $query
            ->andWhere('p.nom LIKE :byText')
            ->setParameter('byText', '%' . $search->getByText() . '%' ); 
        }

        return $query->getQuery()->getResult();
    }

    /**
    * @return Studio[] Returns an array of Studio objects
    */
    
    public function findLatest()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.update_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
    * @return Studio[] Returns an array of Studio objects
    */
    
    public function findOldest()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.update_at', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
    * @return Studio[] Returns an array of Studio objects in AlphaBetical order
    */
    
    public function findByABOrder()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Studio[] Returns an array of Studio objects inverse AlphaBetical order
    */
    
    public function findByZYOrder()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.nom', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
   

    // /**
    //  * @return Studio[] Returns an array of Studio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Studio
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
