<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roleSeeder = new RoleSeeder();
        $roleSeeder->run();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role_id' => Role::where('name', 'admin')->first()->id,
        ]);

        User::factory(30)->create();
    }
}
