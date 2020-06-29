<?php


namespace App\Controller\EasyAdmin\Handler;


use App\Entity\User;
use App\Repository\UniversityRepository;
use App\Service\Access\AccessService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class BaseHandler
 * @package App\Controller\EasyAdmin\Handler
 *
 * @property AccessService $access
 * @property EntityManagerInterface $em
 * @property User $user
 */
class BaseHandler
{
    protected $access;
    protected $em;
    protected $user;

    public function __construct(AccessService $access, EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        //Access service
        $this->access = $access;
        $this->em = $em;
        $this->user = $tokenStorage->getToken()->getUser();
    }
}