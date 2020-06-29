<?php

namespace App\Repository;

use App\Entity\Faculty;
use App\Entity\University;
use App\Helper\ArrayHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Faculty|null find($id, $lockMode = null, $lockVersion = null)
 * @method Faculty|null findOneBy(array $criteria, array $orderBy = null)
 * @method Faculty[]    findAll()
 * @method Faculty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacultyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Faculty::class);
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
