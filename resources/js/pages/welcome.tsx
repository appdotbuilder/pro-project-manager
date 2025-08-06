import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

interface Feature {
    icon: string;
    title: string;
    description: string;
}

interface Props {
    features?: Feature[];
    [key: string]: unknown;
}

export default function Welcome({ features = [] }: Props) {
    const { auth } = usePage<SharedData>().props;

    const defaultFeatures: Feature[] = [
        {
            icon: '🏢',
            title: 'Multi-Company Support',
            description: 'Manage multiple companies and their projects in one place'
        },
        {
            icon: '👥',
            title: 'Role-Based Access',
            description: 'Assign specific roles (Owner, MK, Contractor, Planner, QS) with defined permissions'
        },
        {
            icon: '📊',
            title: 'Bill of Quantity (RAB)',
            description: 'Upload and manage RAB documents for different project scopes'
        },
        {
            icon: '📱',
            title: 'Mobile-Friendly',
            description: 'Record daily activities and upload photos directly from mobile devices'
        },
        {
            icon: '📈',
            title: 'Daily Reports',
            description: 'Generate comprehensive daily reports with progress tracking'
        },
        {
            icon: '🔧',
            title: 'Scope Management',
            description: 'Organize work by scopes: Structural, Architectural, MEP, and more'
        }
    ];

    const displayFeatures = features.length > 0 ? features : defaultFeatures;

    return (
        <>
            <Head title="ProManage - Professional Project Management">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
                {/* Navigation */}
                <nav className="relative z-10 flex items-center justify-between p-6 lg:px-8">
                    <div className="flex items-center space-x-2">
                        <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span className="text-white font-bold text-sm">PM</span>
                        </div>
                        <span className="text-xl font-bold text-gray-900 dark:text-white">ProManage</span>
                    </div>
                    
                    <div className="flex items-center space-x-4">
                        {auth.user ? (
                            <Link
                                href={route('dashboard')}
                                className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors duration-200"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <div className="flex items-center space-x-3">
                                <Link
                                    href={route('login')}
                                    className="text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg transition-colors duration-200 dark:text-gray-300 dark:hover:text-white"
                                >
                                    Log in
                                </Link>
                                <Link
                                    href={route('register')}
                                    className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors duration-200"
                                >
                                    Get Started
                                </Link>
                            </div>
                        )}
                    </div>
                </nav>

                {/* Hero Section */}
                <div className="relative px-6 lg:px-8">
                    <div className="mx-auto max-w-3xl pt-20 pb-32 sm:pt-48 sm:pb-40">
                        <div className="text-center">
                            <h1 className="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl dark:text-white">
                                🏗️ Professional{' '}
                                <span className="text-blue-600">Project Management</span>
                            </h1>
                            <p className="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                                Streamline construction project management with comprehensive tools for companies, contractors, and project teams. 
                                Manage RAB documents, track daily activities, and generate detailed reports - all in one professional platform.
                            </p>
                            <div className="mt-10 flex items-center justify-center gap-x-6">
                                {!auth.user && (
                                    <>
                                        <Link
                                            href={route('register')}
                                            className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg"
                                        >
                                            Start Your Project 🚀
                                        </Link>
                                        <Link
                                            href={route('login')}
                                            className="text-gray-900 hover:text-blue-600 text-lg font-semibold transition-colors duration-200 dark:text-gray-300 dark:hover:text-blue-400"
                                        >
                                            Sign In <span aria-hidden="true">→</span>
                                        </Link>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>

                    {/* Features Grid */}
                    <div className="mx-auto max-w-7xl px-6 lg:px-8 pb-20">
                        <div className="mx-auto max-w-2xl text-center">
                            <h2 className="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl dark:text-white">
                                ⚡ Powerful Features
                            </h2>
                            <p className="mt-4 text-lg text-gray-600 dark:text-gray-300">
                                Everything you need to manage construction projects professionally
                            </p>
                        </div>
                        
                        <div className="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                            {displayFeatures.map((feature, index) => (
                                <div
                                    key={index}
                                    className="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700"
                                >
                                    <div className="text-4xl mb-4">{feature.icon}</div>
                                    <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                        {feature.title}
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300 leading-relaxed">
                                        {feature.description}
                                    </p>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Call to Action */}
                    {!auth.user && (
                        <div className="bg-blue-600 dark:bg-blue-700 rounded-3xl mx-auto max-w-4xl p-12 text-center mb-20">
                            <h2 className="text-3xl font-bold text-white mb-4">
                                🎯 Ready to Transform Your Project Management?
                            </h2>
                            <p className="text-blue-100 text-lg mb-8">
                                Join construction professionals who trust ProManage for their project success
                            </p>
                            <Link
                                href={route('register')}
                                className="bg-white hover:bg-gray-100 text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg"
                            >
                                Create Free Account ✨
                            </Link>
                        </div>
                    )}
                </div>

                {/* Footer */}
                <footer className="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    <div className="mx-auto max-w-7xl px-6 py-12 lg:px-8">
                        <div className="text-center">
                            <div className="flex items-center justify-center space-x-2 mb-4">
                                <div className="w-6 h-6 bg-blue-600 rounded flex items-center justify-center">
                                    <span className="text-white font-bold text-xs">PM</span>
                                </div>
                                <span className="text-lg font-bold text-gray-900 dark:text-white">ProManage</span>
                            </div>
                            <p className="text-gray-600 dark:text-gray-400">
                                Professional construction project management platform
                            </p>
                            <p className="mt-2 text-sm text-gray-500 dark:text-gray-500">
                                Built with ❤️ for construction professionals
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}