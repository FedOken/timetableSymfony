<?php

namespace App\Controller\EasyAdmin;

use App\Entity\LessonType;
use App\Helper\ArrayHelper;
use App\Service\Access\AdminAccess;

/**
 * Class LessonTypeController
 * @package App\Controller\EasyAdmin
 *
 * @property array $validIds
 */
class LessonTypeController extends AdminController
{
    private $validIds = [];

    private function init()
    {
        $this->validIds = ArrayHelper::getColumn($this->em->getRepository(LessonType::class)->findAll(),'id');
    }

    protected function newAction()
    {
        $this->init();
        return $this->newCheckPermissionAndRedirect($this->validIds, 'LessonType', [AdminAccess::getAccessRole()]);
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'LessonType', [AdminAccess::getAccessRole()]);
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'LessonType', [AdminAccess::getAccessRole()]);
    }
}