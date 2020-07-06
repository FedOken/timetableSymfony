<?php

namespace App\Entity\Base;

use App\Entity\Base\BaseEntity;
use App\Helper\ArrayHelper;

class SendGridTemplateBase extends BaseEntity
{
    const API_KEY = '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';
    const ADMIN_EMAIL = 'sch1.fedok@gmail.com';

    public function rules()
    {
        return ['template_id', 'name', 'slug'];
    }
}