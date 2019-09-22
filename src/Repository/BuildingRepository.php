<?php

namespace App\Repository;

use App\Entity\Building;
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

    /**
     * @param $university_id
     * @param $building_id
     * @return mixed
     */
    public function checkBuildingByUniversity($university_id, $building_id)
    {
        return $this->createQueryBuilder('table')
            ->andWhere('table.university = :university')
            ->andWhere('table.id = :id')
            ->setParameter('university', $university_id)
            ->setParameter('id', $building_id)
            ->orderBy('table.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $university_ids
     * @return array
     */
    public function getDataForChoice(array $university_ids)
    {
        $queryResult = $this->createQueryBuilder('tb')
            ->andWhere('tb.university IN (:university_ids)')
            ->setParameter('university_ids', $university_ids)
            ->orderBy('tb.name', 'ASC')
            ->getQuery()
            ->getResult();


        foreach ($queryResult as $building_model) {
            /** @var $building_model Building */
            $building_model->complexName = $building_model->getComplexName();
        }
        $data = ArrayHelper::map($queryResult, 'complexName', 'id');
        return $data;
    }
}
