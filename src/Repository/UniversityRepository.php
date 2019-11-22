<?php

namespace App\Repository;

use App\Entity\University;
use App\Helper\ArrayHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method University|null find($id, $lockMode = null, $lockVersion = null)
 * @method University|null findOneBy(array $criteria, array $orderBy = null)
 * @method University[]    findAll()
 * @method University[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UniversityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, University::class);
    }

    /**
     * @param array $universityIds
     * @return array
     */
    public function getByUniversity(array $universityIds)
    {
        $models = $this->createQueryBuilder('tb')
            ->andWhere('tb.id IN (:universityIds)')
            ->setParameter('universityIds', $universityIds)
            ->orderBy('tb.name', 'ASC')
            ->getQuery()
            ->getResult();

        return $models;
    }
}
