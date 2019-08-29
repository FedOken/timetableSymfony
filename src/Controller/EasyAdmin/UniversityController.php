<?php

namespace App\Controller\EasyAdmin;


use App\Service\AccessService;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;



class UniversityController extends EasyAdminController
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
        $response = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        $access_service = new AccessService();
        $university_ids = $access_service->getUniversityPermission($this->getUser(), $this->getDoctrine());

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
            $access_service = new AccessService();
            $university_ids = $access_service->getUniversityPermission($this->getUser(), $this->getDoctrine());
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
            $access_service = new AccessService();
            $university_ids = $access_service->getUniversityPermission($this->getUser(), $this->getDoctrine());
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
}
