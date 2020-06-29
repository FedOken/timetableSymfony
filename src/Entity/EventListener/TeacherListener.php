<?php
namespace App\Entity\EventListener;

use App\Entity\Handler\TeacherHandler;
use App\Entity\Teacher;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TeacherListener extends BaseListener
{
    /**
     * After model load
     * @param Teacher $model
     * @param LifecycleEventArgs $args
     */
    public function postLoad(Teacher $model, LifecycleEventArgs $args)
    {
        $model->handler = new TeacherHandler($model);
        return;
    }

    public function prePersist(Teacher $model, LifecycleEventArgs $args)
    {
        $model->access_code = $this->strService->genRanStrEntity(10, Teacher::class, 'access_code');
        return;
    }

    public function preUpdate(Teacher $model, LifecycleEventArgs $args)
    {
        $model->access_code = $this->strService->genRanStrEntity(10, Teacher::class, 'access_code');
        return;
    }
}