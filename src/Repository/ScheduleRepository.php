<?php

namespace App\Repository;

use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\University;
use App\Helper\ArrayHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Schedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedule[]    findAll()
 * @method Schedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Schedule::class);
    }

    /**
     * @param Schedule $entity
     * @return Schedule|null
     */
    public function checkUniqueEntity(Schedule $entity)
    {
        $scheduleWithWeek = $this->findOneBy([
            'party' => ArrayHelper::getValue($entity,'party.id'),
            'day' => ArrayHelper::getValue($entity,'day.id'),
            'week' => ArrayHelper::getValue($entity,'week.id'),
            'universityTime' => ArrayHelper::getValue($entity,'universityTime.id'),
        ]);

        return $scheduleWithWeek;
    }

    /**
     * @param int $universityId
     * @return University[]
     */
    public function findSchByParams(string $type, array $weekIds, int $id, int $day, int $time)
    {
        $query = $this->createQueryBuilder('tb');
        $query->andWhere('tb.week IN (:weekIds)');
        $query->setParameter('weekIds', $weekIds);
        $query->andWhere('tb.day = (:day)');
        $query->setParameter('day', $day);
        $query->andWhere('tb.universityTime = (:time)');
        $query->setParameter('time', $time);

        switch ($type) {
            case 'group':
                $query->andWhere('tb.party = (:id)');
                $query->setParameter('id', $id);
                break;
            case 'teacher':
                $query->andWhere('tb.teacher = (:id)');
                $query->setParameter('id', $id);
                break;
            case 'cabinet':
                $query->andWhere('tb.cabinet = (:id)');
                $query->setParameter('id', $id);
                break;
        }
        return $query->getQuery()->getResult();
    }
}
