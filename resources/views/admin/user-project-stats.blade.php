@extends('admin.layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('admin.project_statistics') }}</h1>
                    <p class="text-sm text-gray-600">{{ $project->name }} - {{ $user->name }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.users.projects', $user->id) }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('admin.total_requests') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $project->requests()->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('admin.successful_requests') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $project->requests()->where('response_code', '>=', 200)->where('response_code', '<', 300)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('admin.failed_requests') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $project->requests()->where('response_code', '>=', 400)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('admin.average_response_time') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ round($project->requests()->whereNotNull('response_time')->avg('response_time') ?? 0, 2) }}ms</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usage Progress -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('admin.usage_progress') }}</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">{{ __('admin.requests_used') }}</span>
                    <span class="text-sm font-medium text-gray-900">{{ $project->requests_used }} / {{ $project->request_limit }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-blue-600 h-4 rounded-full transition-all duration-300" style="width: {{ min($project->usage_percentage, 100) }}%"></div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">{{ __('admin.usage_percentage') }}</span>
                    <span class="text-sm font-medium text-blue-600">{{ $project->usage_percentage }}%</span>
                </div>
            </div>
        </div>

        <!-- Recent Requests -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">{{ __('admin.recent_requests') }}</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.request_method') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.request_endpoint') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.request_status') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.request_time') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.request_date') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($project->requests()->latest()->take(10)->get() as $request)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $request->method }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->endpoint }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $request->getStatusClass() }}">
                                        {{ $request->response_code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->response_time ?? 0 }}ms</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $request->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="showRequestDetails({{ $request->id }})" class="text-blue-600 hover:text-blue-900">
                                        {{ __('admin.view') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">{{ __('admin.no_requests_found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6 flex justify-center">
            <a href="{{ route('admin.users.projects', $user->id) }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-gray-700">
                {{ __('admin.back_to_projects') }}
            </a>
        </div>
    </div>
</div>

<!-- Request Details Modal -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="requestModal">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">{{ __('admin.request_details') }}</h3>
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
            <p class="text-gray-600">{{ __('admin.loading') }}</p>
        </div>
    `;
    
    modal.classList.remove('hidden');
    
    // Fetch real request details
    fetch(`/admin/api/projects/{{ $project->id }}/requests/${requestId}`)
        .then(response => response.json())
        .then(data => {
            modalBody.innerHTML = `
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">{{ __('admin.request_data') }}</h4>
                        <div class="bg-gray-900 rounded-lg p-4">
                            <pre class="text-green-400 text-sm overflow-x-auto"><code>${data.method} ${data.endpoint}
Headers:
  Authorization: Bearer ***
  Content-Type: application/json
${data.request_data ? '\nBody:\n' + JSON.stringify(data.request_data, null, 2) : ''}</code></pre>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">{{ __('admin.response_data') }}</h4>
                        <div class="bg-gray-900 rounded-lg p-4">
                            <pre class="text-green-400 text-sm overflow-x-auto"><code>${JSON.stringify(data.response_data, null, 2)}</code></pre>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">{{ __('admin.additional_info') }}</h4>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.request_user_agent') }}:</span>
                            <span class="text-sm text-gray-900">${data.user_agent || '-'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.request_time') }}:</span>
                            <span class="text-sm text-green-600 font-medium">${data.response_time || 0}ms</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.request_status') }}:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${data.response_code >= 200 && data.response_code < 300 ? 'bg-green-100 text-green-800' : data.response_code >= 400 && data.response_code < 500 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                                ${data.response_code} ${data.response_code >= 200 && data.response_code < 300 ? 'OK' : data.response_code >= 400 && data.response_code < 500 ? 'Client Error' : 'Server Error'}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.request_ip') }}:</span>
                            <span class="text-sm text-gray-900">${data.ip_address || '-'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.request_date') }}:</span>
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
                    <p class="text-red-600">{{ __('admin.error_loading_data') }}</p>
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