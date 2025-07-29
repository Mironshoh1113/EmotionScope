<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'min:6', 'confirmed'],
        ]);
        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();
        return redirect()->route('profile.show')->with('success', 'Profil yangilandi!');
    }

    public function info()
    {
        $user = Auth::user();
        return view('profile.info', compact('user'));
    }
    
    public function balance()
    {
        $user = Auth::user();
        return view('profile.balance', compact('user'));
    }

    public function apiTest()
    {
        $user = Auth::user();
        $projects = $user->projects()->where('is_active', true)->get();
        return view('profile.api-test', compact('user', 'projects'));
    }

    public function testApi(Request $request)
    {
        // Increase PHP execution time for API requests
        set_time_limit(120); // 2 minutes
        ini_set('max_execution_time', 120);
        
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'text' => 'required|string|max:10000',
        ]);

        $user = Auth::user();
        $project = $user->projects()->findOrFail($request->project_id);

        if (!$project->is_active) {
            return response()->json(['success' => false, 'error' => 'Project is not active']);
        }

        // Check if user has remaining requests
        if (!$user->canMakeRequest()) {
            return response()->json(['success' => false, 'error' => 'User request limit exceeded']);
        }

        if (!$project->canMakeRequest()) {
            return response()->json(['success' => false, 'error' => 'Project request limit exceeded']);
        }

        // Call ApiController directly
        try {
            \Log::info('Calling ApiController directly', [
                'project_id' => $project->id,
                'text_length' => strlen($request->text)
            ]);
            
            // Create a new request for the API
            $apiRequest = new \Illuminate\Http\Request();
            $apiRequest->merge(['text' => $request->text]);
            $apiRequest->headers->set('Authorization', 'Bearer ' . $project->api_token);
            $apiRequest->headers->set('Content-Type', 'application/json');
            $apiRequest->headers->set('Accept', 'application/json');
            
            // Call the ApiController
            $apiController = new \App\Http\Controllers\ApiController();
            $apiResponse = $apiController->analyzeText($apiRequest);
            
            \Log::info('API response received', [
                'status' => $apiResponse->getStatusCode(),
                'body' => $apiResponse->getContent()
            ]);
            
            $responseData = json_decode($apiResponse->getContent(), true);
            $httpCode = $apiResponse->getStatusCode();
            
        } catch (\Exception $e) {
            \Log::error('API request failed', [
                'error' => $e->getMessage(),
                'project_id' => $project->id
            ]);
            return response()->json(['success' => false, 'error' => 'API request timeout or error: ' . $e->getMessage()]);
        }

        // Increment user's request count
        $user->increment('requests_used');
        
        $result = [
            'status_code' => $httpCode,
            'response_data' => $responseData,
            'project_name' => $project->name,
            'text' => $request->text,
        ];

        return response()->json(['success' => true, 'result' => $result]);
    }
} 