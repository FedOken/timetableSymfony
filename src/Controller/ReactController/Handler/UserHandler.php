<?php

namespace App\Controller\ReactController\Handler;

use App\Entity\Faculty;
use App\Entity\University;
use App\Entity\User;
use App\Handler\BaseHandler;
use App\Service\Access\AccessService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Security\Core\Security;

class UserHandler extends BaseHandler
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
            $relation = $this->getRelations($user);
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

    public function getUserRelation(): array
    {
        try {
            /**@var User $user */
            $user = $this->security->getUser();
            $data = $this->getRelations($user);
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

    private function getRelations($user): array
    {
        $data = [];
        $accessObj = $this->access->getAccessObject($user);
        /** @var University[] $uns */
        $uns = $this->em->getRepository(University::class)->findBy(['id' => $accessObj->getAccessibleUniversityIds()]);
        foreach ($uns as $model) {
            $data['universities'][] = [
                'id' => $model->id,
                'name' => $model->name,
                'name_full' => $model->name_full,
            ];
        }
        /** @var Faculty[] $facs */
        $facs = $this->em->getRepository(Faculty::class)->findBy(['id' => $accessObj->getAccessibleFacultyIds()]);
        foreach ($facs as $model) {
            $data['faculties'][] = [
                'id' => $model->id,
                'name' => $model->name,
                'name_full' => $model->name_full,
            ];
        }
        return $data;
    }
}
