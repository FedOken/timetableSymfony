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
     * @param User|object $user_obj
     * @return array
     */
    public function getUniversityPermission(User $user_obj) {
        $accessCodePerm = explode( '-', $user_obj->getAccessCode());

        //For admin get all universities
        if($accessCodePerm[0] == self::ADMIN_CODE) {
            $university_objs = $this->universityRepo->findAll();
            return ArrayHelper::getColumn($university_objs, 'id');
        }
        //For university manager get university from code
        if($accessCodePerm[0] == self::UNIVERSITY_CODE) {
            return [$accessCodePerm[1]];
        }
        //For faculty manager, get university by relation
        if($accessCodePerm[0] == self::FACULTY_CODE) {
            $faculty_obj =  $this->facultyRepo->find($accessCodePerm[1]);
            $university_obj = $this->universityRepo->find($faculty_obj->university);
            return [$university_obj->id];
        }
        //For party, get faculty
        if($accessCodePerm[0] == self::PARTY_CODE) {
            $party_obj = $this->partyRepo->find($accessCodePerm[1]);
            $university_obj = $party_obj->faculty->university;
            return [$university_obj->getId()];
        }
        if($access_arr[0] == self::TEACHER_CODE) {
            $teacher_obj =  $this->em->getRepository(Teacher::class)->find($access_arr[1]);
            $university_obj =  $this->em->getRepository(University::class)->find($teacher_obj->getUniversity());
            return [$university_obj->getId()];
        }

        return [];
    }
}