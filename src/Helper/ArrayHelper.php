<?php

namespace App\Helper;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class ArrayHelper
{
    public static function getAllIdsFromObjectsArray($array) {
        $result = [];
        foreach ($array as $object) {
            $result[] = $object->getId();
        }
        return $result;
    }

    /**
     * @param array|object $array
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public static function getValue($array, string $key, $default = null)
    {
        //For object
        if (is_object($array)) {
            if (property_exists($array, $key)) {
                return $array->$key;
            }
        }

        //For array
        if (is_array($array)) {
            return (isset($array[$key]) || array_key_exists($key, $array)) ? $array[$key] : $default;
        }

        return $default;
    }

    /**
     * @param array $array
     * @param string $from
     * @param string $to
     * @return array
     */
    public static function map($array, string $from, string $to)
    {
        $result = [];
        foreach ($array as $element) {
            $key = static::getValue($element, $from);
            $value = static::getValue($element, $to);
            $result[$key] = $value;
        }

        return $result;
    }

    public static function getColumn($array, $name, $keepKeys = true)
    {
        $result = [];
        if ($keepKeys) {
            foreach ($array as $k => $element) {
                $result[$k] = static::getValue($element, $name);
            }
        } else {
            foreach ($array as $element) {
                $result[] = static::getValue($element, $name);
            }
        }

        return $result;
    }
}