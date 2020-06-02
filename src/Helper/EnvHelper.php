<?php

namespace App\Helper;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class EnvHelper
{
    public static function generateRandomStr($length = 10) {
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }
}