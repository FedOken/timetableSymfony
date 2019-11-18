<?php

namespace App\Controller\EasyAdmin;

use App\Handler\UniversityHandler;
use App\Helper\ArrayHelper;
use App\Repository\RoleRepository;
use App\Service\AccessService;
use Symfony\Contracts\Translation\TranslatorInterface;

class RoleController extends AdminController
{
    private $role;

    public function __construct(RoleRepository $roleRepository, TranslatorInterface $translator, UniversityHandler $universityHandler, AccessService $accessService)
    {
        parent::__construct($translator, $universityHandler, $accessService);

        $this->role = $roleRepository;
    }

    /**
     * List action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function listAction()
    {
        $validIds = ArrayHelper::getColumn($this->role->findAll(),'id');
        return $this->listCheckPermissionAndRedirect($validIds, 'Role', AccessService::ROLE_ADMIN);
    }

    /**
     * Edit action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editAction()
    {
        $validIds = ArrayHelper::getColumn($this->role->findAll(),'id');
        return $this->editCheckPermissionAndRedirect($validIds, 'Role', AccessService::ROLE_ADMIN);
    }
}