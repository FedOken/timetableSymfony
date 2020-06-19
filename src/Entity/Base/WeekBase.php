<?php

namespace App\Entity\Base;

use App\Entity\Base\BaseEntity;
use App\Helper\ArrayHelper;

class WeekBase extends BaseEntity
{
    const WEEK_ALL = '-';

    public function rules()
    {
        return ['name', 'order'];
    }
}