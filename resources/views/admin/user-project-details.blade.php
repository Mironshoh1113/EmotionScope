@extends('admin.layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('admin.project_details') }}</h1>
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
        <!-- Project Information -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Project Details Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-green-200 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-gray-900">{{ $project->name }}</h2>
                            <p class="text-sm text-gray-500">{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @if($project->description)
                            <div>
                                <span class="text-sm text-gray-600">{{ __('admin.description') }}:</span>
                                <p class="text-sm text-gray-900 mt-1">{{ $project->description }}</p>
                            </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.project_status') }}:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $project->is_active ? __('admin.active') : __('admin.inactive') }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.project_created') }}:</span>
                            <span class="text-sm text-gray-900">{{ $project->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.last_updated') }}:</span>
                            <span class="text-sm text-gray-900">{{ $project->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.users.projects', $user->id) }}?stats_project={{ $project->id }}" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 text-center">
                                {{ __('admin.statistics') }}
                            </a>
                            <a href="{{ route('admin.users.projects', $user->id) }}" class="flex-1 bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 text-center">
                                {{ __('admin.back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Statistics -->
            <div class="lg:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Usage Statistics -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('admin.usage_statistics') }}</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ __('admin.requests_used') }}:</span>
                                <span class="text-lg font-semibold text-gray-900">{{ $project->requests_used }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ __('admin.request_limit') }}:</span>
                                <span class="text-lg font-semibold text-gray-900">{{ $project->request_limit }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ __('admin.usage_percentage') }}:</span>
                                <span class="text-lg font-semibold text-blue-600">{{ $project->usage_percentage }}%</span>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">{{ __('admin.usage_progress') }}</span>
                                <span class="text-sm text-gray-500">{{ $project->usage_percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ min($project->usage_percentage, 100) }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- API Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('admin.api_information') }}</h3>
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm text-gray-600">{{ __('admin.api_token') }}:</span>
                                <div class="mt-1 flex items-center space-x-2">
                                    <input type="text" value="{{ $project->api_token }}" readonly class="flex-1 px-3 py-2 text-sm bg-gray-100 border border-gray-300 rounded-lg font-mono">
                                    <button onclick="copyToClipboard('{{ $project->api_token }}')" class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        {{ __('admin.copy') }}
                                    </button>
                                </div>
                            </div>
                            
                            @if($project->webhook_url)
                                <div>
                                    <span class="text-sm text-gray-600">{{ __('admin.webhook_url') }}:</span>
                                    <p class="text-sm text-gray-900 mt-1 break-all">{{ $project->webhook_url }}</p>
                                </div>
                            @endif
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">{{ __('admin.can_make_request') }}:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->canMakeRequest() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $project->canMakeRequest() ? __('admin.yes') : __('admin.no') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- API Examples -->
                <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('admin.api_examples') }}</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- cURL Example -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">cURL</h4>
                                <div class="bg-gray-900 rounded-lg p-4">
                                    <pre class="text-green-400 text-sm overflow-x-auto"><code>curl -X POST "{{ url('/api/v1/analyze') }}" \
  -H "Authorization: Bearer {{ $project->api_token }}" \
  -H "Content-Type: application/json" \
  -d '{
    "text": "This is a test text for analysis."
  }'</code></pre>
                                </div>
                            </div>

                            <!-- JavaScript Example -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">JavaScript</h4>
                                <div class="bg-gray-900 rounded-lg p-4">
                                    <pre class="text-green-400 text-sm overflow-x-auto"><code>fetch('{{ url('/api/v1/analyze') }}', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer {{ $project->api_token }}',
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    text: 'This is a test text for analysis.'
  })
})
.then(response => response.json())
.then(data => console.log(data));</code></pre>
                                </div>
                            </div>

                            <!-- PHP Example -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">PHP</h4>
                                <div class="bg-gray-900 rounded-lg p-4">
                                    <pre class="text-green-400 text-sm overflow-x-auto"><code>$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, '{{ url('/api/v1/analyze') }}');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'text' => 'This is a test text for analysis.'
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer {{ $project->api_token }}',
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = '{{ __('admin.copied') }}';
        button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        button.classList.add('bg-green-600');
        
        setTimeout(() => {
            button.textContent = originalText;
            button.classList.remove('bg-green-600');
            button.classList.add('bg-blue-600', 'hover:bg-blue-700');
        }, 2000);
    });
}
</script>
@endsection 