import React from 'react';
import { Head, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

interface User {
    id: number;
    name: string;
    email: string;
}

interface Company {
    id: number;
    name: string;
    code: string;
    projects: Project[];
}

interface Project {
    id: number;
    name: string;
    code: string;
    status: string;
    company: Company;
}

interface Activity {
    id: number;
    activity_date: string;
    description: string;
    project: Project;
    scope?: { name: string; color: string };
}

interface Stats {
    total_projects: number;
    active_projects: number;
    pending_approvals: number;
    recent_activities: number;
}



interface Scope {
    id: number;
    name: string;
    code: string;
    color: string;
}

interface Props {
    user: User;
    companies: Company[];
    recentProjects: Project[];
    recentActivities: Activity[];
    stats: Stats;
    scopes: Scope[];
    [key: string]: unknown;
}

export default function Dashboard({ 
    user, 
    companies, 
    recentProjects, 
    recentActivities, 
    stats, 
    scopes 
}: Props) {
    const [showCreateProject, setShowCreateProject] = React.useState(false);
    const [projectForm, setProjectForm] = React.useState({
        company_id: '',
        name: '',
        code: '',
        description: '',
        location: '',
        start_date: '',
        end_date: '',
        budget: ''
    });

    const handleCreateProject = (e: React.FormEvent) => {
        e.preventDefault();
        
        router.post('/', projectForm, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                setShowCreateProject(false);
                setProjectForm({
                    company_id: '',
                    name: '',
                    code: '',
                    description: '',
                    location: '',
                    start_date: '',
                    end_date: '',
                    budget: ''
                });
            }
        });
    };

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'active': return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
            case 'planning': return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
            case 'on_hold': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
            case 'completed': return 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200';
            case 'cancelled': return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
            default: return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
        }
    };

    const formatStatus = (status: string) => {
        return status.replace('_', ' ').toUpperCase();
    };

    return (
        <AppShell>
            <Head title="Project Management Dashboard" />
            
            <div className="space-y-8">
                {/* Header */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                            🏗️ Project Dashboard
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400">
                            Welcome back, {user.name}! Here's your project overview.
                        </p>
                    </div>
                    <Button 
                        onClick={() => setShowCreateProject(!showCreateProject)}
                        className="bg-blue-600 hover:bg-blue-700"
                    >
                        ➕ New Project
                    </Button>
                </div>

                {/* Quick Stats */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Total Projects
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-blue-600">
                                📊 {stats.total_projects}
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Active Projects
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-green-600">
                                ⚡ {stats.active_projects}
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Pending Approvals
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-orange-600">
                                ⏰ {stats.pending_approvals}
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Recent Activities
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-purple-600">
                                📈 {stats.recent_activities}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Create Project Form */}
                {showCreateProject && (
                    <Card>
                        <CardHeader>
                            <CardTitle>➕ Create New Project</CardTitle>
                            <CardDescription>
                                Add a new project to start managing construction activities
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <form onSubmit={handleCreateProject} className="space-y-4">
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Company *
                                        </label>
                                        <select
                                            value={projectForm.company_id}
                                            onChange={(e) => setProjectForm(prev => ({ ...prev, company_id: e.target.value }))}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            required
                                        >
                                            <option value="">Select Company</option>
                                            {companies.map(company => (
                                                <option key={company.id} value={company.id}>
                                                    {company.name}
                                                </option>
                                            ))}
                                        </select>
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Project Code *
                                        </label>
                                        <input
                                            type="text"
                                            value={projectForm.code}
                                            onChange={(e) => setProjectForm(prev => ({ ...prev, code: e.target.value }))}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            placeholder="e.g., PROJ-2024-001"
                                            required
                                        />
                                    </div>

                                    <div className="md:col-span-2">
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Project Name *
                                        </label>
                                        <input
                                            type="text"
                                            value={projectForm.name}
                                            onChange={(e) => setProjectForm(prev => ({ ...prev, name: e.target.value }))}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            placeholder="Enter project name"
                                            required
                                        />
                                    </div>

                                    <div className="md:col-span-2">
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Description
                                        </label>
                                        <textarea
                                            value={projectForm.description}
                                            onChange={(e) => setProjectForm(prev => ({ ...prev, description: e.target.value }))}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            rows={3}
                                            placeholder="Project description..."
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Location
                                        </label>
                                        <input
                                            type="text"
                                            value={projectForm.location}
                                            onChange={(e) => setProjectForm(prev => ({ ...prev, location: e.target.value }))}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            placeholder="Project location"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Budget
                                        </label>
                                        <input
                                            type="number"
                                            step="0.01"
                                            value={projectForm.budget}
                                            onChange={(e) => setProjectForm(prev => ({ ...prev, budget: e.target.value }))}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            placeholder="0.00"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Start Date
                                        </label>
                                        <input
                                            type="date"
                                            value={projectForm.start_date}
                                            onChange={(e) => setProjectForm(prev => ({ ...prev, start_date: e.target.value }))}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            End Date
                                        </label>
                                        <input
                                            type="date"
                                            value={projectForm.end_date}
                                            onChange={(e) => setProjectForm(prev => ({ ...prev, end_date: e.target.value }))}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                        />
                                    </div>
                                </div>

                                <div className="flex gap-3">
                                    <Button type="submit" className="bg-blue-600 hover:bg-blue-700">
                                        ✅ Create Project
                                    </Button>
                                    <Button 
                                        type="button" 
                                        variant="outline"
                                        onClick={() => setShowCreateProject(false)}
                                    >
                                        ❌ Cancel
                                    </Button>
                                </div>
                            </form>
                        </CardContent>
                    </Card>
                )}

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {/* Recent Projects */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                🏗️ Recent Projects
                            </CardTitle>
                            <CardDescription>
                                Your latest project activities
                            </CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            {recentProjects.length > 0 ? (
                                recentProjects.map(project => (
                                    <div key={project.id} className="flex items-center justify-between p-4 border rounded-lg dark:border-gray-700">
                                        <div className="flex-1">
                                            <h3 className="font-medium text-gray-900 dark:text-white">
                                                {project.name}
                                            </h3>
                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                {project.company.name} • {project.code}
                                            </p>
                                        </div>
                                        <span className={`px-2 py-1 text-xs font-medium rounded-full ${getStatusColor(project.status)}`}>
                                            {formatStatus(project.status)}
                                        </span>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <p>No projects found. Create your first project to get started! 🚀</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    {/* Recent Activities */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                📈 Recent Activities
                            </CardTitle>
                            <CardDescription>
                                Latest work activities
                            </CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            {recentActivities.length > 0 ? (
                                recentActivities.map(activity => (
                                    <div key={activity.id} className="flex items-center gap-3 p-4 border rounded-lg dark:border-gray-700">
                                        {activity.scope && (
                                            <div 
                                                className="w-3 h-3 rounded-full flex-shrink-0"
                                                style={{ backgroundColor: activity.scope.color }}
                                            />
                                        )}
                                        <div className="flex-1 min-w-0">
                                            <p className="text-sm text-gray-900 dark:text-white truncate">
                                                {activity.description}
                                            </p>
                                            <p className="text-xs text-gray-600 dark:text-gray-400">
                                                {activity.project.name} • {new Date(activity.activity_date).toLocaleDateString()}
                                            </p>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <p>No recent activities. Start recording daily work to track progress! 📋</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>
                </div>

                {/* Scopes Overview */}
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2">
                            🔧 Work Scopes
                        </CardTitle>
                        <CardDescription>
                            Available project scopes for work organization
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                            {scopes.map(scope => (
                                <div key={scope.id} className="flex items-center gap-2 p-3 border rounded-lg dark:border-gray-700">
                                    <div 
                                        className="w-4 h-4 rounded-full flex-shrink-0"
                                        style={{ backgroundColor: scope.color }}
                                    />
                                    <div className="min-w-0">
                                        <p className="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {scope.name}
                                        </p>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">
                                            {scope.code}
                                        </p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}