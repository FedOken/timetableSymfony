<?php

namespace App\Handler\for_controller\react;

use App\Entity\Faculty;
use App\Entity\University;
use App\Entity\User;
use App\Handler\BaseHandler;
use App\Helper\StringHelper;
use App\Service\Access\FacultyAccess;
use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;
use App\Service\Access\UniversityAccess;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class RegisterHandler extends BaseHandler
{
    protected $user;

    public function saveUniversityUser(Request $request): array
    {
        $code = StringHelper::clearStr($request->request->get('code'));
        $role = $id = null;

        $un = $this->em->getRepository(University::class)->findOneBy(['access_code' => $code]);
        if ($un) {
            $role = UniversityAccess::getAccessRole();
            $id = $un->id;
        }
        $fc = $this->em->getRepository(Faculty::class)->findOneBy(['access_code' => $code]);
        if ($fc) {
            $role = FacultyAccess::getAccessRole();
            $id = $fc->id;
        }

        if (!$role || !$id) {
            return [
                'status' => false,
                'error' => 'Invalid access code.'
            ];
        }
        return $this->saveUser($request, $role, $id);
    }

    public function saveUser(Request $request, string $role, $modelId = null): array
    {
        try {
            $model = new User();
            $model->load($request->request->get('User'));

            $modelId = $modelId ?: $request->request->get('id');
            $model->access_code = $this->access->createAccessCode($role, $modelId);
            $this->validateUser($model, $role);

            $model->status = User::STATUS_WAIT_EMAIL_CONFIRM;
            $model->roles = [$role];
            $model->password = (new NativePasswordEncoder())->encodePassword($model->password, null);

            $this->em->persist($model);
            $this->em->flush();

            $this->sendConfirmEmail($model);
            return [
                'status' => true,
                'code' => $model->code,
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function sendConfirmEmail(User $user): void
    {
        try {
            $test = 1;
            return;
        } catch (\Exception $e) {
            throw new \Exception('Something failed. Email not sent.');
        }
    }

    /**
     * @param User $model
     * @param string $role
     * @throws \Exception
     */
    private function validateUser(User $model, string $role): void
    {
        $existModelEmail = $this->em->getRepository(User::class)->findOneBy(['email' => $model->email]);
        if ($existModelEmail) throw new \Exception("Email $model->email has already been taken.");

        $existModelCode = $this->em->getRepository(User::class)->findOneBy(['access_code' => $model->access_code]);
        if ($existModelCode) {
            switch ($role) {
                case PartyAccess::getAccessRole():
                    throw new \Exception("This group already have administrator.");
                    break;
                case TeacherAccess::getAccessRole():
                    throw new \Exception("This teacher already register.");
                    break;
                case UniversityAccess::getAccessRole():
                case FacultyAccess::getAccessRole():
                    break;
            }
        }
    }
}