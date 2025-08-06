<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\DailyActivity;
use App\Models\DailyReport;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Rab;
use App\Models\Role;
use App\Models\Scope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectManagementController extends Controller
{
    /**
     * Display the project management dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            // For unauthenticated users, show welcome page with app features
            return Inertia::render('welcome', [
                'features' => [
                    [
                        'icon' => '🏢',
                        'title' => 'Multi-Company Support',
                        'description' => 'Manage multiple companies and their projects in one place'
                    ],
                    [
                        'icon' => '👥',
                        'title' => 'Role-Based Access',
                        'description' => 'Assign specific roles (Owner, MK, Contractor, Planner, QS) with defined permissions'
                    ],
                    [
                        'icon' => '📊',
                        'title' => 'Bill of Quantity (RAB)',
                        'description' => 'Upload and manage RAB documents for different project scopes'
                    ],
                    [
                        'icon' => '📱',
                        'title' => 'Mobile-Friendly',
                        'description' => 'Record daily activities and upload photos directly from mobile devices'
                    ],
                    [
                        'icon' => '📈',
                        'title' => 'Daily Reports',
                        'description' => 'Generate comprehensive daily reports with progress tracking'
                    ],
                    [
                        'icon' => '🔧',
                        'title' => 'Scope Management',
                        'description' => 'Organize work by scopes: Structural, Architectural, MEP, and more'
                    ]
                ]
            ]);
        }

        // Get user's companies and projects
        $companies = $user->companies()->with(['projects' => function ($query) {
            $query->latest()->limit(5);
        }])->get();

        // Get recent projects the user is involved in
        $recentProjects = Project::whereHas('projectUsers', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('status', 'active');
        })->with(['company', 'projectUsers.role', 'projectUsers.scope'])
        ->latest()
        ->limit(6)
        ->get();

        // Get recent activities
        $recentActivities = DailyActivity::where('user_id', $user->id)
            ->with(['project', 'scope'])
            ->latest()
            ->limit(5)
            ->get();

        // Get pending approvals (if user has approval permissions)
        $pendingRabs = Rab::whereHas('project.projectUsers', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'review')->count();

        $pendingActivities = DailyActivity::whereHas('project.projectUsers', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'submitted')->count();

        // Get statistics
        $stats = [
            'total_projects' => $recentProjects->count(),
            'active_projects' => $recentProjects->where('status', 'active')->count(),
            'pending_approvals' => $pendingRabs + $pendingActivities,
            'recent_activities' => $recentActivities->count()
        ];

        return Inertia::render('project-management/dashboard', [
            'user' => $user,
            'companies' => $companies,
            'recentProjects' => $recentProjects,
            'recentActivities' => $recentActivities,
            'stats' => $stats,
            'roles' => Role::all(),
            'scopes' => Scope::all()
        ]);
    }

    /**
     * Store a new project.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:projects,code',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $project = Project::create($request->all());

        // Assign the current user as the project owner
        ProjectUser::create([
            'project_id' => $project->id,
            'user_id' => Auth::id(),
            'role_id' => Role::where('slug', 'owner')->first()->id,
            'status' => 'active',
            'assigned_at' => now()
        ]);

        return back()->with('success', 'Project created successfully!');
    }
}