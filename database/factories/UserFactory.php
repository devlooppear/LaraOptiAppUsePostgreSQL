<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->setupEnvironment();

        return [
            'id' => $this->generateUserId(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => $this->getRandomRoleId(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * After creating the user, create a personal access token for the user.
     */
    protected function createAccessToken(User $user): string
    {
        Passport::actingAs($user);
        $tokenResult = $user->createToken('Personal Access Token');

        return $tokenResult->accessToken;
    }

    /**
     * Setup the environment by installing Passport and creating a role if necessary.
     */
    private function setupEnvironment(): void
    {
        Artisan::call('passport:install', ['--force' => true]);

        // Create a role if none exists
        if (Role::count() === 0) {
            Role::factory()->create();
        }
    }

    /**
     * Generate a unique user ID using Redis INCR.
     */
    private function generateUserId(): int
    {
        return Redis::incr('user_ids');
    }

    /**
     * Get a random Role ID.
     */
    private function getRandomRoleId(): int
    {
        return Role::inRandomOrder()->value('id');
    }
}
