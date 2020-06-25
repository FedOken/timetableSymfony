<?php

namespace App\Repository;

use App\Entity\Building;
use App\Entity\University;
use App\Helper\ArrayHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Building|null find($id, $lockMode = null, $lockVersion = null)
 * @method Building|null findOneBy(array $criteria, array $orderBy = null)
 * @method Building[]    findAll()
 * @method Building[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Building::class);
    }

    public function findByUniversities(array $universityIds): array
    {
        return $this->createQueryBuilder('tb')
            ->leftJoin(University::class, 'un', 'WITH', 'un.id = tb.university')
            ->andWhere('un.enable = 1')
            ->andWhere("un.id IN (:ids)")
            ->setParameter('ids', $universityIds)
            ->addOrderBy('tb.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
