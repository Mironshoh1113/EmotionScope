@extends('admin.layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('admin.user_details') }}</h1>
                    <p class="text-sm text-gray-600">{{ $user->name }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.users') }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- User Information -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- User Details Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-2xl font-medium text-gray-600">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.registration_date') }}:</span>
                            <span class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.last_login') }}:</span>
                            <span class="text-sm text-gray-900">
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->format('M d, Y H:i') }}
                                @else
                                    {{ __('admin.never_logged_in') }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.status') }}:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_blocked ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->is_blocked ? __('admin.blocked') : __('admin.active') }}
                            </span>
                        </div>
                        @if($user->is_admin)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">{{ __('admin.admin_rights') }}:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ __('admin.is_admin') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 text-center transition-colors">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                {{ __('admin.edit') }}
                            </a>
                            <form method="POST" action="{{ route('admin.users.block', $user->id) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full {{ $user->is_blocked ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($user->is_blocked)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                        @endif
                                    </svg>
                                    {{ $user->is_blocked ? __('admin.unblock') : __('admin.block') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Statistics -->
            <div class="lg:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Quick Stats -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('admin.user_statistics') }}</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ __('admin.total_projects') }}:</span>
                                <span class="text-lg font-semibold text-gray-900">{{ $user->projects()->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ __('admin.active_projects') }}:</span>
                                <span class="text-lg font-semibold text-gray-900">{{ $user->projects()->where('is_active', true)->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ __('admin.total_requests') }}:</span>
                                <span class="text-lg font-semibold text-gray-900">{{ $user->requests()->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ __('admin.successful_requests') }}:</span>
                                <span class="text-lg font-semibold text-green-600">{{ $user->requests()->where('response_code', '>=', 200)->where('response_code', '<', 300)->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ __('admin.average_response_time') }}:</span>
                                <span class="text-lg font-semibold text-blue-600">{{ round($user->requests()->whereNotNull('response_time')->avg('response_time') ?? 0, 2) }}ms</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('admin.quick_actions') }}</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.users.projects', $user->id) }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <span class="text-sm font-medium text-blue-900">{{ __('admin.user_projects') }}</span>
                            </a>
                            <a href="{{ route('admin.users.requests', $user->id) }}" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-sm font-medium text-purple-900">{{ __('admin.user_requests') }}</span>
                            </a>
                            <a href="{{ route('admin.users.stats', $user->id) }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="text-sm font-medium text-green-900">{{ __('admin.user_statistics') }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Projects -->
                <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('admin.recent_projects') }}</h3>
                    </div>
                    <div class="p-6">
                        @if($user->projects()->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->projects()->latest()->take(5)->get() as $project)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-green-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $project->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $project->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if($project->is_active)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ __('admin.active') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ __('admin.inactive') }}
                                                </span>
                                            @endif
                                            <span class="text-xs text-gray-500">{{ $project->requests()->count() }} {{ __('admin.requests') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">{{ __('admin.no_projects_found') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 