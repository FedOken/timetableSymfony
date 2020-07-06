<?php

namespace App\Repository;

use App\Entity\SendGridTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SendGridTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method SendGridTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method SendGridTemplate[]    findAll()
 * @method SendGridTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SendGridTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SendGridTemplate::class);
    }

    public function findAllExceptIds(array $templateIds)
    {
        return $this->createQueryBuilder('tb')
            ->andWhere('tb.template_id NOT IN (:templateIds)')
            ->setParameter('templateIds', $templateIds)
            ->getQuery()
            ->getResult();
    }
}
