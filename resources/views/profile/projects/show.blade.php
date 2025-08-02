@extends('profile.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Project Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $project->name }}</h1>
                    @if($project->description)
                        <p class="mt-2 text-gray-600">{{ $project->description }}</p>
                    @endif
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('profile.projects.edit', $project) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        {{ __('projects.edit') }}
                    </a>
                    <a href="{{ route('profile.projects.stats', $project) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        {{ __('projects.stats') }}
                    </a>
                    <a href="{{ route('profile.projects.requests', $project) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        {{ __('projects.requests') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- API Token Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900">{{ __('projects.api_token') }}</h3>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('projects.api_token') }}:</label>
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
                        <p class="mt-1 text-sm text-gray-500">{{ __('projects.keep_secure') }}</p>
                    </div>
                    
                    <!-- Debug: Project ID: {{ $project->id }} -->
                    <!-- Debug: Generated URL: {{ route('profile.projects.regenerate-token', $project) }} -->
                    <form action="{{ route('profile.projects.regenerate-token', $project) }}" method="POST" class="inline" id="regenerate-token-form">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Are you sure? This will invalidate the current token.')"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            {{ __('projects.regenerate_token') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Usage Stats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900">{{ __('projects.usage_statistics') }}</h3>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['total_requests'] }}</div>
                        <div class="text-sm text-blue-600">{{ __('projects.total_requests') }}</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['successful_requests'] }}</div>
                        <div class="text-sm text-green-600">{{ __('projects.successful') }}</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['failed_requests'] }}</div>
                        <div class="text-sm text-yellow-600">{{ __('projects.failed') }}</div>
                    </div>
                    <div class="text-center p-4 bg-indigo-50 rounded-lg">
                        <div class="text-2xl font-bold text-indigo-600">{{ round($stats['avg_response_time'] ?? 0, 2) }}ms</div>
                        <div class="text-sm text-indigo-600">{{ __('projects.avg_response') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- {{ __('projects.api_documentation') }} -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-medium text-gray-900">{{ __('projects.api_documentation') }}</h3>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">{{ __('projects.base_url') }}</h4>
                    <code class="block w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg px-3 py-2">{{ url('/api/v1') }}</code>
                    
                    <h4 class="text-sm font-medium text-gray-700 mt-4 mb-2">{{ __('projects.authentication') }}</h4>
                    <p class="text-sm text-gray-600 mb-2">{{ __('projects.include_token') }}</p>
                    <code class="block w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg px-3 py-2">Authorization: Bearer {{ $project->api_token }}</code>
                    
                    <h4 class="text-sm font-medium text-gray-700 mt-4 mb-2">{{ __('projects.endpoint') }}</h4>
                    <p class="text-sm text-gray-600 mb-2">Text Analysis API:</p>
                    <code class="block w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg px-3 py-2">POST /api/v1/analyze</code>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">{{ __('projects.rate_limits') }}</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex justify-between">
                            <span>{{ __('projects.current_usage_info') }}:</span>
                            <span class="font-medium">{{ $project->requests_used }} / {{ $project->request_limit }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span>{{ __('projects.status') }}:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $project->is_active ? __('projects.active') : __('projects.inactive') }}
                            </span>
                        </li>
                    </ul>
                    
                    <h4 class="text-sm font-medium text-gray-700 mt-4 mb-2">{{ __('projects.response_format') }}</h4>
                    <p class="text-sm text-gray-600 mb-2">{{ __('projects.returns_analysis') }}</p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• {{ __('projects.sentiment_analysis') }}</li>
                        <li>• {{ __('projects.complexity_assessment') }}</li>
                        <li>• {{ __('projects.language_detection') }}</li>
                        <li>• {{ __('projects.word_counts') }}</li>
                        <li>• {{ __('projects.recommendations') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- {{ __('projects.api_examples') }} -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-medium text-gray-900">{{ __('projects.api_examples') }}</h3>
            </div>
            
            <div class="space-y-6">
                <!-- API Response Example -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-3">{{ __('projects.sample_response') }}</h4>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <pre class="text-green-400 text-sm overflow-x-auto"><code>{
  "status": "success",
  "message": "Text analysis completed successfully",
  "timestamp": "2024-01-15T10:30:00.000000Z",
  "project": "{{ $project->name }}",
  "request_id": "abc123def456",
  "analysis": {
    "original_text": "This is a wonderful and amazing text!",
    "metrics": {
      "word_count": 8,
      "character_count": 35,
      "sentence_count": 1,
      "average_word_length": 4.38,
      "average_sentence_length": 8
    },
    "sentiment": {
      "score": 25.0,
      "description": "Positive",
      "color": "green",
      "positive_words_found": 2,
      "negative_words_found": 0
    },
    "complexity": {
      "score": 45.5,
      "level": "Medium",
      "description": "Moderate vocabulary and sentence structure"
    },
    "language": "English",
    "summary": {
      "overall_assessment": "The text has a positive tone and conveys optimism. The text has moderate complexity, suitable for general audiences.",
      "recommendations": ["The text is well-balanced and suitable for its intended purpose."]
    }
  }
}</code></pre>
                    </div>
                </div>
                
                <!-- cURL Example -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-3">cURL</h4>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <pre class="text-green-400 text-sm overflow-x-auto"><code>curl -X POST "{{ url('/api/v1/analyze') }}" \
  -H "Authorization: Bearer {{ $project->api_token }}" \
  -H "Content-Type: application/json" \
  -d '{
    "text": "This is a sample text for analysis. It contains both positive and negative words."
  }'</code></pre>
                    </div>
                </div>
                
                <!-- JavaScript Example -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-3">JavaScript</h4>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <pre class="text-green-400 text-sm overflow-x-auto"><code>fetch('{{ url('/api/v1/analyze') }}', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer {{ $project->api_token }}',
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    text: 'This is a sample text for analysis. It contains both positive and negative words.'
  })
})
.then(response => response.json())
.then(data => console.log(data));</code></pre>
                    </div>
                </div>
                
                <!-- PHP Example -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-3">PHP</h4>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <pre class="text-green-400 text-sm overflow-x-auto"><code>$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, '{{ url('/api/v1/analyze') }}');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer {{ $project->api_token }}',
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'text' => 'This is a sample text for analysis. It contains both positive and negative words.'
]));
$response = curl_exec($ch);
curl_close($ch);
$data = json_decode($response, true);</code></pre>
                    </div>
                </div>
                
                <!-- Postman Example -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Postman</h4>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <pre class="text-green-400 text-sm overflow-x-auto"><code>{{ __('projects.method') }}: POST
URL: {{ url('/api/v1/analyze') }}

Headers:
Authorization: Bearer {{ $project->api_token }}
Content-Type: application/json

Body (raw JSON):
{
  "text": "This is a sample text for analysis. It contains both positive and negative words."
}</code></pre>
                    </div>
                </div>
                
                <!-- Python Example -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Python</h4>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <pre class="text-green-400 text-sm overflow-x-auto"><code>import requests
import json

url = "{{ url('/api/v1/analyze') }}"
headers = {
    "Authorization": "Bearer {{ $project->api_token }}",
    "Content-Type": "application/json"
}
data = {
    "text": "This is a sample text for analysis. It contains both positive and negative words."
}

response = requests.post(url, headers=headers, json=data)
result = response.json()
print(json.dumps(result, indent=2))</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
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