@extends('profile.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('projects.api_requests') }}: {{ $project->name }}</h1>
                    <p class="mt-2 text-gray-600">{{ __('projects.track_history') }}</p>
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
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-6">
            @if($requests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('projects.time') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('projects.method') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('projects.endpoint') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('projects.status') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Response {{ __('projects.time') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('projects.ip_address') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('projects.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($requests as $request)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $request->created_at->format('M d, Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $request->method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <code class="text-sm text-gray-900 truncate max-w-xs block" title="{{ $request->endpoint }}">
                                            {{ $request->endpoint }}
                                        </code>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $request->getStatusClass() }}">
                                            {{ $request->response_code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($request->response_time)
                                            {{ $request->response_time }}ms
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $request->ip_address ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="showRequestDetails({{ $request->id }})" 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-600 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ __('projects.view') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $requests->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('projects.no_requests_yet') }}</h3>
                    <p class="text-gray-500 mb-6">{{ __('projects.requests_appear_here') }}</p>
                    <a href="{{ route('profile.projects.show', $project) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View {{ __('projects.api_documentation') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- {{ __('projects.request_details') }} Modal -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="requestModal">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">{{ __('projects.request_details') }}</h3>
                <button onclick="closeRequestModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div id="requestModalBody" class="space-y-4">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showRequestDetails(requestId) {
    const modal = document.getElementById('requestModal');
    const modalBody = document.getElementById('requestModalBody');
    
    modalBody.innerHTML = `
        <div class="text-center py-8">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <p class="text-gray-600">Loading request details...</p>
        </div>
    `;
    
    modal.classList.remove('hidden');
    
    // Fetch real request details
    fetch(`/api/projects/{{ $project->id }}/requests/${requestId}`)
        .then(response => response.json())
        .then(data => {
            modalBody.innerHTML = `
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">{{ __('projects.request_data') }}</h4>
                        <div class="bg-gray-900 rounded-lg p-4">
                            <pre class="text-green-400 text-sm overflow-x-auto"><code>${data.method} ${data.endpoint}
Headers:
  Authorization: Bearer ***
  Content-Type: application/json
${data.request_data ? '\nBody:\n' + JSON.stringify(data.request_data, null, 2) : ''}</code></pre>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">{{ __('projects.response_data') }}</h4>
                        <div class="bg-gray-900 rounded-lg p-4">
                            <pre class="text-green-400 text-sm overflow-x-auto"><code>${JSON.stringify(data.response_data, null, 2)}</code></pre>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">{{ __('projects.additional_info') }}</h4>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('projects.user_agent') }}:</span>
                            <span class="text-sm text-gray-900">${data.user_agent || '-'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Response {{ __('projects.time') }}:</span>
                            <span class="text-sm text-green-600 font-medium">${data.response_time || 0}ms</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('projects.status') }}:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${data.response_code >= 200 && data.response_code < 300 ? 'bg-green-100 text-green-800' : data.response_code >= 400 && data.response_code < 500 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                                ${data.response_code} ${data.response_code >= 200 && data.response_code < 300 ? 'OK' : data.response_code >= 400 && data.response_code < 500 ? 'Client Error' : 'Server Error'}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">IP Address:</span>
                            <span class="text-sm text-gray-900">${data.ip_address || '-'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Time:</span>
                            <span class="text-sm text-gray-900">${data.created_at}</span>
                        </div>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            modalBody.innerHTML = `
                <div class="text-center py-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <p class="text-red-600">Error loading request details</p>
                </div>
            `;
        });
}

function closeRequestModal() {
    document.getElementById('requestModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('requestModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRequestModal();
    }
});
</script>
@endsection 