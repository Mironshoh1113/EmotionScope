@extends('profile.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('projects.my_projects') }}</h1>
                <p class="mt-2 text-gray-600">{{ __('projects.manage_projects') }}</p>
            </div>
            <a href="{{ route('profile.projects.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('projects.create_new_project') }}
            </a>
        </div>
    </div>

    @if($projects->count() > 0)
        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($projects as $project)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <!-- Project Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $project->name }}</h3>
                                @if($project->description)
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $project->description }}</p>
                                @endif
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $project->is_active ? __('projects.active') : __('projects.inactive') }}
                            </span>
                        </div>

                        <!-- API Token -->
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-700 mb-2">{{ __('projects.api_token') }}</label>
                            <div class="flex">
                                <input type="text" 
                                       class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block px-3 py-2" 
                                       value="{{ $project->api_token }}" readonly>
                                <button onclick="copyToClipboard(this)" 
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-r-lg border border-l-0 border-gray-300 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Usage Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $project->requests_used }}</div>
                                <div class="text-xs text-gray-500">{{ __('projects.used') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-600">{{ $project->request_limit }}</div>
                                <div class="text-xs text-gray-500">{{ __('projects.limit') }}</div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>{{ __('projects.usage') }}</span>
                                <span>{{ $project->usage_percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full transition-all duration-300 {{ $project->usage_percentage > 80 ? 'bg-yellow-500' : 'bg-green-500' }}" 
                                     style="width: {{ $project->usage_percentage }}%"></div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('profile.projects.show', $project) }}" 
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ __('projects.view') }}
                            </a>
                            <div class="flex space-x-2">
                                <a href="{{ route('profile.projects.edit', $project) }}" 
                                   class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('profile.projects.stats', $project) }}" 
                                   class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $projects->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('projects.no_projects_yet') }}</h3>
            <p class="text-gray-500 mb-6">{{ __('projects.create_first_project') }}</p>
            <a href="{{ route('profile.projects.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('projects.create_your_first_project') }}
            </a>
        </div>
    @endif
</div>

<script>
function copyToClipboard(button) {
    const input = button.parentElement.querySelector('input');
    input.select();
    document.execCommand('copy');
    
    const originalHTML = button.innerHTML;
    button.innerHTML = `
        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    `;
    
    setTimeout(() => {
        button.innerHTML = originalHTML;
    }, 2000);
}
</script>
@endsection 