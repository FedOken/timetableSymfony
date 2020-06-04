<?php

namespace App\Controller\ReactController\Handler;

use App\Entity\User;

class ResetHandler extends BaseHandler
{
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
}