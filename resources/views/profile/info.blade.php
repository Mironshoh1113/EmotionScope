@extends('profile.layout')
@section('content')
<div class="max-w-6xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 text-gray-900">{{ __('profile_title') }}</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('basic_information') }}</h3>
            <div class="space-y-4">
                <div>
                    <span class="font-semibold text-gray-700">{{ __('name') }}:</span>
                    <span class="ml-2 text-gray-900">{{ $user->name }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700">{{ __('email') }}:</span>
                    <span class="ml-2 text-gray-900">{{ $user->email }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700">{{ __('oken') }}:</span>
                    <div class="mt-1">
                        <span class="bg-gray-100 px-3 py-2 rounded-lg text-blue-700 select-all font-mono text-sm">{{ $user->oken }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('account_status') }}</h3>
            <div class="space-y-4">
                <div>
                    <span class="font-semibold text-gray-700">{{ __('admin_status') }}:</span>
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $user->is_admin ? __('admin.administrator') : __('admin.user') }}
                    </span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700">{{ __('block_status') }}:</span>
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_blocked ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ $user->is_blocked ? __('admin.blocked') : __('admin.active') }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('usage_statistics') }}</h3>
            <div class="space-y-4">
                <div>
                    <span class="font-semibold text-gray-700">{{ __('balance') }}:</span>
                    <span class="ml-2 text-gray-900">${{ number_format($user->balance, 2) }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700">{{ __('request_limit') }}:</span>
                    <span class="ml-2 text-gray-900">{{ number_format($user->request_limit) }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700">{{ __('requests_used') }}:</span>
                    <span class="ml-2 text-gray-900">{{ number_format($user->requests_used) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 