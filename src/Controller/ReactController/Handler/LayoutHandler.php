<?php

namespace App\Controller\ReactController\Handler;

use App\Entity\User;
use App\Handler\BaseHandler;
use App\Service\Access\AccessService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Security\Core\Security;

class LayoutHandler extends BaseHandler
{
    private $security;

    public function __construct(AccessService $access, EntityManagerInterface $entityManager, Security $security)
    {
        $this->security = $security;
        parent::__construct($access, $entityManager);
    }

    public function getUserData(): array
    {
        try {
            /**@var User $user */
            $user = $this->security->getUser();
            $data = $user ? $user->handler->serialize() : [];
            return [
                'status' => true,
                'data' => $data
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}