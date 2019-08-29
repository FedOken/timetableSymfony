<?php

namespace App\Controller\EasyAdmin;


use App\Service\AccessService;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;



class FacultyController extends EasyAdminController
{
    /**
     * @param string $entityClass
     * @param string $sortDirection
     * @param null $sortField
     * @param null $dqlFilter
     * @return QueryBuilder Faculty query
     */
    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $response =  parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        $access_service = new AccessService();
        $university_ids = $access_service->getUniversityPermission($this->getUser(), $this->getDoctrine());

        $faculty_ids = [7, 8, 9];

        $response->andWhere('entity.university IN (:university_ids)')->setParameter('university_ids', $university_ids);
        //$response->andWhere('entity.id IN (:faculty_ids)')->setParameter('faculty_ids', $faculty_ids);
        return $response;
    }
}
