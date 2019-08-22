<?php

namespace App\Repository;

use App\Entity\Cabinet;
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
     * @param $building_id
     * @param $cabinet_id
     * @return mixed
     */
    public function checkCabinetByBuilding($building_id, $cabinet_id)
    {
        return $this->createQueryBuilder('table')
            ->andWhere('table.building = :building')
            ->andWhere('table.id = :id')
            ->setParameter('building', $building_id)
            ->setParameter('id', $cabinet_id)
            ->orderBy('table.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
