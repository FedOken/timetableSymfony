<?php

namespace App\Repository;

use App\Entity\TeacherPosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TeacherPosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeacherPosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeacherPosition[]    findAll()
 * @method TeacherPosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherPositionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TeacherPosition::class);
    }

    // /**
    //  * @return TeacherPosition[] Returns an array of TeacherPosition objects
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
    public function findOneBySomeField($value): ?TeacherPosition
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
