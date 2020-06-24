<?php

namespace App\Controller\API\Handler;

use App\Service\Access\AccessService;
use App\Service\StringService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class BaseHandler
{
    protected $access;
    protected $em;
    protected $request;
    protected $strService;
    protected $security;

    public function __construct(AccessService $access, EntityManagerInterface $em, RequestStack  $reqStack, StringService $strService, Security $security)
    {
        $this->access = $access;
        $this->em = $em;
        $this->request = $reqStack->getCurrentRequest();
        $this->strService = $strService;
        $this->security = $security;
    }
}