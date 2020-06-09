<?php

namespace App\Service\Access;

use App\Entity\User;
use App\Helper\ArrayHelper;
use Doctrine\ORM\EntityManagerInterface;

class AccessService
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
     * @return AdminAccess|UniversityAccess|FacultyAccess|PartyAccess|TeacherAccess|UserAccess
     */
    public function getAccessObject($user, string $incomingCode = null, int $incomingId = null)
    {
        $code = ArrayHelper::getValue($user, 'access_code') ? self::explodeAccessCode($user->access_code)['code'] : $incomingCode;
        $id = ArrayHelper::getValue($user, 'access_code') ? self::explodeAccessCode($user->access_code)['id'] : $incomingId;

        if (!$code && !$id) { return null; }

        $responseObject = null;
        switch ($code) {
            case AdminAccess::getAccessCode():
                $responseObject = new AdminAccess($this->em);
                break;
            case UniversityAccess::getAccessCode():
                $responseObject = new UniversityAccess($this->em);
                break;
            case FacultyAccess::getAccessCode():
                $responseObject = new FacultyAccess($this->em);
                break;
            case PartyAccess::getAccessCode():
                $responseObject = new PartyAccess($this->em);
                break;
            case TeacherAccess::getAccessCode():
                $responseObject = new TeacherAccess($this->em);
                break;
            default:
                $responseObject = new UserAccess($this->em);
        }
        $responseObject->init($id);
        return $responseObject;
    }

    private function getAccessCodeByRole(string $incomingRole)
    {
        switch ($incomingRole) {
            case AdminAccess::getAccessRole():
                return AdminAccess::getAccessCode();

            case UniversityAccess::getAccessRole():
                return UniversityAccess::getAccessCode();

            case FacultyAccess::getAccessRole():
                return FacultyAccess::getAccessCode();

            case PartyAccess::getAccessRole():
                return PartyAccess::getAccessCode();

            case TeacherAccess::getAccessRole():
                return TeacherAccess::getAccessCode();

            default:
                return '';
        }
    }
}