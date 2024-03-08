<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Redis;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        $permissionId = Redis::incr('permission_ids');

        return [
            'id' => $permissionId,
            'name' => $this->faker->unique()->word,
        ];
    }
}
