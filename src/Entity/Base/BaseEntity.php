<?php

namespace App\Entity\Base;

use App\Entity\Schedule;
use App\Controller\EasyAdmin\Handler\BaseHandler;

abstract class BaseEntity
{
    public abstract function rules();

    public function load($values = []): void
    {
        $params = $this->rules();
        foreach ($params as $param) {
            if (isset($values[$param])) {
                $this->$param = $values[$param];
            }
        }
        return;
    }

}