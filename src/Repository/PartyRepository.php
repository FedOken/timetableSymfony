<?php

namespace App\Repository;

use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\University;
use App\Helper\ArrayHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Party|null find($id, $lockMode = null, $lockVersion = null)
 * @method Party|null findOneBy(array $criteria, array $orderBy = null)
 * @method Party[]    findAll()
 * @method Party[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyRepository extends ServiceEntityRepository
{
    protected $universityRepo;
    protected $facultyRepo;

    public function __construct(RegistryInterface $registry, UniversityRepository $universityRepository, FacultyRepository $facultyRepository)
    {
        parent::__construct($registry, Party::class);

        $this->universityRepo = $universityRepository;
        $this->facultyRepo = $facultyRepository;
    }

    /**
     * @param string $name
     * @return Party|null
     */
    public function findByName(string $name)
    {
        return $this->createQueryBuilder('tb')
            ->andWhere('tb.name LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->leftJoin('tb.faculty', 'fac')
            ->andWhere('fac.enable = 1')
            ->leftJoin(University::class, 'un', 'WITH', 'un.id = fac.university')
            ->andWhere('un.enable = 1')
            ->addOrderBy('tb.course', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByUniversities(array $universityIds): array
    {
        return $this->createQueryBuilder('tb')
            ->leftJoin('tb.faculty', 'fac')
            ->andWhere('fac.enable = 1')
            ->leftJoin(University::class, 'un', 'WITH', 'un.id = fac.university')
            ->andWhere('un.enable = 1')
            ->andWhere("un.id IN (:ids)")
            ->setParameter('ids', $universityIds)
            ->addOrderBy('tb.course', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
