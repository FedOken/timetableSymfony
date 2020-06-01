<?php

namespace App\Handler\for_controller\react;

use App\Entity\User;
use App\Handler\BaseHandler;
use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class RegisterHandler extends BaseHandler
{
    protected $user;

    public function saveUser(Request $request, string $role): array
    {
        try {
            $model = new User();
            $model->load($request->request->get('User'));

            $model->access_code = $this->access->createAccessCode($role, $request->request->get('id'));
            $this->validateUser($model, $role);

            $model->status = User::STATUS_WAIT_EMAIL_CONFIRM;
            $model->roles = [$role];
            $model->password = (new NativePasswordEncoder())->encodePassword($model->password, null);

            $this->em->persist($model);
            $this->em->flush();
            return [
                'status' => true,
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
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
                default:
                    throw new \Exception("This access code already exist.");
            }

        }
        if ($existModelCode) throw new \Exception("This group already have administrator.");
    }
}