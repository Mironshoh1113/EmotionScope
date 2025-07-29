@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('admin.profile') }}</h1>
                <p class="mt-2 text-sm text-gray-600">{{ __('admin.profile_description') }}</p>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center">
                        <span class="text-2xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <div class="mt-2 flex items-center space-x-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $user->is_admin ? __('admin.administrator') : __('admin.user') }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_blocked ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ $user->is_blocked ? __('admin.blocked') : __('admin.active') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('admin.basic_information') }}</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('admin.name') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('admin.email') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('admin.registration_date') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('admin.last_login') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : __('admin.never') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('admin.account_information') }}</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('admin.balance') }}</label>
                            <p class="mt-1 text-sm text-gray-900">${{ number_format($user->balance, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('admin.request_limit') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ number_format($user->request_limit) }} {{ __('admin.requests') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('admin.requests_used') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ number_format($user->requests_used) }} {{ __('admin.requests') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('admin.usage_percentage') }}</label>
                            <div class="mt-1">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, ($user->requests_used / max(1, $user->request_limit)) * 100) }}%"></div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">{{ number_format(($user->requests_used / max(1, $user->request_limit)) * 100, 1) }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.profile.edit') }}" 
                   class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('admin.edit_profile') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 