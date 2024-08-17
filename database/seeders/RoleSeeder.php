<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'level' => 1,
            ],
            [
                'name' => 'member',
                'level' => 8,
            ],
        ];

        Role::upsert(
            $roles,
            ['name'],
            ['level'],
        );
    }
}
