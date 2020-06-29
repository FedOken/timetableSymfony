<?php

namespace App\Repository;

use App\Entity\Party;
use App\Entity\University;
use App\Entity\UniversityTime;
use App\Helper\ArrayHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UniversityTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method UniversityTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method UniversityTime[]    findAll()
 * @method UniversityTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UniversityTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UniversityTime::class);
    }

    public function findByUniversities(array $universityIds): array
    {
        return $this->createQueryBuilder('tb')
            ->leftJoin('tb.university', 'un', 'WITH', 'un.id = tb.university')
            ->andWhere('un.enable = 1')
            ->andWhere("un.id IN (:ids)")
            ->setParameter('ids', $universityIds)
            ->addOrderBy('tb.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
