<?php

namespace App\Controller\ReactController\Handler;

use App\Entity\Faculty;
use App\Entity\University;
use App\Entity\User;
use App\Helper\StringHelper;
use App\Service\Access\AdminAccess;
use App\Service\Access\FacultyAccess;
use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;
use App\Service\Access\UniversityAccess;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class ProfileHandler extends BaseHandler
{
    public function getUserData($userCode): array
    {
        try {
            $user = $this->em->getRepository(User::class)->findOneBy(['code' => $userCode]);
            if (!$user) throw new \Exception("User not found.");

            $accessObj = $this->access->getAccessObject($user);
            switch ($accessObj->getAccessRole()) {
                case AdminAccess::getAccessRole():
                   $data = ['Full access'];
                   break;
                case UniversityAccess::getAccessRole():
                    $data = [];
                    break;
                case FacultyAccess::getAccessRole():
                    /** @var University $un */
                    $un = $this->em->getRepository(University::class)->findOneBy(['id' => $accessObj->getAccessibleUniversityIds()]);
                    /** @var Faculty $fac */
                    $fac = $this->em->getRepository(Faculty::class)->findOneBy(['id' => $accessObj->getAccessibleFacultyIds()]);
                    $data = [
                        'university' => $un->name_full,
                        'faculty' => $fac->name_full
                    ];
                    break;
                case PartyAccess::getAccessRole():
                    $data = [];
                    break;
                case TeacherAccess::getAccessRole():
                    $data = [];
                    break;
                default:
                    throw new \Exception("Role is not set.");
                    break;
            }
            return [
                'status' => true,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}