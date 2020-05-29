<?php

namespace App\Repository;

use App\Entity\Film;
use App\Entity\Search;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    /**
     * @return Film[]
     */
    public function findSearch(Search $search)
    {
        $query = $this->createQueryBuilder('p');

        if ($search->getMinAnnee()) {
            $query = $query
            ->andWhere('p.date >= :minAnnee')
            ->setParameter('minAnnee', $search->getMinAnnee());
        }
        if ($search->getMaxAnnee()) {
            $query = $query
            ->andWhere('p.date <= :maxAnnee')
            ->setParameter('maxAnnee', $search->getMaxAnnee());
        }
        if ($search->getByMinDuree()) {
            $query = $query
            ->andWhere('p.duree >= :byMinDuree')
            ->setParameter('byMinDuree', $search->getByMinDuree());
        }
        if ($search->getByMaxDuree()) {
            $query = $query
            ->andWhere('p.duree <= :byMaxDuree')
            ->setParameter('byMaxDuree', $search->getByMaxDuree());
        }
        if ($search->getByText()) {
            $query = $query
            ->andWhere('p.nom LIKE :byText')
            ->setParameter('byText', '%' . $search->getByText() . '%' ); 
        }
        if ($search->getByTraduitFr()) {
            $query = $query
            ->andWhere('p.traduit_fr = :byTraduitFr')
            ->setParameter('byTraduitFr', $search->getbyTraduitFr());
        }
        if ($search->getBySoustitresFr()) {
            $query = $query
            ->andWhere('p.soustitres_fr = :bySoustitresFr')
            ->setParameter('bySoustitresFr', $search->getBySoustitresFr());
        }
        if ($search->getByPublicCible()) {
            $query = $query
            ->leftJoin('p.public_cibles', 'public_cible')
            ->andWhere('public_cible.id LIKE :byPublicCible')
            ->setParameter('byPublicCible', $search->getByPublicCible());
        }
        
        
        return $query->getQuery()->getResult();
    }

    /**
     * @return Film[]
     */
    public function findLatest(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.updated_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Film[] Returnsw< an array of Film objects
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
    public function findOneBySomeField($value): ?Film
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
