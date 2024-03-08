<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Redis;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        $redisKey = 'role_ids';
        $id = Redis::incr($redisKey);

        return [
            'id' => $id,
            'name' => $this->faker->unique()->randomElement(['User', 'Librarian']),
        ];
    }
}
