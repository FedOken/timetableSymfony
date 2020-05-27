<?php
namespace App\Entity\EventListener;

use App\Entity\Teacher;
use App\Handler\for_entity\TeacherHandler;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TeacherListener
{
    private $handler;

    public function __construct(TeacherHandler $handler)
    {
        $this->handler = $handler;
    }

    public function postLoad(Teacher $model, LifecycleEventArgs $args)
    {
        $model->handler = $this->handler;
        return;
    }
}