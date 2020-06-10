<?php

namespace App\Entity\Handler;

use App\Entity\User;

class UserHandler
{
    private $user;
    public function __construct(User $model)
    {
        $this->user = $model;
    }

    public function serialize()
    {
        $data = [
            'status' => $this->user->getStatusList($this->user->status),
            'email' => $this->user->email,
            'role' => $this->user->roles[0],
            'phone' => $this->user->phone,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'code' => $this->user->code,
        ];
        return $data;
    }
}