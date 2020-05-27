<?php

namespace App\Repository;

use App\Entity\Building;
use App\Entity\Teacher;
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
            ->addOrderBy('tb.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
