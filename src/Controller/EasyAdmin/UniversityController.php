<?php

namespace App\Controller\EasyAdmin;


use App\Service\AccessService;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;


class UniversityController extends EasyAdminController
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

        $response->andWhere('entity.id IN (:university_ids)')->setParameter('university_ids', $university_ids);
        return $response;
    }

    /**
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function listAction()
    {
        if ($this->isGranted(AccessService::ROLE_ADMIN)) {
            return parent::listAction();
        }
        if ($this->isGranted(AccessService::ROLE_UNIVERSITY_MANAGER)) {

            $university_ids = $this->access_service->getUniversityPermission($this->getUser());
            return $this->redirect('?action=show&entity=University&id='.$university_ids[0]);
        } else {
            $this->denyAccessUnlessGranted(AccessService::ROLE_UNIVERSITY_MANAGER);
        }
        return false;
    }

    protected function editAction()
    {
        if ($this->isGranted(AccessService::ROLE_ADMIN)) {
            return parent::editAction();
        }
        if ($this->isGranted(AccessService::ROLE_UNIVERSITY_MANAGER)) {
            $university_ids = $this->access_service->getUniversityPermission($this->getUser());
            if ($this->request->get('id') == $university_ids[0]) {
                return parent::editAction();
            } else {
                return $this->redirect('?action=edit&entity=University&id='.$university_ids[0]);
            }
        } else {
            $this->denyAccessUnlessGranted(AccessService::ROLE_UNIVERSITY_MANAGER);
        }
        return false;
    }

    protected function autocompleteAction()
    {
//        if ('Lugar' === $this->request->query->get('entity')) {
//            $results = // make custom query and see Autocomplete class to know how to parse the results.
//
//            return new JsonResponse($results);
//        }
        $results = $this->get('easyadmin.autocomplete')->find(
            $this->request->query->get('entity'),
            $this->request->query->get('query'),
            $this->request->query->get('page', 1),
            'entity.activo = true'
        );

        $result_2 = ['results' => [['id' => 12, 'text' => 'klilik']]];

        return new JsonResponse($result_2);


        return parent::autocompleteAction();
    }
}
