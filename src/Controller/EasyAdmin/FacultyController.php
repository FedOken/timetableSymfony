<?php

namespace App\Controller\EasyAdmin;


use App\Entity\University;
use App\Service\AccessService;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminAutocompleteType;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;


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

    protected function createEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        $formBuilder->add('university', Select2EntityType::class, [
            'remote_route' => 'test-route',
            //'class' => University::class,
            //'primary_key' => 'id',
            'required' => true,
            'minimum_input_length' => 0,
            'page_limit' => 10,
            'help' => 'Choose your university',
            'disabled' => false,
            //'delay' => 250,
            //'cache' => true,
            //'cache_timeout' => 60000, // if 'cache' is true
            //'language' => 'en',
            'placeholder' => 'Select a country',
        ]);

        return $formBuilder;
    }
}
