<?php

namespace App\Controller\EasyAdmin;

use App\Entity\University;
use App\Service\Access\AccessService;
use App\Service\Access\AdminAccess;
use App\Service\Access\UniversityAccess;

class UniversityController extends AdminController
{
    private $validIds = [];

    /** Set params */
    private function init()
    {
        $this->validIds = $this->accessService->getAccessObject($this->getUser())->getAccessibleUniversityIds();
    }

    /** List action override */
    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'University', AdminAccess::getAccessRole());
    }

    /** Edit action override */
    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'University', UniversityAccess::getAccessRole());
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
