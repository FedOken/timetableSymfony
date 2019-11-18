<?php

namespace App\Repository;

use App\Entity\Schedule;
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
        $scheduleWithoutWeek = $this->findOneBy([
            'party' => ArrayHelper::getValue($entity,'party.id'),
            'day' => ArrayHelper::getValue($entity,'day.id'),
            'week' => null,
            'universityTime' => ArrayHelper::getValue($entity,'universityTime.id'),
        ]);

        if ($scheduleWithoutWeek) {
            return $scheduleWithoutWeek;
        }

        $scheduleWithWeek = $this->findOneBy([
            'party' => ArrayHelper::getValue($entity,'party.id'),
            'day' => ArrayHelper::getValue($entity,'day.id'),
            'week' => ArrayHelper::getValue($entity,'week.id'),
            'universityTime' => ArrayHelper::getValue($entity,'universityTime.id'),
        ]);

        return $scheduleWithWeek;
    }
}
