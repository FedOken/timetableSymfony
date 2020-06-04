<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class StringService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function clearStr($str) {
        $str = str_replace(' ', '', $str);
        $str = preg_replace('/[^A-Za-z0-9]/', '', $str);
        return $str;
    }

    public function genRanStr(int $length = 10): string
    {
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }

    public function genRanStrEntity(int $length, string $class, string $prop): string
    {
        $code = $this->genRanStr($length);
        if ($this->em->getRepository($class)->findOneBy([$prop => $code])) {
            $this->genRanStrEntity($length, $class, $prop);
        };
        return $code;
    }
}