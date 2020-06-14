<?php

namespace App\Entity\Base;

use App\Entity\Base\BaseEntity;
use App\Helper\ArrayHelper;

class UserBase extends BaseEntity
{
    const STATUS_ACTIVE = 10;
    const STATUS_UNACTIVE = 11;
    const STATUS_WAIT_EMAIL_CONFIRM = 12;

    public function getStatusList($status = null)
    {
        $arr = [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_UNACTIVE => 'Disabled',
            self::STATUS_WAIT_EMAIL_CONFIRM => 'Wait email confirmation',
        ];
        return $status ? ArrayHelper::getValue($arr, $status) : $arr;
    }

    public function rules()
    {
        return ['email', 'password', 'access_code', 'status', 'roles', 'first_name', 'last_name', 'phone'];
    }
}