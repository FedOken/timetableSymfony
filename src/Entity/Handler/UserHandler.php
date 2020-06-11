<?php

namespace App\Entity\Handler;

use App\Entity\Faculty;
use App\Entity\University;
use App\Entity\User;
use App\Service\Access\AccessService;
use Doctrine\ORM\EntityManagerInterface;

class UserHandler
{
    private $user;

    public function __construct(User $model)
    {
        $this->user = $model;
    }

    public function serialize()
    {
        $data = [
            'status' => $this->user->getStatusList($this->user->status),
            'email' => $this->user->email,
            'role' => $this->user->roles[0],
            'phone' => $this->user->phone,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'code' => $this->user->code,
            //'relation' => $this->getRelations(),
        ];
        return $data;
    }

    public function getRelations(): array
    {
        $data = [];
        $accessObj = $this->access->getAccessObject($this->user);
        /** @var University[] $uns */
        $uns = $this->em->getRepository(University::class)->findOneBy(['id' => $accessObj->getAccessibleUniversityIds()]);
        foreach ($uns as $model) {
            $data['universities'][] = [
                'id' => $model->id,
                'name' => $model->name,
                'name_full' => $model->name_full,
            ];
        }
        /** @var Faculty[] $facs */
        $facs = $this->em->getRepository(Faculty::class)->findOneBy(['id' => $accessObj->getAccessibleFacultyIds()]);
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
