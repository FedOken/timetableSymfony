<?php

namespace App\Repository;

use App\Entity\Faculty;
use App\Helper\ArrayHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Faculty|null find($id, $lockMode = null, $lockVersion = null)
 * @method Faculty|null findOneBy(array $criteria, array $orderBy = null)
 * @method Faculty[]    findAll()
 * @method Faculty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacultyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Faculty::class);
    }

    /**
     * @param $universityId
     * @param $facultyId
     * @return mixed
     */
    public function checkFacultyInUniversity($universityId, $facultyId)
    {
        return $this->createQueryBuilder('tb')
            ->andWhere('tb.university = :university')
            ->andWhere('tb.id = :id')
            ->setParameter('university', $universityId)
            ->setParameter('id', $facultyId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $universityId
     * @param bool $forChoice
     * @return mixed
     */
    public function getFacultiesByUniversity(array $universityId, bool $forChoice = false)
    {
        $models = $this->createQueryBuilder('tb')
            ->andWhere('tb.university IN (:university)')
            ->setParameter('university', $universityId)
            ->orderBy('tb.id')
            ->getQuery()
            ->getResult();

        if ($forChoice) {
            return ArrayHelper::map($models, 'name', 'id');
        }

        return $models;
    }
}
