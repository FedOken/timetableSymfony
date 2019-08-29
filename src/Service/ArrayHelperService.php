<?php

namespace App\Service;

class ArrayHelperService
{
    public static function getAllIdsFromObjectsArray($array) {
        $result = [];
        foreach ($array as $object) {
            $result[] = $object->getId();
        }
        return $result;
    }
}