@extends('admin.layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('admin.edit_user') }}</h1>
                    <p class="text-sm text-gray-600">{{ $user->name }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">{{ __('admin.edit_user') }}</h2>
            </div>
            
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <!-- User Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.name') }}</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.email') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.new_password') }}</label>
                        <input type="password" name="password" id="password" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                               placeholder="{{ __('admin.leave_empty_to_keep_current') }}">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="{{ __('admin.confirm_new_password') }}">
                    </div>
                </div>

                <!-- User Settings -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="is_admin" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.admin_status') }}</label>
                        <select name="is_admin" id="is_admin" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="0" {{ $user->is_admin ? '' : 'selected' }}>{{ __('admin.no') }}</option>
                            <option value="1" {{ $user->is_admin ? 'selected' : '' }}>{{ __('admin.yes') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="balance" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.balance') }}</label>
                        <input type="number" step="0.01" name="balance" id="balance" value="{{ old('balance', $user->balance) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('balance') border-red-500 @enderror">
                        @error('balance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="request_limit" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.request_limit') }}</label>
                        <input type="number" name="request_limit" id="request_limit" value="{{ old('request_limit', $user->request_limit) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('request_limit') border-red-500 @enderror">
                        @error('request_limit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Block Status -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('admin.account_status') }}</h3>
                            <p class="text-sm text-gray-600">{{ __('admin.manage_user_access') }}</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">{{ __('admin.current_status') }}:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->is_blocked ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->is_blocked ? __('admin.blocked') : __('admin.active') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.users.show', $user->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        {{ __('admin.back') }}
                    </a>
                    
                    <div class="flex items-center space-x-3">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ __('admin.save_changes') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 