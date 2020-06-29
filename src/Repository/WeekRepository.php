<?php

namespace App\Repository;

use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\Week;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Week|null find($id, $lockMode = null, $lockVersion = null)
 * @method Week|null findOneBy(array $criteria, array $orderBy = null)
 * @method Week[]    findAll()
 * @method Week[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeekRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Week::class);
    }

    public function findByUniversities(array $universityIds): array
    {
        return $this->createQueryBuilder('tb')
            ->leftJoin('tb.university', 'un', 'WITH', 'un.id = tb.university')
            ->andWhere('un.enable = 1')
            ->andWhere("un.id IN (:ids)")
            ->setParameter('ids', $universityIds)
            ->addOrderBy('tb.name', 'ASC')
            ->orderBy('tb.sort_order', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
