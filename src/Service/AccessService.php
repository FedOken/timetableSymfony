<?php

namespace App\Service;

use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\User;
use App\Helper\ArrayHelper;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\DayRepository;
use App\Repository\FacultyRepository;
use App\Repository\PartyRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;

class AccessService
{
    private $em;
    protected $universityRepo;
    protected $facultyRepo;
    protected $buildingRepo;
    protected $cabinetRepo;
    protected $partyRepo;
    protected $teacherRepo;

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

    public function __construct(FacultyRepository $facultyRepository, TeacherRepository $teacherRepository, DayRepository $dayRepository, PartyRepository $partyRepository, UniversityRepository $universityRepo, CabinetRepository $cabinetRepository, BuildingRepository $buildingRepository)
    {
        //Repository
        $this->buildingRepo = $buildingRepository;
        $this->universityRepo = $universityRepo;
        $this->cabinetRepo = $cabinetRepository;
        $this->partyRepo = $partyRepository;
        $this->teacherRepo = $teacherRepository;
        $this->facultyRepo = $facultyRepository;
    }

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
     * Return allowed universities ids
     * @param User|object $user_obj
     * @return array
     */
    public function getUniversityPermission(User $user_obj) {
        $accessCodePerm = explode( '-', $user_obj->getAccessCode());

        //For admin, university()
        if($accessCodePerm[0] == self::ADMIN_CODE) {
            $response = $this->universityRepo->findAll();
            return ArrayHelper::getColumn($response, 'id');
        }
        //For university manager, university(1)
        if($accessCodePerm[0] == self::UNIVERSITY_CODE) {
            return [$accessCodePerm[1]];
        }
        //For faculty manager, faculty(1)->university(1)
        if($accessCodePerm[0] == self::FACULTY_CODE) {
            $facultyModel =  $this->facultyRepo->find($accessCodePerm[1]);
            return [ArrayHelper::getValue($facultyModel, 'university.id')];
        }
        //For party, party(1)->faculty(1)->university(1)
        if($accessCodePerm[0] == self::PARTY_CODE) {
            $partyModel = $this->partyRepo->find($accessCodePerm[1]);
            return [ArrayHelper::getValue($partyModel, 'faculty.university.id')];
        }
        //For teacher, teacher(1)->university(1)
        if($accessCodePerm[0] == self::TEACHER_CODE) {
            $teacherModel =  $this->teacherRepo->find($accessCodePerm[1]);
            return [ArrayHelper::getValue($teacherModel, 'university.id')];
        }
        return [];
    }

    /**
     * Return allowed faculty ids
     * @param User|object $user_obj
     * @return array
     */
    public function getFacultyPermission($user_obj) {
        $accessCodePerm = explode( '-', $user_obj->getAccessCode());

        //For admin get all
        if($accessCodePerm[0] == self::ADMIN_CODE) {
            $faculty_objs = $this->facultyRepo->findAll();
            return ArrayHelper::getColumn($faculty_objs, 'id');
        }
        //For university manager, university->faculty
        if($accessCodePerm[0] == self::UNIVERSITY_CODE) {
            $faculty_objs = $this->facultyRepo->findBy(['university' => $accessCodePerm[1]]);
            return ArrayHelper::getColumn($faculty_objs, 'id');;
        }
        //For faculty manager get from code
        if($accessCodePerm[0] == self::FACULTY_CODE) {
            return [$accessCodePerm[1]];
        }
        //For party, party->faculty
        if($accessCodePerm[0] == self::PARTY_CODE) {
            $party_obj = $this->partyRepo->find($accessCodePerm[1]);
            $faculty_obj = $party_obj->faculty;
            return [$faculty_obj->id];
        }
        return [];
    }

    /**
     * Return allowed faculty ids
     * @param User|object $user_obj
     * @return array
     */
    public function getPartyPermission($user_obj) {
        $accessCodePerm = explode( '-', $user_obj->access_code);

        //For admin get all
        if($accessCodePerm[0] == self::ADMIN_CODE) {
            $response = $this->partyRepo->findAll();
            return ArrayHelper::getColumn($response, 'id');
        }
        //For university manager, university(1)->faculty()->party()
        if($accessCodePerm[0] == self::UNIVERSITY_CODE) {
            $facultyModels = $this->facultyRepo->findBy(['university' => $accessCodePerm[1]]);
            $response = $this->partyRepo->findBy(['faculty' => ArrayHelper::getColumn($facultyModels, 'id')]);
            return ArrayHelper::getColumn($response, 'id');
        }
        //For faculty manager, faculty(1)->party()
        if($accessCodePerm[0] == self::FACULTY_CODE) {
            $response = $this->partyRepo->findBy(['faculty' => $accessCodePerm[1]]);
            return ArrayHelper::getColumn($response, 'id');
        }
        //For party, party(1)
        if($accessCodePerm[0] == self::PARTY_CODE) {
            return [$accessCodePerm[1]];
        }
        return [];
    }
}