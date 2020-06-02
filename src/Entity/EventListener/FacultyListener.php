<?php
namespace App\Entity\EventListener;

use App\Entity\Faculty;
use App\Helper\EnvHelper;
use Doctrine\ORM\Event\LifecycleEventArgs;

class FacultyListener
{
    public function prePersist(Faculty $model, LifecycleEventArgs $args)
    {
        $model->enable = $model->enable ?: true;
        $model->access_code = EnvHelper::generateRandomStr(10);
        return;
    }

    public function preUpdate(Faculty $model, LifecycleEventArgs $args)
    {
        $model->access_code = EnvHelper::generateRandomStr(10);
        return;
    }
}