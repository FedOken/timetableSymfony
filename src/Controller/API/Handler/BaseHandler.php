<?php

namespace App\Controller\API\Handler;

use App\Service\Access\AccessService;
use App\Service\MailerService;
use App\Service\StringService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class BaseHandler
 * @package App\Controller\API\Handler
 *
 * @property AccessService $access
 * @property EntityManagerInterface $em
 * @property RequestStack $request
 * @property StringService $strService
 * @property Security $security
 * @property MailerService $mailer
 * @property UrlGeneratorInterface $router
 */
class BaseHandler
{
    protected $access;
    protected $em;
    protected $request;
    protected $strService;
    protected $security;
    protected $mailer;
    protected $router;

    public function __construct(AccessService $access, EntityManagerInterface $em, RequestStack  $reqStack, StringService $strService, Security $security, MailerService $mailer, UrlGeneratorInterface $router)
    {
        $this->access = $access;
        $this->em = $em;
        $this->request = $reqStack->getCurrentRequest();
        $this->strService = $strService;
        $this->security = $security;
        $this->mailer = $mailer;
        $this->router = $router;
    }
}