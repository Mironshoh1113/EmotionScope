@extends('profile.layout')
@section('content')
<div class="max-w-6xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 text-gray-900">{{ __('balance') }}</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
        <!-- Balance Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('balance') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('current_balance') }}</p>
                </div>
            </div>
            <div class="text-3xl font-bold text-green-600">${{ number_format($user->balance, 2) }}</div>
        </div>
        
        <!-- Request Usage Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('request_usage') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('monthly_usage') }}</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ __('requests_used') }}:</span>
                    <span class="font-semibold text-gray-900">{{ number_format($user->requests_used) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ __('request_limit') }}:</span>
                    <span class="font-semibold text-gray-900">{{ number_format($user->request_limit) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-300 {{ $user->usage_percentage > 80 ? 'bg-yellow-500' : 'bg-green-500' }}" 
                         style="width: {{ $user->usage_percentage }}%"></div>
                </div>
                <div class="text-center text-sm text-gray-500">
                    {{ $user->usage_percentage }}% {{ __('used') }}
                </div>
            </div>
        </div>
        
        <!-- Usage Statistics Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('usage_statistics') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('detailed_stats') }}</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ __('remaining_requests') }}:</span>
                    <span class="font-semibold text-gray-900">{{ number_format($user->request_limit - $user->requests_used) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ __('usage_percentage') }}:</span>
                    <span class="font-semibold text-gray-900">{{ $user->usage_percentage }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 