<?php

namespace App\Helper;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class StringHelper
{
    public static function clearStr($str) {
        $str = str_replace(' ', '', $str);
        $str = preg_replace('/[^A-Za-z0-9]/', '', $str);
        return $str;
    }
}