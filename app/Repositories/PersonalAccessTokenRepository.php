<?php

// app/Repositories/PersonalAccessTokenRepository.php

namespace App\Repositories;

use App\Models\PersonalAccessToken;

class PersonalAccessTokenRepository
{
    public function create(array $data)
    {
        return PersonalAccessToken::create($data);
    }
}
