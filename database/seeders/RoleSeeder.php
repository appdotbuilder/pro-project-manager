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
        $roles = [
            [
                'name' => 'Owner',
                'slug' => 'owner',
                'description' => 'Project owner with full access to all project features',
                'permissions' => [
                    'create_project',
                    'edit_project',
                    'delete_project',
                    'manage_users',
                    'approve_rabs',
                    'approve_activities',
                    'view_reports',
                    'generate_reports'
                ]
            ],
            [
                'name' => 'MK (Management Contractor)',
                'slug' => 'mk',
                'description' => 'Management contractor responsible for project oversight',
                'permissions' => [
                    'view_project',
                    'manage_contractors',
                    'approve_rabs',
                    'approve_activities',
                    'view_reports',
                    'generate_reports'
                ]
            ],
            [
                'name' => 'Contractor',
                'slug' => 'contractor',
                'description' => 'Contractor responsible for specific scope of work',
                'permissions' => [
                    'view_project',
                    'upload_rabs',
                    'record_activities',
                    'upload_photos',
                    'view_own_reports'
                ]
            ],
            [
                'name' => 'Planner',
                'slug' => 'planner',
                'description' => 'Project planner responsible for scheduling and planning',
                'permissions' => [
                    'view_project',
                    'edit_schedule',
                    'view_reports',
                    'generate_reports'
                ]
            ],
            [
                'name' => 'QS (Quantity Surveyor)',
                'slug' => 'qs',
                'description' => 'Quantity surveyor responsible for cost management',
                'permissions' => [
                    'view_project',
                    'manage_rabs',
                    'approve_rabs',
                    'view_cost_reports',
                    'generate_cost_reports'
                ]
            ]
        ];

        foreach ($roles as $roleData) {
            Role::create($roleData);
        }
    }
}