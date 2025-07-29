@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('admin.edit_user') }}</h1>
                <p class="mt-2 text-sm text-gray-600">{{ __('admin.edit_user_description') }}</p>
            </div>
            <a href="{{ route('admin.users.show', $user->id) }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('admin.back_to_user') }}
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-6">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-red-800">{{ __('admin.there_were_errors') }}</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6">
                @csrf
                
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('admin.basic_information') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.name') }}</label>
                            <input type="text" 
                                   id="name"
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.email') }}</label>
                            <input type="email" 
                                   id="email"
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('admin.password_settings') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.new_password') }}</label>
                            <input type="password" 
                                   id="password"
                                   name="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   placeholder="{{ __('admin.leave_blank_to_keep_current') }}">
                            <p class="mt-1 text-sm text-gray-500">{{ __('admin.password_requirements') }}</p>
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.confirm_password') }}</label>
                            <input type="password" 
                                   id="password_confirmation"
                                   name="password_confirmation" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   placeholder="{{ __('admin.repeat_new_password') }}">
                        </div>
                    </div>
                </div>

                <!-- Account Settings -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('admin.account_settings') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="is_admin" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.admin_status') }}</label>
                            <select id="is_admin" 
                                    name="is_admin" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>{{ __('admin.no') }}</option>
                                <option value="1" {{ $user->is_admin ? 'selected' : '' }}>{{ __('admin.yes') }}</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="balance" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.balance') }}</label>
                            <div class="relative">
                                <input type="number" 
                                       id="balance"
                                       name="balance" 
                                       step="0.01" 
                                       value="{{ old('balance', $user->balance) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">USD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Request Limits -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('admin.request_limits') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="request_limit" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.request_limit') }}</label>
                            <input type="number" 
                                   id="request_limit"
                                   name="request_limit" 
                                   value="{{ old('request_limit', $user->request_limit) }}" 
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <p class="mt-1 text-sm text-gray-500">{{ __('admin.maximum_requests_per_month') }}</p>
                        </div>
                        
                        <div>
                            <label for="requests_used" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.requests_used') }}</label>
                            <input type="number" 
                                   id="requests_used"
                                   name="requests_used" 
                                   value="{{ old('requests_used', $user->requests_used) }}" 
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <p class="mt-1 text-sm text-gray-500">{{ __('admin.current_usage_count') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.users.show', $user->id) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        {{ __('admin.cancel') }}
                    </a>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('admin.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 