<?php

namespace App\Repository;

use App\Entity\Party;
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
     * @param array $universityId
     * @param bool $forChoice
     * @return mixed
     */
    public function getPartiesByUniversity(array $universityId, bool $forChoice = false)
    {
        $facultyModels = $this->facultyRepo->createQueryBuilder('tb')
            ->andWhere('tb.university IN (:university)')
            ->setParameter('university', $universityId)
            ->getQuery()
            ->getResult();

        $facultyIds = ArrayHelper::getColumn($facultyModels, 'id');

        $partyModels = $this->createQueryBuilder('tb')
            ->andWhere('tb.faculty IN (:faculty)')
            ->setParameter('faculty', $facultyIds)
            ->getQuery()
            ->getResult();

        if ($forChoice) {
            $data = [];
            /** @var $buildingModel Party */
            foreach ($partyModels as $model) {
                $data[$model->name] = $model;
            }
            return $data;
        }

        return $partyModels;
    }

    /**
     * @param array $faculty_ids
     * @return array
     */
    public function getDataForChoice(array $faculty_ids)
    {
        $queryResult = $this->createQueryBuilder('tb')
            ->andWhere('tb.faculty IN (:faculty_ids)')
            ->setParameter('faculty_ids', $faculty_ids)
            ->orderBy('tb.name', 'ASC')
            ->getQuery()
            ->getResult();

        $data = ArrayHelper::map($queryResult, 'name', 'id');
        return $data;
    }


}
