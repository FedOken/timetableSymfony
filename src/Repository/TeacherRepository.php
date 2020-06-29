<?php

namespace App\Repository;

use App\Entity\Building;
use App\Entity\Teacher;
use App\Entity\University;
use App\Helper\ArrayHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    /**
     * @param string $name
     * @return Teacher|null
     */
    public function findByName(string $name)
    {
        return $this->createQueryBuilder('tb')
            ->andWhere('tb.name LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->leftJoin('tb.university', 'un')
            ->andWhere('un.enable = 1')
            ->addOrderBy('tb.name', 'ASC')
            ->getQuery()
            ->getResult();
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
