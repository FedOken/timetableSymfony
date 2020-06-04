<?php
namespace App\Entity\EventListener;

use App\Entity\Faculty;
use Doctrine\ORM\Event\LifecycleEventArgs;

class FacultyListener extends BaseListener
{
    public function prePersist(Faculty $model, LifecycleEventArgs $args)
    {
        $model->enable = $model->enable ?: true;
        $model->access_code = $this->strService->genRanStrEntity(10, Faculty::class, 'access_code');
        return;
    }

    public function preUpdate(Faculty $model, LifecycleEventArgs $args)
    {
        $model->access_code = $this->strService->genRanStrEntity(10, Faculty::class, 'access_code');
        return;
    }
}