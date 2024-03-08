<?php

// app/Services/PersonalAccessTokenService.php

namespace App\Services;

use App\Repositories\PersonalAccessTokenRepository;

class PersonalAccessTokenService
{
    protected $tokenRepository;

    public function __construct(PersonalAccessTokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function createToken(array $data)
    {
        return $this->tokenRepository->create($data);
    }
}
