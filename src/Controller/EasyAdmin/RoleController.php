<?php

namespace App\Controller\EasyAdmin;

use App\Handler\UniversityHandler;
use App\Helper\ArrayHelper;
use App\Repository\RoleRepository;
use App\Service\Access\AccessService;
use App\Service\Access\AdminAccessService;
use Symfony\Contracts\Translation\TranslatorInterface;

class RoleController extends AdminController
{
    private $role;
    private $validIds = [];

    public function __construct(RoleRepository $roleRepository, TranslatorInterface $translator, UniversityHandler $universityHandler, AccessService $accessService)
    {
        parent::__construct($translator, $universityHandler, $accessService);

        $this->role = $roleRepository;
    }

    private function init()
    {
        $this->validIds = ArrayHelper::getColumn($this->role->findAll(),'id');
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'Role', AdminAccessService::getAccessRole());
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'Role', AdminAccessService::getAccessRole());
    }
}