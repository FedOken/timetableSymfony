<?php

namespace App\Controller\EasyAdmin;


use App\Service\AccessService;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;



class FacultyController extends EasyAdminController
{
    private $access_service;

    public function __construct(AccessService $access_service)
    {
        $this->access_service = $access_service;
    }

    /**
     * @param string $entityClass
     * @param string $sortDirection
     * @param null $sortField
     * @param null $dqlFilter
     * @return QueryBuilder Faculty query
     */
    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $response = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        $university_ids = $this->access_service->getUniversityPermission($this->getUser());

        $faculty_ids = [7, 8, 9];

        $response->andWhere('entity.university IN (:university_ids)')->setParameter('university_ids', $university_ids);
        //$response->andWhere('entity.id IN (:faculty_ids)')->setParameter('faculty_ids', $faculty_ids);
        return $response;
    }
}
