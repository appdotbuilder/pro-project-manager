<?php

namespace Database\Seeders;

use App\Models\Scope;
use Illuminate\Database\Seeder;

class ScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scopes = [
            [
                'name' => 'Structural',
                'code' => 'STRUCT',
                'description' => 'Structural engineering work including foundations, columns, beams, and slabs',
                'color' => '#EF4444'
            ],
            [
                'name' => 'Architectural',
                'code' => 'ARCH',
                'description' => 'Architectural work including design, finishes, and aesthetics',
                'color' => '#3B82F6'
            ],
            [
                'name' => 'MEP (Mechanical, Electrical, Plumbing)',
                'code' => 'MEP',
                'description' => 'Mechanical, electrical, and plumbing systems',
                'color' => '#10B981'
            ],
            [
                'name' => 'Civil',
                'code' => 'CIVIL',
                'description' => 'Civil engineering work including earthwork, drainage, and infrastructure',
                'color' => '#F59E0B'
            ],
            [
                'name' => 'Interior',
                'code' => 'INTER',
                'description' => 'Interior design and finishing work',
                'color' => '#8B5CF6'
            ],
            [
                'name' => 'Landscape',
                'code' => 'LANDS',
                'description' => 'Landscaping and external environment work',
                'color' => '#059669'
            ]
        ];

        foreach ($scopes as $scopeData) {
            Scope::create($scopeData);
        }
    }
}