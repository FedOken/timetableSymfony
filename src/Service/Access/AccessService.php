<?php

namespace App\Service\Access;

use App\Entity\User;
use App\Helper\ArrayHelper;
use Doctrine\ORM\EntityManagerInterface;

class AccessService
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Create access code for User entity
     * A-0. Global access
     * U-0, F-0... No access, user forgot choose access id.
     *
     * @param string $incomingRole
     * @param int $id
     * @return string|null
     */
    public function createAccessCode(string $incomingRole, int $id = 0)
    {
        $code = $this->getAccessCodeByRole($incomingRole);
        if (!$code) {return ''; }
        $accessObject = $this->getAccessObject(null, $code, $id);
        return $accessObject->getAccessCode().'-'.$id;
    }

    /**
     * @param string $code
     * @return array
     */
    public static function explodeAccessCode(string $code): array
    {
        if (!$code) { return []; }

        $codeArray = explode( '-', $code);
        return ['code' => $codeArray[0], 'id' => $codeArray[1]];
    }

    /**
     * @param User|object|null $user
     * @param string $incomingCode
     * @param int $incomingId
     *
     * @return AdminAccessService|FacultyAccessService
     */
    public function getAccessObject($user, string $incomingCode = null, int $incomingId = null)
    {
        $code = ArrayHelper::getValue($user, 'access_code') ? self::explodeAccessCode($user->access_code)['code'] : $incomingCode;
        $id = ArrayHelper::getValue($user, 'access_code') ? self::explodeAccessCode($user->access_code)['id'] : $incomingId;

        if (!$code && !$id) { return null; }

        $responseObject = null;
        switch ($code) {
            case AdminAccessService::getAccessCode():
                $responseObject = new AdminAccessService($this->em);
                break;
            case UniversityAccessService::getAccessCode():
                $responseObject = new UniversityAccessService($this->em);
                break;
            case FacultyAccessService::getAccessCode():
                $responseObject = new FacultyAccessService($this->em);
                break;
            case PartyAccessService::getAccessCode():
                $responseObject = new PartyAccessService($this->em);
                break;
            case TeacherAccessService::getAccessCode():
                $responseObject = new TeacherAccessService($this->em);
                break;
            default:
                $responseObject = new UserAccessService($this->em);
        }
        $responseObject->init($id);
        return $responseObject;
    }

    private function getAccessCodeByRole(string $incomingRole)
    {
        switch ($incomingRole) {
            case AdminAccessService::getAccessRole():
                return AdminAccessService::getAccessCode();

            case UniversityAccessService::getAccessRole():
                return UniversityAccessService::getAccessCode();

            case FacultyAccessService::getAccessRole():
                return FacultyAccessService::getAccessCode();

            case PartyAccessService::getAccessRole():
                return PartyAccessService::getAccessCode();

            case TeacherAccessService::getAccessRole():
                return TeacherAccessService::getAccessCode();

            default:
                return '';
        }
    }







//    /**
//     * Return allowed universities ids
//     * @param User|object $user_obj
//     * @return array
//     */
//    public function getUniversityPermission(User $user_obj) {
//        $accessCodePerm = explode( '-', $user_obj->getAccessCode());
//
//        //For admin, university()
//        if($accessCodePerm[0] == self::ADMIN_CODE) {
//            $response = $this->universityRepo->findAll();
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For university manager, university(1)
//        if($accessCodePerm[0] == self::UNIVERSITY_CODE) {
//            return [$accessCodePerm[1]];
//        }
//        //For faculty manager, faculty(1)->university(1)
//        if($accessCodePerm[0] == self::FACULTY_CODE) {
//            $facultyModel =  $this->facultyRepo->find($accessCodePerm[1]);
//            return [ArrayHelper::getValue($facultyModel, 'university.id')];
//        }
//        //For party, party(1)->faculty(1)->university(1)
//        if($accessCodePerm[0] == self::PARTY_CODE) {
//            $partyModel = $this->partyRepo->find($accessCodePerm[1]);
//            return [ArrayHelper::getValue($partyModel, 'faculty.university.id')];
//        }
//        //For teacher, teacher(1)->university(1)
//        if($accessCodePerm[0] == self::TEACHER_CODE) {
//            $teacherModel =  $this->teacherRepo->find($accessCodePerm[1]);
//            return [ArrayHelper::getValue($teacherModel, 'university.id')];
//        }
//        return [];
//    }
//
//    /**
//     * Return allowed faculty ids
//     * @param User|object $user_obj
//     * @return array
//     */
//    public function getFacultyPermission($user_obj) {
//        $accessCode = $this->explodeAccessCode($user_obj);
//        $universityIds = $this->getUniversityPermission($user_obj);
//
//        switch ($accessCode['roleCode']) {
//            case self::ADMIN_CODE:
//                $response = $this->facultyRepo->findAll();
//                return ArrayHelper::getColumn($response, 'id');
//
//            case self::UNIVERSITY_CODE:
//                $response = $this->facultyRepo->findBy(['university' => $accessCode['id']]);
//                return ArrayHelper::getColumn($response, 'id');
//
//            case self::FACULTY_CODE:
//                return [$accessCode['id']];
//
//            case self::PARTY_CODE:
//                $party_obj = $this->partyRepo->find($accessCode['id']);
//                $response = $party_obj->faculty;
//                return [$response->id];
//
//            default:
//                return [];
//        }
//    }
//
//    /**
//     * Return allowed faculty ids
//     * @param User|object $user_obj
//     * @return array
//     */
//    public function getPartyPermission($user_obj) {
//        $accessCodePerm = explode( '-', $user_obj->access_code);
//
//        //For admin get all
//        if($accessCodePerm[0] == self::ADMIN_CODE) {
//            $response = $this->partyRepo->findAll();
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For university manager, university(1)->faculty()->party()
//        if($accessCodePerm[0] == self::UNIVERSITY_CODE) {
//            $facultyModels = $this->facultyRepo->findBy(['university' => $accessCodePerm[1]]);
//            $response = $this->partyRepo->findBy(['faculty' => ArrayHelper::getColumn($facultyModels, 'id')]);
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For faculty manager, faculty(1)->party()
//        if($accessCodePerm[0] == self::FACULTY_CODE) {
//            $response = $this->partyRepo->findBy(['faculty' => $accessCodePerm[1]]);
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For party, party(1)
//        if($accessCodePerm[0] == self::PARTY_CODE) {
//            return [$accessCodePerm[1]];
//        }
//        return [];
//    }
//
//    /**
//     * Return allowed faculty ids
//     * @param User|object $user_obj
//     * @return array
//     */
//    public function getTeacherPermission($user_obj) {
//        $accessCodePerm = explode( '-', $user_obj->getAccessCode());
//
//        //For admin get all
//        if($accessCodePerm[0] == self::ADMIN_CODE) {
//            $teacher_objs = $this->teacherRepo->findAll();
//            return ArrayHelper::getColumn($teacher_objs, 'id');
//        }
//        //For university manager, university->faculty
//        if($accessCodePerm[0] == self::UNIVERSITY_CODE) {
//            $teacher_objs = $this->teacherRepo->findBy(['university' => $accessCodePerm[1]]);
//            return ArrayHelper::getColumn($teacher_objs, 'id');
//        }
//        //For faculty manager get from code
//        if($accessCodePerm[0] == self::FACULTY_CODE) {
//            $teacher_objs = $this->teacherRepo->findBy(['university' => $accessCodePerm[1]]);
//            return ArrayHelper::getColumn($teacher_objs, 'id');
//        }
//        return [];
//    }
//
//    /**
//     * Return allowed faculty ids
//     * @param User|object $user_obj
//     * @return array
//     */
//    public function getBuildingPermission($user_obj) {
//        $accessCodePerm = explode( '-', $user_obj->access_code);
//
//        //For admin get all
//        if($accessCodePerm[0] == self::ADMIN_CODE) {
//            $response = $this->buildingRepo->findAll();
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For university manager, university(1)->building()
//        if($accessCodePerm[0] == self::UNIVERSITY_CODE) {
//            $response = $this->buildingRepo->findBy(['university' => $accessCodePerm[1]]);
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For faculty manager, faculty(1)->university(1)->building()
//        if($accessCodePerm[0] == self::FACULTY_CODE) {
//            $facultyModel = $this->facultyRepo->findBy(['id' => $accessCodePerm[1]]);
//            $response = $this->buildingRepo->findBy(['university' => ArrayHelper::getValue($facultyModel, 'university.id')]);
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For party manager, party(1)->faculty(1)->university(1)->building()
//        if($accessCodePerm[0] == self::PARTY_CODE) {
//            $partyModel = $this->partyRepo->findOneBy(['id' => $accessCodePerm[1]]);
//            $facultyModel = $this->facultyRepo->findOneBy(['id' => ArrayHelper::getValue($partyModel, 'faculty.id')]);
//            $response = $this->buildingRepo->findBy(['university' => ArrayHelper::getValue($facultyModel, 'university.id')]);
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        return [];
//    }
//
//    /**
//     * Return allowed faculty ids
//     * @param User|object $user_obj
//     * @return array
//     */
//    public function getCabinetPermission($user_obj) {
//        $accessCodePerm = explode( '-', $user_obj->access_code);
//
//        //For admin get all
//        if($accessCodePerm[0] == self::ADMIN_CODE) {
//            $response = $this->cabinetRepo->findAll();
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For university manager, university(1)->building()->cabinet()
//        if($accessCodePerm[0] == self::UNIVERSITY_CODE) {
//            $buildingModels = $this->buildingRepo->findBy(['university' => $accessCodePerm[1]]);
//            $response = $this->cabinetRepo->findBy(['building' => ArrayHelper::getColumn($buildingModels, 'id')]);
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For faculty manager, faculty(1)->university(1)->building()->cabinet()
//        if($accessCodePerm[0] == self::FACULTY_CODE) {
//            $facultyModel = $this->facultyRepo->findBy(['id' => $accessCodePerm[1]]);
//            $buildingModels = $this->buildingRepo->findBy(['university' => ArrayHelper::getValue($facultyModel, 'university.id')]);
//            $response = $this->cabinetRepo->findBy(['building' => ArrayHelper::getColumn($buildingModels, 'id')]);
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        return [];
//    }
//
//    /**
//     * Return allowed faculty ids
//     * @param User|object $user_obj
//     * @param string $repository
//     * @return array
//     */
//    public function getCourseWeekTimePermission($user_obj, $repository) {
//
//        if ($repository === 'course') {
//            $repo = $this->courseRepo;
//        } else if ($repository === 'week') {
//            $repo = $this->weekRepo;
//        } else if ($repository === 'time') {
//            $repo = $this->universityTimeRepo;
//        } else {
//            return [];
//        }
//
//        $universityIds = $this->getUniversityPermission($user_obj);
//        $response = $repo->findBy(['university' => $universityIds]);
//        return ArrayHelper::getColumn($response, 'id');
//    }
//
//    /**
//     * Return allowed faculty ids
//     * @param User|object $user_obj
//     * @return array
//     */
//    public function getSchedulePermission($user_obj) {
//        $accessCodePerm = explode( '-', $user_obj->access_code);
//
//        //For admin get all
//        if($accessCodePerm[0] == self::ADMIN_CODE) {
//            $response = $this->scheduleRepo->findAll();
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For university manager, university(1)->faculty()->party()->schedule()
//        if($accessCodePerm[0] == self::UNIVERSITY_CODE) {
//            $facultyModels = $this->facultyRepo->findBy(['university' => $accessCodePerm[1]]);
//            $partyModels = $this->partyRepo->findBy(['faculty' => ArrayHelper::getColumn($facultyModels, 'id')]);
//            $response = $this->scheduleRepo->findBy(['party' => ArrayHelper::getColumn($partyModels, 'id')]);
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For faculty manager, faculty(1)->party()->schedule()
//        if($accessCodePerm[0] == self::FACULTY_CODE) {
//            $partyModels = $this->partyRepo->findBy(['faculty' => $accessCodePerm[1]]);
//            $response = $this->scheduleRepo->findBy(['party' => ArrayHelper::getColumn($partyModels, 'id')]);
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        //For party, party(1)->schedule()
//        if($accessCodePerm[0] == self::PARTY_CODE) {
//            $response = $this->scheduleRepo->findBy(['party' => $accessCodePerm[1]]);
//            return ArrayHelper::getColumn($response, 'id');
//        }
//        return [];
//    }
}