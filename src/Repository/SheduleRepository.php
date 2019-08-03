<?php

namespace App\Repository;

use App\Entity\Shedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Shedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shedule[]    findAll()
 * @method Shedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SheduleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Shedule::class);
    }

    // /**
    //  * @return Shedule[] Returns an array of Shedule objects
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
    public function findOneBySomeField($value): ?Shedule
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
