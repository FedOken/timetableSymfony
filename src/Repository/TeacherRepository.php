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
     * @param $university_id
     * @param $teacher_id
     * @return mixed
     */
    public function checkTeacherInUniversity($university_id, $teacher_id)
    {
        return $this->createQueryBuilder('table')
            ->andWhere('table.university = :university')
            ->andWhere('table.id = :id')
            ->setParameter('university', $university_id)
            ->setParameter('id', $teacher_id)
            ->orderBy('table.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $universityIds
     * @param bool $forChoice
     * @return array
     */
    public function getTeachersByUniversity(array $universityIds, bool $forChoice = false)
    {
        $models = $this->createQueryBuilder('tb')
            ->andWhere('tb.university IN (:universityIds)')
            ->setParameter('universityIds', $universityIds)
            ->orderBy('tb.name', 'ASC')
            ->getQuery()
            ->getResult();

        if ($forChoice) {
            $data = [];
            /** @var $model Teacher */
            foreach ($models as $model) {
                $data[$model->name] = $model;
            }
            return $data;
        }

        return $models;
    }


}
