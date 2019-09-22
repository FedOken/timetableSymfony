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
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Party::class);
    }

    /**
     * @param $university_id
     * @param $party_id
     * @return mixed
     */
    public function checkPartyByUniversity($university_id, $party_id)
    {
        return $this->createQueryBuilder('table')
            ->andWhere('table.university = :university')
            ->andWhere('table.id = :id')
            ->setParameter('university', $university_id)
            ->setParameter('id', $party_id)
            ->orderBy('table.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $university_ids
     * @return array
     */
    public function getDataForChoice(array $university_ids)
    {
        $queryResult = $this->createQueryBuilder('tb')
            ->andWhere('tb.university IN (:university_ids)')
            ->setParameter('university_ids', $university_ids)
            ->orderBy('tb.name', 'ASC')
            ->getQuery()
            ->getResult();

        $data = ArrayHelper::map($queryResult, 'name', 'id');
        return $data;
    }
}
