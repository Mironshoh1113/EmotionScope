@extends('profile.layout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('projects.edit_project') }}: {{ $project->name }}</h1>
                <p class="mt-2 text-gray-600">{{ __('projects.update_settings') }}</p>
            </div>
            <a href="{{ route('profile.projects.show', $project) }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('projects.back_to_projects') }}
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-8">
            <form action="{{ route('profile.projects.update', $project) }}" method="POST">
                @csrf
                @method('POST')
                
                <div class="space-y-6">
                    <!-- Project Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('projects.project_name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $project->name) }}" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('name') border-red-300 @enderror"
                               placeholder="{{ __('projects.project_name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('projects.description') }}
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('description') border-red-300 @enderror"
                                  placeholder="{{ __('projects.optional_description') }}">{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Webhook URL -->
                    <div>
                        <label for="webhook_url" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('projects.webhook_url') }}
                        </label>
                        <input type="url" 
                               id="webhook_url" 
                               name="webhook_url" 
                               value="{{ old('webhook_url', $project->webhook_url) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('webhook_url') border-red-300 @enderror"
                               placeholder="{{ __('projects.webhook_placeholder') }}">
                        @error('webhook_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">{{ __('projects.webhook_description') }}</p>
                    </div>
                    
                    <!-- Request Limit -->
                    <div>
                        <label for="request_limit" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('projects.request_limit') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="request_limit" 
                               name="request_limit" 
                               value="{{ old('request_limit', $project->request_limit) }}" 
                               min="1" 
                               max="100000" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('request_limit') border-red-300 @enderror">
                        @error('request_limit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">{{ __('projects.max_requests') }}</p>
                    </div>
                    
                    <!-- Active Status -->
                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $project->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded @error('is_active') border-red-300 @enderror">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                {{ __('projects.project_active') }}
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Current Usage Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">{{ __('projects.current_usage_info') }}</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p class="mb-2">
                                        <strong>{{ $project->requests_used }}</strong> {{ __('projects.requests_used_out_of') }} 
                                        <strong>{{ $project->request_limit }}</strong> {{ __('projects.limit_percentage') }} 
                                        ({{ $project->usage_percentage }}%)
                                    </p>
                                    <div class="w-full bg-blue-200 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-300 {{ $project->usage_percentage > 80 ? 'bg-yellow-500' : 'bg-green-500' }}" 
                                             style="width: {{ $project->usage_percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-8 border-t border-gray-200">
                    <a href="{{ route('profile.projects.show', $project) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        {{ __('projects.back_to_project') }}
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('projects.edit_project') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 