<?php

namespace Database\Seeders;

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
        $this->call([
            RoleSeeder::class,
            ScopeSeeder::class,
            CompanySeeder::class,
        ]);

        // Create sample users
        User::factory()->create([
            'name' => 'John Doe (Project Owner)',
            'email' => 'john@example.com',
        ]);

        User::factory()->create([
            'name' => 'Jane Smith (MK Manager)',
            'email' => 'jane@example.com',
        ]);

        User::factory()->create([
            'name' => 'Mike Wilson (Contractor)',
            'email' => 'mike@example.com',
        ]);

        User::factory()->create([
            'name' => 'Sarah Chen (QS)',
            'email' => 'sarah@example.com',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed project management data
        $this->call([
            ProjectManagementSeeder::class,
        ]);
    }
}
