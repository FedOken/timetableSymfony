<?php

namespace App\Entity\Base;

use App\Entity\Base\BaseEntity;

class UserBase extends BaseEntity
{
    const STATUS_ACTIVE = 10;
    const STATUS_UNACTIVE = 11;
    const STATUS_WAIT_EMAIL_CONFIRM = 12;

    public function rules()
    {
        return ['email', 'password', 'access_code', 'status', 'roles'];
    }
}