<?php
namespace App\Entity\EventListener;

use App\Entity\University;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UniversityListener extends BaseListener
{
    public function prePersist(University $model, LifecycleEventArgs $args)
    {
        $model->enable = $model->enable ?: true;
        $model->access_code = $this->strService->genRanStrEntity(10, University::class, 'access_code');
        return;
    }

    public function preUpdate(University $model, LifecycleEventArgs $args)
    {
        $model->access_code = $this->strService->genRanStrEntity(10, University::class, 'access_code');
        return;
    }
}