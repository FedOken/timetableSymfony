<?php

namespace App\Entity\Base;

use App\Entity\Base\BaseEntity;
use App\Helper\ArrayHelper;

class ContactBase extends BaseEntity
{
    const STATUS_NEW = 10;
    const STATUS_PROCESSED = 11;

    const TYPE_BUSINESS = 20;
    const TYPE_TECHNICAL = 21;

    public function rules()
    {
        return ['email', 'phone', 'type', 'status', 'message'];
    }

    public function getStatusList($status = null)
    {
        $arr = [
            self::STATUS_NEW => 'New',
            self::STATUS_PROCESSED => 'Processed',
        ];
        return $status ? ArrayHelper::getValue($arr, $status) : $arr;
    }

    public function getTypeList($status = null)
    {
        $arr = [
            self::TYPE_BUSINESS => 'Business',
            self::TYPE_TECHNICAL => 'Technical',
        ];
        return $status ? ArrayHelper::getValue($arr, $status) : $arr;
    }
}