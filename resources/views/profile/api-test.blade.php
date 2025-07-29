@extends('profile.layout')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ __('api_test') }}</h1>
                <p class="text-lg text-gray-600">API loyihangizni test qiling va natijalarni ko'ring</p>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-code text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="mb-8 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-8 border border-blue-100">
        <div class="flex items-center mb-6">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-lightbulb text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">{{ __('how_to_use') }}</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center text-blue-800 font-bold mr-4 mt-1">1</div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-2">{{ __('step_1_title') }}</h4>
                    <p class="text-gray-600">{{ __('step_1_description') }}</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-purple-200 rounded-full flex items-center justify-center text-purple-800 font-bold mr-4 mt-1">2</div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-2">{{ __('step_2_title') }}</h4>
                    <p class="text-gray-600">{{ __('step_2_description') }}</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-green-200 rounded-full flex items-center justify-center text-green-800 font-bold mr-4 mt-1">3</div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-2">{{ __('step_3_title') }}</h4>
                    <p class="text-gray-600">{{ __('step_3_description') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Form -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-8">
                        <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-rocket text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ __('test_api') }}</h3>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-600">{{ __('remaining_requests') }}</div>
                        <div class="text-lg font-bold text-blue-600">{{ $user->getRemainingRequests() }}/{{ $user->request_limit }}</div>
                    </div>
                </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">{{ __('there_were_errors') }}</h3>
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

        <form id="apiTestForm" class="space-y-6">
            @csrf

            <div>
                <label for="project_id" class="block text-sm font-semibold text-gray-700 mb-3">{{ __('select_project') }}</label>
                <div class="relative">
                    <select id="project_id" name="project_id" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white appearance-none">
                        <option value="">{{ __('choose_project') }}</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }} ({{ $project->requests_used }}/{{ $project->request_limit }})
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div>
                <label for="text" class="block text-sm font-semibold text-gray-700 mb-3">{{ __('test_text') }}</label>
                <textarea id="text" name="text" rows="8" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                          placeholder="{{ __('enter_test_text') }}">{{ old('text') }}</textarea>
                <p class="mt-2 text-sm text-gray-500 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    {{ __('text_analysis_description') }}
                </p>
            </div>

            <button type="submit" id="submitBtn" class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600 border border-transparent rounded-xl font-semibold text-white hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span id="submitText">{{ __('send_test_request') }}</span>
                <svg id="loadingSpinner" class="hidden w-5 h-5 ml-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </button>
        </form>
    </div>

    <!-- Results -->
    <div id="resultsDiv" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hidden">
        <div class="flex items-center mb-6">
            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-chart-bar text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">{{ __('test_results') }}</h3>
        </div>
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-chart-line text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-500 text-lg">{{ __('no_test_results') }}</p>
            <p class="text-gray-400 text-sm mt-2">Yuqoridagi forma orqali test qiling</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('apiTestForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const resultsDiv = document.getElementById('resultsDiv');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const projectId = document.getElementById('project_id').value;
        const text = document.getElementById('text').value;
        
        if (!projectId || !text) {
            alert('{{ __("please_fill_all_fields") }}');
            return;
        }
        
        // Disable button and show loading
        submitBtn.disabled = true;
        submitText.textContent = '{{ __("processing") }}...';
        loadingSpinner.classList.remove('hidden');
        
        // Make AJAX request
        console.log('Sending request to:', '{{ route("profile.test-api") }}');
        console.log('Request data:', { project_id: projectId, text: text });
        
        fetch('{{ route("profile.test-api") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                project_id: projectId,
                text: text
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            // Show results
            if (data.success) {
                displayResults(data.result);
            } else {
                alert(data.error || '{{ __("api_error") }}');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ __("network_error") }}');
        })
        .finally(() => {
            // Re-enable button
            submitBtn.disabled = false;
            submitText.textContent = '{{ __("send_test_request") }}';
            loadingSpinner.classList.add('hidden');
        });
    });
    
    function displayResults(result) {
        const analysis = result.response_data.analysis || {};
        const resultsHtml = `
            <div class="space-y-6">
                <!-- Header Info -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6 border border-blue-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900">${result.project_name}</h4>
                            <p class="text-sm text-gray-600">Test natijalari</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold ${result.status_code >= 200 && result.status_code < 300 ? 'text-green-600' : 'text-red-600'}">${result.status_code}</div>
                                <div class="text-xs text-gray-500">Status</div>
                            </div>
                            ${analysis.language ? `
                            <div class="text-center">
                                <div class="text-lg font-semibold text-gray-900">${analysis.language}</div>
                                <div class="text-xs text-gray-500">Til</div>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>

                <!-- Test Text -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h5 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                        Test matni
                    </h5>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900">${result.text}</p>
                    </div>
                </div>

                ${analysis.emotion_score !== undefined ? `
                <!-- Analysis Results -->
                <div class="space-y-6">
                    <h5 class="font-semibold text-gray-900 text-lg flex items-center">
                        <i class="fas fa-chart-pie mr-2 text-purple-500"></i>
                        Tahlil natijalari
                    </h5>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Emotion -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                            <div class="flex items-center justify-between mb-3">
                                <h6 class="font-semibold text-gray-900">His-tuyg'u</h6>
                                <div class="text-2xl font-bold text-blue-600">${analysis.emotion_score}</div>
                            </div>
                            <div class="w-full bg-blue-200 rounded-full h-2 mb-3">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: ${analysis.emotion_score}%"></div>
                            </div>
                            <p class="text-sm text-gray-700">${analysis.emotion_comment || ''}</p>
                        </div>

                        <!-- Positivity -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                            <div class="flex items-center justify-between mb-3">
                                <h6 class="font-semibold text-gray-900">Ijobiylik</h6>
                                <div class="text-2xl font-bold text-green-600">${analysis.positivity_score}</div>
                            </div>
                            <div class="w-full bg-green-200 rounded-full h-2 mb-3">
                                <div class="bg-green-600 h-2 rounded-full" style="width: ${analysis.positivity_score}%"></div>
                            </div>
                            <p class="text-sm text-gray-700">${analysis.positivity_comment || ''}</p>
                        </div>

                        <!-- Negativity -->
                        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
                            <div class="flex items-center justify-between mb-3">
                                <h6 class="font-semibold text-gray-900">Salbiylik</h6>
                                <div class="text-2xl font-bold text-red-600">${analysis.negativity_score}</div>
                            </div>
                            <div class="w-full bg-red-200 rounded-full h-2 mb-3">
                                <div class="bg-red-600 h-2 rounded-full" style="width: ${analysis.negativity_score}%"></div>
                            </div>
                            <p class="text-sm text-gray-700">${analysis.negativity_comment || ''}</p>
                        </div>

                        <!-- Relevance -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                            <div class="flex items-center justify-between mb-3">
                                <h6 class="font-semibold text-gray-900">Mavzuga moslik</h6>
                                <div class="text-2xl font-bold text-purple-600">${analysis.relevance_score}</div>
                            </div>
                            <div class="w-full bg-purple-200 rounded-full h-2 mb-3">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: ${analysis.relevance_score}%"></div>
                            </div>
                            <p class="text-sm text-gray-700">${analysis.relevance_comment || ''}</p>
                        </div>

                        <!-- Complexity -->
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6 border border-orange-200">
                            <div class="flex items-center justify-between mb-3">
                                <h6 class="font-semibold text-gray-900">Murakkablik</h6>
                                <div class="text-2xl font-bold text-orange-600">${analysis.complexity_score}</div>
                            </div>
                            <div class="w-full bg-orange-200 rounded-full h-2 mb-3">
                                <div class="bg-orange-600 h-2 rounded-full" style="width: ${analysis.complexity_score}%"></div>
                            </div>
                            <p class="text-sm text-gray-700">${analysis.complexity_comment || ''}</p>
                        </div>

                        <!-- Spam -->
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border border-yellow-200">
                            <div class="flex items-center justify-between mb-3">
                                <h6 class="font-semibold text-gray-900">Spam ehtimoli</h6>
                                <div class="text-2xl font-bold text-yellow-600">${analysis.spam_score}</div>
                            </div>
                            <div class="w-full bg-yellow-200 rounded-full h-2 mb-3">
                                <div class="bg-yellow-600 h-2 rounded-full" style="width: ${analysis.spam_score}%"></div>
                            </div>
                            <p class="text-sm text-gray-700">${analysis.spam_comment || ''}</p>
                        </div>

                        <!-- Ethics -->
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 border border-indigo-200">
                            <div class="flex items-center justify-between mb-3">
                                <h6 class="font-semibold text-gray-900">Axloqiy baho</h6>
                                <div class="text-2xl font-bold text-indigo-600">${analysis.ethics_score}</div>
                            </div>
                            <div class="w-full bg-indigo-200 rounded-full h-2 mb-3">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: ${analysis.ethics_score}%"></div>
                            </div>
                            <p class="text-sm text-gray-700">${analysis.ethics_comment || ''}</p>
                        </div>
                    </div>

                    <!-- Publish Recommendation -->
                    <div class="bg-gradient-to-r ${analysis.publishable ? 'from-green-50 to-emerald-50' : 'from-red-50 to-pink-50'} rounded-xl p-6 border ${analysis.publishable ? 'border-green-200' : 'border-red-200'}">
                        <div class="flex items-center justify-between">
                            <div>
                                <h6 class="font-semibold text-gray-900 text-lg">E'lon qilish tavsiyasi</h6>
                                <p class="text-sm text-gray-600 mt-1">${analysis.publish_comment || ''}</p>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl mb-2">${analysis.publishable ? '✅' : '❌'}</div>
                                <div class="text-sm font-semibold ${analysis.publishable ? 'text-green-600' : 'text-red-600'}">
                                    ${analysis.publishable ? 'Tavsiya etiladi' : 'Tavsiya etilmaydi'}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ` : ''}

                <!-- Raw Data -->
                <div class="bg-gray-900 rounded-xl p-6">
                    <h5 class="font-semibold text-gray-100 mb-3 flex items-center">
                        <i class="fas fa-code mr-2 text-green-400"></i>
                        To'liq ma'lumot
                    </h5>
                    <div class="overflow-x-auto">
                        <pre class="text-green-400 text-sm"><code>${JSON.stringify(result.response_data, null, 2)}</code></pre>
                    </div>
                </div>
            </div>
        `;
        
        resultsDiv.innerHTML = resultsHtml;
        resultsDiv.classList.remove('hidden');
    }
});
</script>
@endsection 