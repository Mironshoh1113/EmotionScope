@extends('profile.layout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('projects.project_settings') }}: {{ $project->name }}</h1>
                <p class="mt-2 text-gray-600">{{ __('projects.configure_advanced') }}</p>
            </div>
            <a href="{{ route('profile.projects.show', $project) }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('projects.back_to_project') }}
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-8">
            <form action="{{ route('profile.projects.update-settings', $project) }}" method="POST">
                @csrf
                
                <div class="space-y-8">
                    <!-- General Settings -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('projects.general_settings') }}</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('projects.webhook_url') }}</label>
                                <input type="url" 
                                       name="settings[webhook_url]" 
                                       value="{{ $project->settings['webhook_url'] ?? '' }}" 
                                       placeholder="https://your-domain.com/webhook"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <p class="mt-1 text-sm text-gray-500">{{ __('projects.webhook_description') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('projects.default_response_format') }}</label>
                                <select name="settings[response_format]" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="json" {{ ($project->settings['response_format'] ?? 'json') === 'json' ? 'selected' : '' }}>JSON</option>
                                    <option value="xml" {{ ($project->settings['response_format'] ?? '') === 'xml' ? 'selected' : '' }}>XML</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('projects.timezone') }}</label>
                                <select name="settings[timezone]" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="UTC" {{ ($project->settings['timezone'] ?? 'UTC') === 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="America/New_York" {{ ($project->settings['timezone'] ?? '') === 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                    <option value="Europe/London" {{ ($project->settings['timezone'] ?? '') === 'Europe/London' ? 'selected' : '' }}>London</option>
                                    <option value="Asia/Tashkent" {{ ($project->settings['timezone'] ?? '') === 'Asia/Tashkent' ? 'selected' : '' }}>Tashkent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- API Settings -->
                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('projects.api_settings') }}</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('projects.rate_limiting') }}</label>
                                <select name="settings[rate_limit_type]" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="per_minute" {{ ($project->settings['rate_limit_type'] ?? 'per_minute') === 'per_minute' ? 'selected' : '' }}>{{ __('projects.per_minute') }}</option>
                                    <option value="per_hour" {{ ($project->settings['rate_limit_type'] ?? '') === 'per_hour' ? 'selected' : '' }}>{{ __('projects.per_hour') }}</option>
                                    <option value="per_day" {{ ($project->settings['rate_limit_type'] ?? '') === 'per_day' ? 'selected' : '' }}>{{ __('projects.per_day') }}</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('projects.cors_settings') }}</label>
                                <input type="text" 
                                       name="settings[cors_origins]" 
                                       value="{{ $project->settings['cors_origins'] ?? '*' }}" 
                                       placeholder="{{ __('projects.cors_placeholder') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <p class="mt-1 text-sm text-gray-500">{{ __('projects.cors_description') }}</p>
                            </div>
                            
                            <div class="lg:col-span-2">
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               name="settings[log_requests]" 
                                               value="1" 
                                               {{ ($project->settings['log_requests'] ?? true) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label class="ml-2 block text-sm text-gray-700">{{ __('projects.log_requests') }}</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               name="settings[notify_errors]" 
                                               value="1" 
                                               {{ ($project->settings['notify_errors'] ?? false) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label class="ml-2 block text-sm text-gray-700">{{ __('projects.notify_errors') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- {{ __('projects.advanced_settings') }} -->
                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('projects.advanced_settings') }}</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('projects.cache_duration') }}</label>
                                <input type="number" 
                                       name="settings[cache_duration]" 
                                       value="{{ $project->settings['cache_duration'] ?? 300 }}" 
                                       min="0"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <p class="mt-1 text-sm text-gray-500">{{ __('projects.cache_description') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Request {{ __('projects.time') }}out (seconds)</label>
                                <input type="number" 
                                       name="settings[timeout]" 
                                       value="{{ $project->settings['timeout'] ?? 30 }}" 
                                       min="1" 
                                       max="300"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <p class="mt-1 text-sm text-gray-500">{{ __('projects.timeout_description') }}</p>
                            </div>
                            
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('projects.custom_headers') }}</label>
                                <textarea name="settings[custom_headers]" 
                                          rows="3" 
                                          placeholder="X-Custom-Header: value"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">{{ $project->settings['custom_headers'] ?? '' }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">{{ __('projects.headers_description') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">{{ __('projects.settings_information') }}</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>{{ __('projects.changes_immediate') }}</li>
                                        <li>{{ __('projects.token_regeneration') }}</li>
                                        <li>{{ __('projects.webhook_url') }}s must be publicly accessible</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form {{ __('projects.actions') }} -->
                <div class="flex items-center justify-between pt-8 border-t border-gray-200">
                    <a href="{{ route('profile.projects.show', $project) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        {{ __('projects.cancel') }}
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('projects.save_settings') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 