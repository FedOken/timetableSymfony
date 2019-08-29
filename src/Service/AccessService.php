<?php

namespace App\Service;

use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;

class AccessService
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_UNIVERSITY_MANAGER = 'ROLE_UNIVERSITY_MANAGER';
    const ROLE_FACULTY_MANAGER = 'ROLE_FACULTY_MANAGER';
    const ROLE_PARTY_MANAGER = 'ROLE_PARTY_MANAGER';
    const ROLE_TEACHER = 'ROLE_TEACHER';

    const ADMIN_CODE = 'A';
    const UNIVERSITY_CODE = 'U';
    const FACULTY_CODE = 'F';
    const PARTY_CODE = 'P';
    const TEACHER_CODE = 'T';

    /**
     * Create access code for User entity
     * A-0. Global access
     * U-0, F-0... No access, user forgot choose access id.
     *
     * @param string $role
     * @param int $id
     * @return string|null
     */
    public function creatAccessCode(string $role, int $id = 0)
    {
        switch ($role) {
            case self::ROLE_ADMIN:
                return self::ADMIN_CODE.'-'.$id;
                break;
            case self::ROLE_UNIVERSITY_MANAGER:
                return self::UNIVERSITY_CODE.'-'.$id;
                break;
            case self::ROLE_FACULTY_MANAGER:
                return self::FACULTY_CODE.'-'.$id;
                break;
            case self::ROLE_PARTY_MANAGER:
                return self::PARTY_CODE.'-'.$id;
                break;
            case self::ROLE_TEACHER:
                return self::TEACHER_CODE.'-'.$id;
                break;
        }

        return null;
    }

    /**
     * @param User $user_obj
     * @param $doctrine Registry
     * @return array
     */
    public function getUniversityPermission(User $user_obj, Registry $doctrine) {
        $access_arr = explode( '-', $user_obj->getAccessCode());


        if($access_arr[0] == self::ADMIN_CODE) {
            $university_objs = $doctrine->getRepository(University::class)->findAll();
            return ArrayHelperService::getAllIdsFromObjectsArray($university_objs);
        }
        if($access_arr[0] == self::UNIVERSITY_CODE) {
            return [$access_arr[1]];
        }
        if($access_arr[0] == self::FACULTY_CODE) {
            $faculty_obj = $doctrine->getRepository(Faculty::class)->find($access_arr[1]);
            $university_obj = $doctrine->getRepository(University::class)->find($faculty_obj->getUniversity());
            return [$university_obj->getId()];
        }
        if($access_arr[0] == self::PARTY_CODE) {
            $party_obj = $doctrine->getRepository(Party::class)->find($access_arr[1]);
            $university_obj = $doctrine->getRepository(University::class)->find($party_obj->getUniversity());
            return [$university_obj->getId()];
        }
        if($access_arr[0] == self::TEACHER_CODE) {
            $teacher_obj = $doctrine->getRepository(Teacher::class)->find($access_arr[1]);
            $university_obj = $doctrine->getRepository(University::class)->find($teacher_obj->getUniversity());
            return [$university_obj->getId()];
        }

        return [];
    }

}