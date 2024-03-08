<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the highest existing ID
        $maxId = Role::max('id') ?? 0;

        // Specify the specific IDs for 'User' and 'Librarian'
        $roleIds = ['User' => $maxId + 1, 'Librarian' => $maxId + 2];

        // Create roles using the specified IDs
        foreach ($roleIds as $name => $id) {
            Role::create(['id' => $id, 'name' => $name]);
        }
    }
}
