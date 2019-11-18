<?php

namespace App\Repository;

use App\Entity\TeacherPosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TeacherPosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeacherPosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeacherPosition[]    findAll()
 * @method TeacherPosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherPositionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TeacherPosition::class);
    }
}
