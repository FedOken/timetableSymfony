<?php

namespace App\Controller\API\Handler;

use App\Entity\Cabinet;
use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Role;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\User;
use App\Helper\ArrayHelper;
use App\Repository\ScheduleRepository;
use App\Service\Access\AccessService;
use App\Service\Access\FacultyAccess;
use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;
use App\Service\Access\UniversityAccess;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class UserHandler extends BaseHandler
{
    public function getUserData(): array
    {
        try {
            /**@var User $user */
            $user = $this->security->getUser();
            $data = $user ? $user->handler->serialize() : [];
            return [
                'status' => true,
                'data' => $data
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function getUserRelation(): array
    {
        try {
            /**@var User $user */
            $user = $this->security->getUser();
            $data = $this->getRelations($user);
            return [
                'status' => true,
                'data' => $data
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function updateModel(): array
    {
        try {
            /**@var User $user */
            $user = $this->security->getUser();
            $user->load($this->request->request->get('User'));
            $this->em->persist($user);
            $this->em->flush();
            return [
                'status' => true,
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function updatePassword(): array
    {
        try {
            $password = $this->request->request->get('password');
            $repeatPassword = $this->request->request->get('repeatPassword');
            if ($password !== $repeatPassword) throw new Exception('Password mismatch');

            $encoder = new NativePasswordEncoder();
            $password_encode = $encoder->encodePassword($password, null);

            /**@var User $user */
            $user = $this->security->getUser();
            $user->setPassword($password_encode);

            $this->em->persist($user);
            $this->em->flush();
            return [
                'status' => true,
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function saveUserByCode(): array
    {
        try {
            $code = $this->strService->clearStr($this->request->request->get('code'));
            $role = $id = null;

            $un = $this->em->getRepository(University::class)->findOneBy(['access_code' => $code, 'enable' => 1]);
            if ($un) {
                $role = UniversityAccess::getAccessRole();
                $id = $un->id;
            }
            $fc = $this->em->getRepository(Faculty::class)->findOneBy(['access_code' => $code]);
            if ($fc) {
                $role = FacultyAccess::getAccessRole();
                $id = $fc->id;
            }
            $tchr = $this->em->getRepository(Teacher::class)->findOneBy(['access_code' => $code]);
            if ($tchr) {
                $role = TeacherAccess::getAccessRole();
                $id = $tchr->id;
            }
            if (!$role || !$id) throw new Exception('Invalid access code.');
            return $this->saveUser($role, $id);
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function saveUser(string $role, $modelId = null): array
    {
        try {
            $model = new User();
            $model->load($this->request->request->get('User'));

            $modelId = $modelId ?: $this->request->request->get('id');
            $model->access_code = $this->access->createAccessCode($role, $modelId);
            $this->validateUser($model, $role);

            $model->status = User::STATUS_WAIT_EMAIL_CONFIRM;
            $model->roles = [$role];
            $model->password = (new NativePasswordEncoder())->encodePassword($model->password, null);
            $model->check_email_code = $this->strService->genRanStrEntity(10, User::class, 'check_email_code');
            $model->role_label = $this->em->getRepository(Role::class)->findOneBy(['name' => $role]);
            switch ($role) {
                case UniversityAccess::getAccessRole():
                    $model->university = $this->em->getRepository(University::class)->find($modelId);
                    break;
                case FacultyAccess::getAccessRole():
                    $model->faculty = $this->em->getRepository(Faculty::class)->find($modelId);
                    break;
                case TeacherAccess::getAccessRole():
                    $model->teacher = $this->em->getRepository(Teacher::class)->find($modelId);
                    break;
                case PartyAccess::getAccessRole():
                    $model->party = $this->em->getRepository(Party::class)->find($modelId);
                    break;
            }

            $this->em->persist($model);
            $this->em->flush();

            if ($this->sendConfirmEmailStep2($model)) {
                return [
                    'status' => true,
                    'data' => $model->code,
                ];
            } else {
                throw new Exception('Something failed. Email not sent.');
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function sendConfirmEmailStep1(string $code): array
    {
        try {
            $user = $this->em->getRepository(User::class)->findOneBy(['code' => $code]);
            if (!$user) throw new Exception('User not found!');

            $data = $this->sendConfirmEmailStep2($user);
            return [
                'status' => true,
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function resetPassword(): array
    {
        try {
            $email = $this->request->request->get('email');
            $model =$this->em->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$model) throw new \Exception("User with email $email not found.");

            /**@var $model User */
            $model->reset_password_code = $this->strService->genRanStrEntity(10, User::class, 'reset_password_code');
            $this->em->persist($model);
            $this->em->flush();

            if ($this->sendResetEmail()) {
                return ['status' => true];
            }
            return ['status' => false];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }





    private function sendResetEmail(): bool
    {
        return true;
    }

    private function sendConfirmEmailStep2($user): bool
    {
        return true;
    }

    private function getRelations($user): array
    {
        $data = [];
        $accessObj = $this->access->getAccessObject($user);
        /** @var ScheduleRepository $facRepo */
        $schRepo = $this->em->getRepository(Schedule::class);
        $schs = $schRepo->findBy(['id' => $accessObj->getAccessibleScheduleIds()]);

        /** @var University[] $models */
        $models = $this->em->getRepository(University::class)->findBy(['id' => $accessObj->getAccessibleUniversityIds()]);
        foreach ($models as $model) {
            if (!$model) continue;
            $data['universities'][] = [
                'id' => $model->id,
                'name' => $model->name_full,
            ];
        }
        /** @var Faculty[] $models */
        $models = $this->em->getRepository(Faculty::class)->findBy(['id' => $accessObj->getAccessibleFacultyIds()]);
        foreach ($models as $model) {
            if (!$model) continue;
            $data['faculties'][] = [
                'id' => $model->id,
                'name' => $model->name_full,
            ];
        }
        /** @var Party[] $models */
        $models = ArrayHelper::getColumn($schs, 'party');
        $models = array_unique($models);
        foreach ($models as $model) {
            if (!$model) continue;
            $data['parties'][] = [
                'id' => $model->id,
                'name' => $model->name,
            ];
        }
        /** @var Cabinet[] $models */
        $models = ArrayHelper::getColumn($schs, 'cabinet');
        $models = array_unique($models);
        foreach ($models as $model) {
            if (!$model) continue;
            $data['cabinets'][] = [
                'id' => $model->id,
                'name' => $model->name,
            ];
        }
        /** @var Teacher[] $models */
        $models = ArrayHelper::getColumn($schs, 'teacher');
        $models = array_unique($models);
        foreach ($models as $model) {
            if (!$model) continue;
            $data['teachers'][] = [
                'id' => $model->id,
                'name' => $model->name,
            ];
        }
        return $data;
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
