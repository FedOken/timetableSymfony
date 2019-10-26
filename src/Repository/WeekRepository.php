<?php

namespace App\Repository;

use App\Entity\Teacher;
use App\Entity\Week;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Week|null find($id, $lockMode = null, $lockVersion = null)
 * @method Week|null findOneBy(array $criteria, array $orderBy = null)
 * @method Week[]    findAll()
 * @method Week[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeekRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Week::class);
    }


    /**
     * @param $university_id
     * @param $week_id
     * @return mixed
     */
    public function checkWeekByUniversity($university_id, $week_id)
    {
        return $this->createQueryBuilder('table')
            ->andWhere('table.university = :university')
            ->andWhere('table.id = :id')
            ->setParameter('university', $university_id)
            ->setParameter('id', $week_id)
            ->orderBy('table.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $universityIds
     * @param bool $forChoice
     * @return array
     */
    public function getWeekByUniversity(array $universityIds, bool $forChoice = false)
    {
        $models = $this->createQueryBuilder('tb')
            ->andWhere('tb.university IN (:universityIds)')
            ->setParameter('universityIds', $universityIds)
            ->orderBy('tb.name', 'ASC')
            ->getQuery()
            ->getResult();

        if ($forChoice) {
            $data = [];
            /** @var $model Week */
            foreach ($models as $model) {
                $data[$model->name] = $model;
            }
            return $data;
        }

        return $models;
    }
}
