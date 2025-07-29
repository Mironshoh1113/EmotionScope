@extends('profile.layout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('projects.create_project') }}</h1>
                <p class="mt-2 text-gray-600">{{ __('projects.setup_project') }}</p>
            </div>
            <a href="{{ route('profile.projects.index') }}" 
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
            <form action="{{ route('profile.projects.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- {{ __('projects.project_name') }} -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('projects.project_name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('name') border-red-300 @enderror"
                               placeholder="Enter your project name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- {{ __('projects.description') }} -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('projects.description') }}
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('description') border-red-300 @enderror"
                                  placeholder="{{ __('projects.optional_description') }}">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">{{ __('projects.optional_description') }}</p>
                    </div>
                    
                    <!-- {{ __('projects.request_limit') }} -->
                    <div>
                        <label for="request_limit" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('projects.request_limit') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="request_limit" 
                               name="request_limit" 
                               value="{{ old('request_limit', 1000) }}" 
                               min="1" 
                               max="100000" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('request_limit') border-red-300 @enderror">
                        @error('request_limit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">{{ __('projects.max_requests') }}</p>
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
                                <h3 class="text-sm font-medium text-blue-800">{{ __('projects.what_happens_next') }}</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>{{ __('projects.token_generated') }}</li>
                                        <li>{{ __('projects.view_documentation') }}</li>
                                        <li>{{ __('projects.track_usage') }}</li>
                                        <li>{{ __('projects.configure_settings') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form {{ __('projects.actions') }} -->
                <div class="flex items-center justify-between pt-8 border-t border-gray-200">
                    <a href="{{ route('profile.projects.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        {{ __('projects.back_to_project') }}s
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        {{ __('projects.create_project') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 