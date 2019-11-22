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
     * @param $universityId
     * @param $partyId
     * @return mixed
     */
    public function checkPartyInUniversity($universityId, $partyId)
    {
        $facultyModels = $this->facultyRepo->createQueryBuilder('tb')
            ->andWhere('tb.university = :university')
            ->setParameter('university', $universityId)
            ->getQuery()
            ->getResult();

        $facultyIds = ArrayHelper::getColumn($facultyModels, 'id');

        return $this->createQueryBuilder('tb')
            ->andWhere('tb.faculty IN (:faculty)')
            ->andWhere('tb.id = :id')
            ->setParameter('faculty', $facultyIds)
            ->setParameter('id', $partyId)
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

        $facultyModels = [];
        /** @var University $university */
        foreach ($universityModel as $university) {
            $facultyModels = array_merge($facultyModels, $university->faculties);
        }

        $partyModels = [];
        /** @var Faculty $faculty */
        foreach ($facultyModels as $faculty) {
            $partyModels = array_merge($partyModels, $faculty->parties);
        }

        return $partyModels;
    }
}
