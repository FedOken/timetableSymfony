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
     * @param $building_id
     * @param $cabinet_id
     * @return mixed
     */
    public function checkCabinetInBuilding($building_id, $cabinet_id)
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

    /**
     * @param array $universityIds
     * @return mixed
     */
    public function getByUniversity(array $universityIds)
    {
        $universityModel = $this->getEntityManager()->getRepository(University::class)->findBy(['id' => $universityIds]);

        $buildingModels = [];
        /** @var University $university */
        foreach ($universityModel as $university) {
            $buildingModels = array_merge($buildingModels, $university->buildings);
        }

        $cabinetModels = [];
        /** @var Building $building */
        foreach ($buildingModels as $building) {
            $cabinetModels = array_merge($cabinetModels, $building->cabinets);
        }

        return $cabinetModels;
    }
}
