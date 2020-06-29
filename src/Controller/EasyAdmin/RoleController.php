<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Role;
use App\Helper\ArrayHelper;
use App\Service\Access\AdminAccess;

/**
 * Class RoleController
 * @package App\Controller\EasyAdmin
 *
 * @property array $validIds
 */
class RoleController extends AdminController
{
    private $validIds = [];

    private function init()
    {
        $this->validIds = ArrayHelper::getColumn($this->em->getRepository(Role::class)->findAll(),'id');
    }

    protected function newAction()
    {
        $this->init();
        return $this->newCheckPermissionAndRedirect($this->validIds, 'Role', [AdminAccess::getAccessRole()]);
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'Role', [AdminAccess::getAccessRole()]);
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'Role', [AdminAccess::getAccessRole()]);
    }
}