<?php
namespace App\Entity\EventListener;

use App\Entity\Handler\UserHandler;
use App\Entity\University;
use App\Entity\User;
use App\Handler\for_entity\WeekHandler;
use App\Helper\EnvHelper;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;

class UniversityListener
{
    public function prePersist(University $model, LifecycleEventArgs $args)
    {
        $model->enable = $model->enable ?: true;
        $model->access_code = EnvHelper::generateRandomStr(10);
        return;
    }

    public function preUpdate(University $model, LifecycleEventArgs $args)
    {
        $model->access_code = EnvHelper::generateRandomStr(10);
        return;
    }
}