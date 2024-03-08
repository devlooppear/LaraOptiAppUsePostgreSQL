<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    /**
     * @return array
     */
    public function register(array $data)
    {
        $user = User::create($data);

        $token = $user->createToken('TokenUser')->acessToken;

        return $token;
    }
}
