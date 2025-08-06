<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\DailyActivity;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Rab;
use App\Models\RabItem;
use App\Models\Role;
use App\Models\Scope;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing users
        $users = User::all();
        $companies = Company::all();
        $roles = Role::all();
        $scopes = Scope::all();

        if ($users->isEmpty() || $companies->isEmpty()) {
            return;
        }

        // Create sample projects
        foreach ($companies as $company) {
            $projectsCount = random_int(1, 3);
            
            for ($i = 0; $i < $projectsCount; $i++) {
                $project = Project::create([
                    'company_id' => $company->id,
                    'name' => 'Construction Project ' . chr(65 + $i),
                    'code' => 'PROJ-2024-' . str_pad((string)($company->id * 10 + $i), 3, '0', STR_PAD_LEFT),
                    'description' => 'Sample construction project for ' . $company->name,
                    'location' => 'Jakarta, Indonesia',
                    'start_date' => now()->subDays(random_int(30, 90)),
                    'end_date' => now()->addDays(random_int(180, 365)),
                    'budget' => random_int(1000000, 50000000),
                    'status' => collect(['planning', 'active', 'on_hold'])->random()
                ]);

                // Assign users to project with different roles
                $projectUsers = $users->random(random_int(2, min(4, $users->count())));
                
                foreach ($projectUsers as $index => $user) {
                    $role = $index === 0 ? $roles->where('slug', 'owner')->first() : $roles->random();
                    $scope = $role->slug === 'contractor' ? $scopes->random() : null;

                    ProjectUser::create([
                        'project_id' => $project->id,
                        'user_id' => $user->id,
                        'role_id' => $role->id,
                        'scope_id' => $scope?->id,
                        'status' => 'active',
                        'assigned_at' => now()->subDays(random_int(1, 30))
                    ]);
                }

                // Create sample RABs
                if (random_int(0, 1)) {
                    $rabsCount = random_int(1, 2);
                    for ($r = 0; $r < $rabsCount; $r++) {
                        $scope = $scopes->random();
                        $rab = Rab::create([
                            'project_id' => $project->id,
                            'scope_id' => $scope->id,
                            'uploaded_by' => $users->random()->id,
                            'title' => 'RAB ' . $scope->name . ' - ' . $project->name,
                            'description' => 'Bill of quantity for ' . $scope->name . ' work',
                            'file_path' => 'storage/rabs/sample-rab-' . $project->id . '-' . $scope->id . '.pdf',
                            'file_name' => 'RAB-' . $scope->code . '-' . $project->code . '.pdf',
                            'file_type' => 'application/pdf',
                            'file_size' => random_int(1000000, 5000000),
                            'total_amount' => random_int(500000, 10000000),
                            'version' => '1.0',
                            'status' => collect(['draft', 'review', 'approved'])->random()
                        ]);

                        // Create RAB items
                        $itemsCount = random_int(5, 15);
                        $totalAmount = 0;
                        
                        for ($item = 0; $item < $itemsCount; $item++) {
                            $quantity = random_int(1, 100);
                            $unitPrice = random_int(10000, 500000);
                            $totalPrice = $quantity * $unitPrice;
                            $totalAmount += $totalPrice;

                            RabItem::create([
                                'rab_id' => $rab->id,
                                'item_code' => sprintf('%s.%02d', $scope->code, $item + 1),
                                'description' => 'Construction work item ' . ($item + 1),
                                'unit' => collect(['m³', 'm²', 'm', 'pcs', 'kg', 'ton'])->random(),
                                'quantity' => $quantity,
                                'unit_price' => $unitPrice,
                                'total_price' => $totalPrice,
                                'sort_order' => $item + 1
                            ]);
                        }

                        // Update RAB total amount
                        $rab->update(['total_amount' => $totalAmount]);
                    }
                }

                // Create sample daily activities
                if ($project->status === 'active') {
                    $activitiesCount = random_int(3, 8);
                    
                    for ($a = 0; $a < $activitiesCount; $a++) {
                        $user = $projectUsers->random();
                        /** @var \App\Models\ProjectUser|null $projectUser */
                        $projectUser = $project->projectUsers()
                            ->where('user_id', $user->id)
                            ->first();
                        
                        DailyActivity::create([
                            'project_id' => $project->id,
                            'user_id' => $user->id,
                            'scope_id' => $projectUser ? $projectUser->scope_id : null,
                            'activity_date' => now()->subDays(random_int(1, 30)),
                            'activity_type' => collect(['Construction', 'Installation', 'Inspection', 'Planning'])->random(),
                            'description' => 'Daily work activity: ' . collect([
                                'Concrete pouring for foundation',
                                'Steel reinforcement installation',
                                'Electrical wiring installation',
                                'Plumbing system setup',
                                'Quality inspection',
                                'Safety briefing and monitoring'
                            ])->random(),
                            'manpower' => [
                                'foreman' => 1,
                                'skilled_workers' => random_int(2, 8),
                                'laborers' => random_int(3, 12)
                            ],
                            'materials' => [
                                'concrete' => random_int(5, 20) . ' m³',
                                'steel_bars' => random_int(100, 500) . ' kg',
                                'cement' => random_int(10, 50) . ' bags'
                            ],
                            'work_progress_weight' => random_int(5, 25) / 10,
                            'weather' => collect(['sunny', 'cloudy', 'rainy'])->random(),
                            'safety_notes' => 'All safety protocols followed. No incidents reported.',
                            'status' => collect(['draft', 'submitted', 'approved'])->random()
                        ]);
                    }
                }

                // Associate users with companies
                foreach ($projectUsers as $user) {
                    if (!$user->companies->contains($company->id)) {
                        $user->companies()->attach($company->id, [
                            'status' => 'active',
                            'joined_at' => now()->subDays(random_int(30, 180))
                        ]);
                    }
                }
            }
        }
    }
}