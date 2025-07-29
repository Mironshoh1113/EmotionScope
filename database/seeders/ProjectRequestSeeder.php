<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\ProjectRequest;
use Carbon\Carbon;

class ProjectRequestSeeder extends Seeder
{
    public function run()
    {
        $projects = Project::all();
        
        foreach ($projects as $project) {
            // Create some test requests for each project
            for ($i = 0; $i < 10; $i++) {
                $responseCode = rand(1, 10) > 2 ? 200 : (rand(1, 2) > 1 ? 400 : 500);
                $responseTime = rand(50, 500);
                
                ProjectRequest::create([
                    'project_id' => $project->id,
                    'endpoint' => '/api/v1/analyze',
                    'method' => 'POST',
                    'request_data' => [
                        'text' => 'This is a test text for analysis. It contains both positive and negative words.'
                    ],
                    'response_data' => [
                        'status' => 'success',
                        'message' => 'Text analysis completed successfully',
                        'timestamp' => now()->toISOString(),
                        'project' => $project->name,
                        'analysis' => [
                            'original_text' => 'This is a test text for analysis.',
                            'metrics' => [
                                'word_count' => rand(5, 15),
                                'character_count' => rand(20, 100),
                                'sentence_count' => rand(1, 5),
                                'average_word_length' => rand(3, 6),
                                'average_sentence_length' => rand(5, 12)
                            ],
                            'sentiment' => [
                                'score' => rand(-50, 50),
                                'description' => rand(1, 3) > 1 ? 'Positive' : 'Negative',
                                'color' => rand(1, 3) > 1 ? 'green' : 'red',
                                'positive_words_found' => rand(0, 3),
                                'negative_words_found' => rand(0, 2)
                            ],
                            'complexity' => [
                                'score' => rand(20, 80),
                                'level' => ['Low', 'Medium', 'High'][rand(0, 2)],
                                'description' => 'Test complexity assessment'
                            ],
                            'language' => 'English',
                            'summary' => [
                                'overall_assessment' => 'Test assessment of the text.',
                                'recommendations' => ['Test recommendation']
                            ]
                        ]
                    ],
                    'response_code' => $responseCode,
                    'response_time' => $responseTime,
                    'ip_address' => '192.168.1.' . rand(1, 255),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'created_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59))
                ]);
            }
            
            // Update project request count
            $project->update(['requests_used' => $project->requests()->count()]);
        }
    }
} 