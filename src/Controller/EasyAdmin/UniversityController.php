<?php

namespace App\Controller\EasyAdmin;

use App\Entity\University;
use App\Service\AccessService;

class UniversityController extends AdminController
{
    /**
     * List action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function listAction()
    {
        $validIds = $this->accessService->getUniversityPermission($this->getUser());
        return $this->listCheckPermissionAndRedirect($validIds, 'University', AccessService::ROLE_ADMIN);
    }

    /**
     * Edit action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editAction()
    {
        $validIds = $this->accessService->getUniversityPermission($this->getUser());
        return $this->editCheckPermissionAndRedirect($validIds, 'University', AccessService::ROLE_UNIVERSITY_MANAGER);
    }

    /**
     * Action New, on save
     *
     * @param University $entity
     * @return bool|void
     */
    protected function persistEntity($entity)
    {
        $entity->enable = true;

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
        return true;
    }
}
