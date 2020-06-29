<?php

namespace App\Controller\EasyAdmin;

use App\Service\Access\AdminAccess;
use App\Service\Access\UniversityAccess;

/**
 * Class UniversityController
 * @package App\Controller\EasyAdmin
 *
 * @property array $validIds
 */
class UniversityController extends AdminController
{
    private $validIds = [];

    /** Set params */
    private function init()
    {
        $this->validIds = $this->accessService->getAccessObject($this->getUser())->getAccessibleUniversityIds();
    }

    protected function newAction()
    {
        $this->init();
        return $this->newCheckPermissionAndRedirect($this->validIds, 'University', [AdminAccess::getAccessRole()]);
    }

    /** List action override */
    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'University', [AdminAccess::getAccessRole()]);
    }

    /** Edit action override */
    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'University', [UniversityAccess::getAccessRole()]);
    }
}
