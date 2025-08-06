<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => 'PT. Pembangunan Utama',
                'code' => 'PU001',
                'description' => 'Leading construction and development company',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'phone' => '+62-21-1234567',
                'email' => 'info@pembangun-utama.co.id',
                'status' => 'active'
            ],
            [
                'name' => 'CV. Karya Konstruksi',
                'code' => 'KK002',
                'description' => 'Specialized in structural and civil engineering',
                'address' => 'Jl. Gatot Subroto No. 456, Jakarta Selatan',
                'phone' => '+62-21-2345678',
                'email' => 'contact@karya-konstruksi.co.id',
                'status' => 'active'
            ],
            [
                'name' => 'PT. Arsitektur Modern',
                'code' => 'AM003',
                'description' => 'Architectural design and consulting services',
                'address' => 'Jl. Thamrin No. 789, Jakarta Pusat',
                'phone' => '+62-21-3456789',
                'email' => 'hello@arsitektur-modern.co.id',
                'status' => 'active'
            ]
        ];

        foreach ($companies as $companyData) {
            Company::create($companyData);
        }
    }
}