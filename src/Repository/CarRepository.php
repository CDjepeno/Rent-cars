<?php

namespace App\Repository;

use App\Data\SearchCarData;
use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    /**
     * Récupère les produits en lien avec une recherche
     *
     * @return Car[]
     */
    public function findSearch(SearchCarData $search) {
        $query = $this 
        ->createQueryBuilder('car')
        ->join('car.category', 'c')
        ->select('car','c');
        
        if(!empty($search->car)) {
           
            $query = $query
            ->andWhere('car.title LIKE :car')
            ->setParameter('car', "%{$search->car}%");
            
        }
        
        if(!empty($search->min)) {
            $query = $query
            ->andWhere('car.price >= :min')
            ->setParameter('min', $search->min);
            // dd($query);
            
        }
        
        if(!empty($search->max)) {
            $query = $query
            ->andWhere('car.price <= :max')
            ->setParameter('max', $search->max);
            // dd($query);
            
        }
        
        if(!empty($search->category)) {
            $query = $query
            ->andWhere('c.id IN (:category)')
            ->setParameter('category', $search->category);
        }

            return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Car[] Returns an array of Car objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Car
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
