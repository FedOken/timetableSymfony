<?php

namespace App\Controller\ReactController\Handler;

use App\Entity\Cabinet;
use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\User;
use Exception;
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

    private function getRelations($user): array
    {
        $data = [];
        $accessObj = $this->access->getAccessObject($user);

        /** @var University[] $models */
        $models = $this->em->getRepository(University::class)->findBy(['id' => $accessObj->getAccessibleUniversityIds()]);
        foreach ($models as $model) {
            $data['universities'][] = [
                'id' => $model->id,
                'name' => $model->name_full,
            ];
        }
        /** @var Faculty[] $models */
        $models = $this->em->getRepository(Faculty::class)->findBy(['id' => $accessObj->getAccessibleFacultyIds()]);
        foreach ($models as $model) {
            $data['faculties'][] = [
                'id' => $model->id,
                'name' => $model->name_full,
            ];
        }
        /** @var Party[] $models */
        $models = $this->em->getRepository(Party::class)->findBy(['id' => $accessObj->getAccessiblePartyIds()]);
        foreach ($models as $model) {
            $data['parties'][] = [
                'id' => $model->id,
                'name' => $model->name,
            ];
        }
        /** @var Cabinet[] $models */
        $models = $this->em->getRepository(Cabinet::class)->findBy(['id' => $accessObj->getAccessibleCabinetIds()]);
        foreach ($models as $model) {
            $data['cabinets'][] = [
                'id' => $model->id,
                'name' => $model->name,
            ];
        }
        /** @var Teacher[] $models */
        $models = $this->em->getRepository(Teacher::class)->findBy(['id' => $accessObj->getAccessibleTeacherIds()]);
        foreach ($models as $model) {
            $data['teachers'][] = [
                'id' => $model->id,
                'name' => $model->name,
            ];
        }
        return $data;
    }
}
