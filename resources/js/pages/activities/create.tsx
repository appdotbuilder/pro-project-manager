import React from 'react';
import { Head, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

interface Project {
    id: number;
    name: string;
    code: string;
}

interface Scope {
    id: number;
    name: string;
    code: string;
    color: string;
}

interface Props {
    projects: Project[];
    scopes: Scope[];
    [key: string]: unknown;
}

export default function CreateActivity({ projects, scopes }: Props) {
    const [activityForm, setActivityForm] = React.useState({
        project_id: '',
        scope_id: '',
        activity_date: new Date().toISOString().split('T')[0],
        activity_type: '',
        description: '',
        manpower: {
            foreman: '',
            skilled_workers: '',
            laborers: ''
        },
        materials: {
            concrete: '',
            steel_bars: '',
            cement: '',
            other: ''
        },
        work_progress_weight: '',
        weather: 'sunny',
        safety_notes: '',
        notes: ''
    });

    const [photos, setPhotos] = React.useState<FileList | null>(null);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        const formData = new FormData();
        
        // Add form fields
        Object.entries(activityForm).forEach(([key, value]) => {
            if (typeof value === 'object' && value !== null) {
                formData.append(key, JSON.stringify(value));
            } else {
                formData.append(key, value.toString());
            }
        });
        
        // Add photos
        if (photos) {
            Array.from(photos).forEach((photo, index) => {
                formData.append(`photos[${index}]`, photo);
            });
        }

        router.post('/activities', formData, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                // Reset form
                setActivityForm({
                    project_id: '',
                    scope_id: '',
                    activity_date: new Date().toISOString().split('T')[0],
                    activity_type: '',
                    description: '',
                    manpower: {
                        foreman: '',
                        skilled_workers: '',
                        laborers: ''
                    },
                    materials: {
                        concrete: '',
                        steel_bars: '',
                        cement: '',
                        other: ''
                    },
                    work_progress_weight: '',
                    weather: 'sunny',
                    safety_notes: '',
                    notes: ''
                });
                setPhotos(null);
            }
        });
    };

    const updateManpower = (field: string, value: string) => {
        setActivityForm(prev => ({
            ...prev,
            manpower: {
                ...prev.manpower,
                [field]: value
            }
        }));
    };

    const updateMaterials = (field: string, value: string) => {
        setActivityForm(prev => ({
            ...prev,
            materials: {
                ...prev.materials,
                [field]: value
            }
        }));
    };

    return (
        <AppShell>
            <Head title="Record Daily Activity" />
            
            <div className="space-y-6">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                        📋 Record Daily Activity
                    </h1>
                    <p className="text-gray-600 dark:text-gray-400">
                        Document your daily work progress with photos and details
                    </p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>🚧 Activity Details</CardTitle>
                        <CardDescription>
                            Fill in the work activity information for today
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-6">
                            {/* Project and Basic Info */}
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Project *
                                    </label>
                                    <select
                                        value={activityForm.project_id}
                                        onChange={(e) => setActivityForm(prev => ({ ...prev, project_id: e.target.value }))}
                                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                        required
                                    >
                                        <option value="">Select Project</option>
                                        {projects.map(project => (
                                            <option key={project.id} value={project.id}>
                                                {project.name} ({project.code})
                                            </option>
                                        ))}
                                    </select>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Work Scope *
                                    </label>
                                    <select
                                        value={activityForm.scope_id}
                                        onChange={(e) => setActivityForm(prev => ({ ...prev, scope_id: e.target.value }))}
                                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                        required
                                    >
                                        <option value="">Select Scope</option>
                                        {scopes.map(scope => (
                                            <option key={scope.id} value={scope.id}>
                                                {scope.name} ({scope.code})
                                            </option>
                                        ))}
                                    </select>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Activity Date *
                                    </label>
                                    <input
                                        type="date"
                                        value={activityForm.activity_date}
                                        onChange={(e) => setActivityForm(prev => ({ ...prev, activity_date: e.target.value }))}
                                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                        required
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Activity Type *
                                    </label>
                                    <select
                                        value={activityForm.activity_type}
                                        onChange={(e) => setActivityForm(prev => ({ ...prev, activity_type: e.target.value }))}
                                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                        required
                                    >
                                        <option value="">Select Type</option>
                                        <option value="Construction">🔨 Construction</option>
                                        <option value="Installation">🔧 Installation</option>
                                        <option value="Inspection">🔍 Inspection</option>
                                        <option value="Planning">📋 Planning</option>
                                        <option value="Testing">🧪 Testing</option>
                                        <option value="Maintenance">⚙️ Maintenance</option>
                                    </select>
                                </div>
                            </div>

                            {/* Description */}
                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Activity Description *
                                </label>
                                <textarea
                                    value={activityForm.description}
                                    onChange={(e) => setActivityForm(prev => ({ ...prev, description: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                    rows={4}
                                    placeholder="Describe the work activities performed today..."
                                    required
                                />
                            </div>

                            {/* Manpower Section */}
                            <div>
                                <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-3">
                                    👥 Manpower
                                </h3>
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Foreman
                                        </label>
                                        <input
                                            type="number"
                                            min="0"
                                            value={activityForm.manpower.foreman}
                                            onChange={(e) => updateManpower('foreman', e.target.value)}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            placeholder="0"
                                        />
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Skilled Workers
                                        </label>
                                        <input
                                            type="number"
                                            min="0"
                                            value={activityForm.manpower.skilled_workers}
                                            onChange={(e) => updateManpower('skilled_workers', e.target.value)}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            placeholder="0"
                                        />
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Laborers
                                        </label>
                                        <input
                                            type="number"
                                            min="0"
                                            value={activityForm.manpower.laborers}
                                            onChange={(e) => updateManpower('laborers', e.target.value)}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            placeholder="0"
                                        />
                                    </div>
                                </div>
                            </div>

                            {/* Materials Section */}
                            <div>
                                <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-3">
                                    🧱 Materials Used
                                </h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Concrete (m³)
                                        </label>
                                        <input
                                            type="text"
                                            value={activityForm.materials.concrete}
                                            onChange={(e) => updateMaterials('concrete', e.target.value)}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            placeholder="e.g., 15 m³"
                                        />
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Steel Bars (kg)
                                        </label>
                                        <input
                                            type="text"
                                            value={activityForm.materials.steel_bars}
                                            onChange={(e) => updateMaterials('steel_bars', e.target.value)}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            placeholder="e.g., 250 kg"
                                        />
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Cement (bags)
                                        </label>
                                        <input
                                            type="text"
                                            value={activityForm.materials.cement}
                                            onChange={(e) => updateMaterials('cement', e.target.value)}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            placeholder="e.g., 30 bags"
                                        />
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Other Materials
                                        </label>
                                        <input
                                            type="text"
                                            value={activityForm.materials.other}
                                            onChange={(e) => updateMaterials('other', e.target.value)}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                            placeholder="e.g., Sand, Gravel, etc."
                                        />
                                    </div>
                                </div>
                            </div>

                            {/* Progress and Conditions */}
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Work Progress Weight (%)
                                    </label>
                                    <input
                                        type="number"
                                        step="0.1"
                                        min="0"
                                        max="100"
                                        value={activityForm.work_progress_weight}
                                        onChange={(e) => setActivityForm(prev => ({ ...prev, work_progress_weight: e.target.value }))}
                                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                        placeholder="0.0"
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Weather Conditions
                                    </label>
                                    <select
                                        value={activityForm.weather}
                                        onChange={(e) => setActivityForm(prev => ({ ...prev, weather: e.target.value }))}
                                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                    >
                                        <option value="sunny">☀️ Sunny</option>
                                        <option value="cloudy">☁️ Cloudy</option>
                                        <option value="rainy">🌧️ Rainy</option>
                                        <option value="stormy">⛈️ Stormy</option>
                                    </select>
                                </div>
                            </div>

                            {/* Photos */}
                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    📷 Activity Photos
                                </label>
                                <input
                                    type="file"
                                    multiple
                                    accept="image/*"
                                    onChange={(e) => setPhotos(e.target.files)}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                />
                                <p className="text-xs text-gray-500 mt-1">
                                    Select multiple photos to document your work progress
                                </p>
                            </div>

                            {/* Safety Notes */}
                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    🦺 Safety & K3 Notes
                                </label>
                                <textarea
                                    value={activityForm.safety_notes}
                                    onChange={(e) => setActivityForm(prev => ({ ...prev, safety_notes: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                    rows={3}
                                    placeholder="Safety observations, incidents, or compliance notes..."
                                />
                            </div>

                            {/* Additional Notes */}
                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    📝 Additional Notes
                                </label>
                                <textarea
                                    value={activityForm.notes}
                                    onChange={(e) => setActivityForm(prev => ({ ...prev, notes: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                                    rows={3}
                                    placeholder="Any additional observations or remarks..."
                                />
                            </div>

                            {/* Submit Buttons */}
                            <div className="flex flex-col sm:flex-row gap-3">
                                <Button type="submit" className="bg-blue-600 hover:bg-blue-700 flex-1 sm:flex-none">
                                    💾 Save Activity
                                </Button>
                                <Button type="button" variant="outline" className="flex-1 sm:flex-none">
                                    📋 Save as Draft
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}