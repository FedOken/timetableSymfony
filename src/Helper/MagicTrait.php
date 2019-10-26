<?php

namespace App\Helper;

use Symfony\Component\PropertyAccess\PropertyAccessor;

trait MagicTrait
{
    public function __isset($name)
    {
        $accessor = new PropertyAccessor(true);
        return $accessor->isReadable($this, $name);
    }

    public function __get($name)
    {
        $accessor = new PropertyAccessor(true);
        return $accessor->getValue($this, $name);
    }

    public function __set($name, $value)
    {
        $accessor = new PropertyAccessor(true);
        if ($accessor->isWritable($this, $name)) {
            return $this->$name = $value;
        }
        return false;
    }
}