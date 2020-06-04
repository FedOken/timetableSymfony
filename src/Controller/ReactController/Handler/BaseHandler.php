<?php

namespace App\Controller\ReactController\Handler;

use App\Service\Access\AccessService;
use App\Service\StringService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class BaseHandler
{
    protected $access;
    protected $em;
    protected $request;
    protected $strService;

    public function __construct(AccessService $access, EntityManagerInterface $em, RequestStack  $reqStack, StringService $strService)
    {
        $this->access = $access;
        $this->em = $em;
        $this->request = $reqStack->getCurrentRequest();
        $this->strService = $strService;
    }
}