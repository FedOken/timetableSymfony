<?php

namespace App\Repository;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Party;
use App\Entity\University;
use App\Helper\ArrayHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cabinet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cabinet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cabinet[]    findAll()
 * @method Cabinet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CabinetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cabinet::class);
    }

    /**
     * @param string $name
     * @return Cabinet|null
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
