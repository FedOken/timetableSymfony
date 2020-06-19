<?php
namespace App\Entity\EventListener;

use App\Entity\Handler\TeacherHandler;
use App\Entity\Teacher;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TeacherListener
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
}