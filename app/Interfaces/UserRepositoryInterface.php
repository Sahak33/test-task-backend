<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getUser($userId);
    public function storeUser(array $data);
}
