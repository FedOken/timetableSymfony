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
    public function checkBuildingInUniversity($university_id, $building_id)
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
     * @param array $universityIds
     * @param bool $forChoice
     * @return array
     */
    public function getBuildingsByUniversity(array $universityIds, bool $forChoice = false)
    {
        $models = $this->createQueryBuilder('tb')
            ->andWhere('tb.university IN (:universityIds)')
            ->setParameter('universityIds', $universityIds)
            ->orderBy('tb.name', 'ASC')
            ->getQuery()
            ->getResult();

        if ($forChoice) {
            $data = [];
            /** @var $model Building */
            foreach ($models as $model) {
                $model->complexName = $model->getComplexName();
                $data[$model->complexName] = $model->id;
            }
            return $data;
        }

        return $models;
    }
}
