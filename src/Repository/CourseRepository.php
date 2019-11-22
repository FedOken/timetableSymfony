<?php

namespace App\Repository;

use App\Entity\Course;
use App\Helper\ArrayHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Course::class);
    }

    /**
     * @param $universityId
     * @param $courseId
     * @return mixed
     */
    public function checkCourseInUniversity($universityId, $courseId)
    {
        return $this->createQueryBuilder('tb')
            ->andWhere('tb.university = :university')
            ->andWhere('tb.id = :id')
            ->setParameter('university', $universityId)
            ->setParameter('id', $courseId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $universityIds
     * @param bool $forChoice
     * @return mixed
     */
    public function getByUniversity(array $universityIds, bool $forChoice = false)
    {
        $models = $this->createQueryBuilder('tb')
            ->andWhere('tb.university IN (:university)')
            ->setParameter('university', $universityIds)
            ->orderBy('tb.id')
            ->getQuery()
            ->getResult();

        if ($forChoice) {
            return ArrayHelper::map($models, 'name', 'id');
        }

        return $models;
    }
}
