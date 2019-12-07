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
    protected $facultyRepo;

    public function __construct(RegistryInterface $registry, FacultyRepository $facultyRepository)
    {
        parent::__construct($registry, Party::class);

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
            ->getQuery()
            ->getResult();
    }
}
