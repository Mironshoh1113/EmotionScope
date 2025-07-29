<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function analyzeText(Request $request)
    {
        // Increase PHP execution time for API requests
        set_time_limit(120); // 2 minutes
        ini_set('max_execution_time', 120);
        
        // Get the API token from the Authorization header
        $token = $request->header('Authorization');
        if (!$token || !str_starts_with($token, 'Bearer ')) {
            return response()->json(['error' => 'Invalid authorization header'], 401);
        }
        
        $apiToken = substr($token, 7); // Remove 'Bearer ' prefix
        
        // Find the project by API token
        $project = Project::where('api_token', $apiToken)->first();
        if (!$project) {
            return response()->json(['error' => 'Invalid API token'], 401);
        }
        
        // Check if project is active
        if (!$project->is_active) {
            return response()->json(['error' => 'Project is inactive'], 403);
        }
        
        // Check if project has reached its request limit
        if (!$project->canMakeRequest()) {
            return response()->json(['error' => 'Request limit exceeded'], 429);
        }
        
        // Validate request
        $request->validate([
            'text' => 'required|string|max:10000',
        ]);
        
        // Record the request start time
        $startTime = microtime(true);
        
        // Gemini API call
        $geminiApiKey = env('GEMINI_API_KEY');
        $geminiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
        $prompt = "Quyidagi matnni quyidagi mezonlar bo‘yicha tahlil qil va har biriga 0-100 ball ber: \n- emotion (kayfiyat)\n- positivity\n- negativity\n- relevance (mavzuga moslik)\n- complexity (murakkablik)\n- spam yoki reklama ehtimoli\n- odob-axloq (etik) buzilishi\n\nHar bir mezon uchun qisqacha izoh yoz.\nMatn yozilgan tilni aniqlab, 'language' maydonini ham JSONga qo‘sh.\nOxirida: ‘Bu matnni elon qilish mumkinmi yoki yo‘qmi?’ degan yakuniy baho (ha/yo‘q) va qisqa sabab yoz.\n\nJavobni faqat quyidagi json formatida qaytar:\n{\n  \"language\": \"...\",\n  \"emotion_score\": ...,\n  \"emotion_comment\": \"...\",\n  \"positivity_score\": ...,\n  \"positivity_comment\": \"...\",\n  \"negativity_score\": ...,\n  \"negativity_comment\": \"...\",\n  \"relevance_score\": ...,\n  \"relevance_comment\": \"...\",\n  \"complexity_score\": ...,\n  \"complexity_comment\": \"...\",\n  \"spam_score\": ...,\n  \"spam_comment\": \"...\",\n  \"ethics_score\": ...,\n  \"ethics_comment\": \"...\",\n  \"publishable\": true/false,\n  \"publish_comment\": \"...\"\n}\n\nFoydalanuvchi matni: " . $request->text;
        $geminiPayload = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt
                        ]
                    ]
                ]
            ]
        ];
        try {
            $geminiResponse = Http::timeout(90)->withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $geminiApiKey,
            ])->post($geminiUrl, $geminiPayload);
        } catch (\Exception $e) {
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            // Log failed request
            ProjectRequest::create([
                'project_id' => $project->id,
                'endpoint' => '/api/v1/analyze',
                'method' => $request->method(),
                'request_data' => $request->all(),
                'response_data' => ['error' => 'Gemini API timeout: ' . $e->getMessage()],
                'response_code' => 408,
                'response_time' => $responseTime,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            $project->incrementRequests();
            return response()->json(['error' => 'Gemini API timeout', 'details' => $e->getMessage()], 408);
        }
        
        if (!$geminiResponse->ok()) {
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            // Log failed request
            ProjectRequest::create([
                'project_id' => $project->id,
                'endpoint' => '/api/v1/analyze',
                'method' => $request->method(),
                'request_data' => $request->all(),
                'response_data' => $geminiResponse->json(),
                'response_code' => $geminiResponse->status(),
                'response_time' => $responseTime,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            $project->incrementRequests();
            return response()->json(['error' => 'Gemini API error', 'details' => $geminiResponse->json()], 500);
        }
        $geminiData = $geminiResponse->json();
        $responseTime = round((microtime(true) - $startTime) * 1000, 2);
        // Try to extract and decode the JSON from Gemini's response
        $geminiText = $geminiData['candidates'][0]['content']['parts'][0]['text'] ?? null;
        // Remove ```json ... ``` block if present
        if ($geminiText) {
            $geminiText = trim($geminiText);
            if (str_starts_with($geminiText, '```json')) {
                $geminiText = preg_replace('/^```json|```$/m', '', $geminiText);
                $geminiText = trim($geminiText);
            }
        }
        $jsonResult = json_decode($geminiText, true);
        // Only allow required fields
        $fields = [
            'language',
            'emotion_score', 'emotion_comment',
            'positivity_score', 'positivity_comment',
            'negativity_score', 'negativity_comment',
            'relevance_score', 'relevance_comment',
            'complexity_score', 'complexity_comment',
            'spam_score', 'spam_comment',
            'ethics_score', 'ethics_comment',
            'publishable', 'publish_comment'
        ];
        $cleanResult = [];
        if (is_array($jsonResult)) {
            foreach ($fields as $field) {
                if (array_key_exists($field, $jsonResult)) {
                    $cleanResult[$field] = $jsonResult[$field];
                }
            }
        }
        // Prepare response
        $response = [
            'status' => 'success',
            'timestamp' => now()->toISOString(),
            'project' => $project->name,
            'analysis' => !empty($cleanResult) ? $cleanResult : [
                'error' => 'Could not parse Gemini JSON response.',
                'raw_gemini_response' => $geminiText
            ],
            'request_id' => uniqid(),
        ];
        // Create request record
        ProjectRequest::create([
            'project_id' => $project->id,
            'endpoint' => '/api/v1/analyze',
            'method' => $request->method(),
            'request_data' => $request->all(),
            'response_data' => $response,
            'response_code' => 200,
            'response_time' => $responseTime,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        // Increment request count
        $project->incrementRequests();
        // Project egasi (user) limitini ham kamaytirish
        $user = $project->user;
        if ($user) {
            $user->increment('requests_used');
        }
        return response()->json($response, 200);
    }
    
    private function analyzeTextContent($text)
    {
        // Simple text analysis algorithm
        $wordCount = str_word_count($text);
        $charCount = strlen($text);
        $sentenceCount = preg_match_all('/[.!?]+/', $text);
        
        // Calculate basic metrics
        $avgWordLength = $wordCount > 0 ? round($charCount / $wordCount, 2) : 0;
        $avgSentenceLength = $sentenceCount > 0 ? round($wordCount / $sentenceCount, 2) : 0;
        
        // Analyze sentiment (simple algorithm)
        $positiveWords = ['good', 'great', 'excellent', 'amazing', 'wonderful', 'fantastic', 'perfect', 'love', 'like', 'happy', 'joy', 'beautiful', 'nice', 'awesome', 'brilliant'];
        $negativeWords = ['bad', 'terrible', 'awful', 'horrible', 'disgusting', 'hate', 'dislike', 'sad', 'angry', 'furious', 'ugly', 'nasty', 'worst', 'evil', 'pain'];
        
        $textLower = strtolower($text);
        $positiveCount = 0;
        $negativeCount = 0;
        
        foreach ($positiveWords as $word) {
            $positiveCount += substr_count($textLower, $word);
        }
        
        foreach ($negativeWords as $word) {
            $negativeCount += substr_count($textLower, $word);
        }
        
        // Calculate sentiment score (-100 to 100)
        $totalWords = $wordCount;
        $sentimentScore = $totalWords > 0 ? round((($positiveCount - $negativeCount) / $totalWords) * 100, 2) : 0;
        $sentimentScore = max(-100, min(100, $sentimentScore)); // Clamp between -100 and 100
        
        // Determine sentiment description
        if ($sentimentScore >= 20) {
            $sentimentDescription = 'Positive';
            $sentimentColor = 'green';
        } elseif ($sentimentScore <= -20) {
            $sentimentDescription = 'Negative';
            $sentimentColor = 'red';
        } else {
            $sentimentDescription = 'Neutral';
            $sentimentColor = 'gray';
        }
        
        // Analyze text complexity
        $complexityScore = $this->calculateComplexityScore($text);
        
        // Determine complexity level
        if ($complexityScore >= 70) {
            $complexityLevel = 'High';
            $complexityDescription = 'Complex vocabulary and sentence structure';
        } elseif ($complexityScore >= 40) {
            $complexityLevel = 'Medium';
            $complexityDescription = 'Moderate vocabulary and sentence structure';
        } else {
            $complexityLevel = 'Low';
            $complexityDescription = 'Simple vocabulary and sentence structure';
        }
        
        // Detect language (simple detection)
        $language = $this->detectLanguage($text);
        
        return [
            'original_text' => $text,
            'metrics' => [
                'word_count' => $wordCount,
                'character_count' => $charCount,
                'sentence_count' => $sentenceCount,
                'average_word_length' => $avgWordLength,
                'average_sentence_length' => $avgSentenceLength,
            ],
            'sentiment' => [
                'score' => $sentimentScore,
                'description' => $sentimentDescription,
                'color' => $sentimentColor,
                'positive_words_found' => $positiveCount,
                'negative_words_found' => $negativeCount,
            ],
            'complexity' => [
                'score' => $complexityScore,
                'level' => $complexityLevel,
                'description' => $complexityDescription,
            ],
            'language' => $language,
            'summary' => [
                'overall_assessment' => $this->generateOverallAssessment($sentimentScore, $complexityScore),
                'recommendations' => $this->generateRecommendations($sentimentScore, $complexityScore, $wordCount),
            ]
        ];
    }
    
    private function calculateComplexityScore($text)
    {
        $wordCount = str_word_count($text);
        $sentenceCount = preg_match_all('/[.!?]+/', $text);
        $avgSentenceLength = $sentenceCount > 0 ? $wordCount / $sentenceCount : 0;
        
        // Count long words (more than 6 characters)
        $words = str_word_count(strtolower($text), 1);
        $longWords = 0;
        foreach ($words as $word) {
            if (strlen($word) > 6) {
                $longWords++;
            }
        }
        
        $longWordPercentage = $wordCount > 0 ? ($longWords / $wordCount) * 100 : 0;
        
        // Calculate complexity score (0-100)
        $score = 0;
        $score += min(30, $avgSentenceLength * 2); // Sentence length factor
        $score += min(40, $longWordPercentage * 2); // Long word factor
        $score += min(30, $sentenceCount * 0.5); // Sentence variety factor
        
        return round(min(100, $score), 2);
    }
    
    private function detectLanguage($text)
    {
        // Simple language detection based on character patterns
        $text = strtolower($text);
        
        // Check for Cyrillic characters (Russian, Uzbek, etc.)
        if (preg_match('/[а-яё]/u', $text)) {
            return 'Cyrillic (Russian/Uzbek)';
        }
        
        // Check for Latin characters with special marks (Spanish, French, etc.)
        if (preg_match('/[àáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ]/u', $text)) {
            return 'Latin (Spanish/French)';
        }
        
        // Default to English
        return 'English';
    }
    
    private function generateOverallAssessment($sentimentScore, $complexityScore)
    {
        $assessments = [];
        
        // Sentiment assessment
        if ($sentimentScore >= 20) {
            $assessments[] = 'The text has a positive tone and conveys optimism.';
        } elseif ($sentimentScore <= -20) {
            $assessments[] = 'The text has a negative tone and may need revision for better impact.';
        } else {
            $assessments[] = 'The text maintains a neutral tone, suitable for factual content.';
        }
        
        // Complexity assessment
        if ($complexityScore >= 70) {
            $assessments[] = 'The text uses sophisticated language and complex sentence structures.';
        } elseif ($complexityScore >= 40) {
            $assessments[] = 'The text has moderate complexity, suitable for general audiences.';
        } else {
            $assessments[] = 'The text uses simple language, making it accessible to all readers.';
        }
        
        return implode(' ', $assessments);
    }
    
    private function generateRecommendations($sentimentScore, $complexityScore, $wordCount)
    {
        $recommendations = [];
        
        if ($wordCount < 10) {
            $recommendations[] = 'Consider adding more detail to provide comprehensive analysis.';
        }
        
        if ($sentimentScore <= -20) {
            $recommendations[] = 'Consider using more positive language to improve engagement.';
        }
        
        if ($complexityScore >= 70) {
            $recommendations[] = 'Consider simplifying language for broader audience accessibility.';
        } elseif ($complexityScore <= 20) {
            $recommendations[] = 'Consider adding more sophisticated vocabulary for professional contexts.';
        }
        
        if (empty($recommendations)) {
            $recommendations[] = 'The text is well-balanced and suitable for its intended purpose.';
        }
        
        return $recommendations;
    }
    
    public function status(Request $request)
    {
        // Get the API token from the Authorization header
        $token = $request->header('Authorization');
        if (!$token || !str_starts_with($token, 'Bearer ')) {
            return response()->json(['error' => 'Invalid authorization header'], 401);
        }
        
        $apiToken = substr($token, 7);
        
        // Find the project by API token
        $project = Project::where('api_token', $apiToken)->first();
        if (!$project) {
            return response()->json(['error' => 'Invalid API token'], 401);
        }
        
        return response()->json([
            'status' => 'success',
            'project' => [
                'name' => $project->name,
                'is_active' => $project->is_active,
                'requests_used' => $project->requests_used,
                'request_limit' => $project->request_limit,
                'usage_percentage' => $project->usage_percentage
            ]
        ]);
    }

    public function getRequestDetails($projectId, $requestId)
    {
        // Find the project
        $project = Project::findOrFail($projectId);
        
        // Find the request
        $request = ProjectRequest::where('id', $requestId)
            ->where('project_id', $project->id)
            ->firstOrFail();
        
        return response()->json([
            'method' => $request->method,
            'endpoint' => $request->endpoint,
            'request_data' => $request->request_data,
            'response_data' => $request->response_data,
            'response_code' => $request->response_code,
            'response_time' => $request->response_time,
            'ip_address' => $request->ip_address,
            'user_agent' => $request->user_agent,
            'created_at' => $request->created_at->format('Y-m-d H:i:s'),
        ]);
    }
} 