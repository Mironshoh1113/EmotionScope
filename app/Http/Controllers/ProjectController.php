<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->projects()->latest()->paginate(10);
        return view('profile.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('profile.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'request_limit' => 'required|integer|min:1|max:100000',
        ]);

        $project = Auth::user()->projects()->create([
            'name' => $request->name,
            'description' => $request->description,
            'api_token' => Project::generateApiToken(),
            'request_limit' => $request->request_limit,
        ]);

        return redirect()->route('profile.projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        
        $recentRequests = $project->requests()->latest()->take(10)->get();
        $stats = [
            'total_requests' => $project->requests()->count(),
            'successful_requests' => $project->requests()->where('response_code', '>=', 200)->where('response_code', '<', 300)->count(),
            'failed_requests' => $project->requests()->where('response_code', '>=', 400)->count(),
            'avg_response_time' => $project->requests()->whereNotNull('response_time')->avg('response_time'),
        ];

        return view('profile.projects.show', compact('project', 'recentRequests', 'stats'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('profile.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'webhook_url' => 'nullable|url',
            'request_limit' => 'required|integer|min:1|max:100000',
            'is_active' => 'boolean',
        ]);

        $project->update($request->all());

        return redirect()->route('profile.projects.show', $project)
            ->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        
        $project->delete();
        return redirect()->route('profile.projects.index')
            ->with('success', 'Project deleted successfully!');
    }

    public function regenerateToken(Project $project)
    {
        $this->authorize('update', $project);
        
        $project->update(['api_token' => Project::generateApiToken()]);
        
        return redirect()->route('profile.projects.show', $project)
            ->with('success', 'API token regenerated successfully!');
    }

    public function requests(Project $project)
    {
        $this->authorize('view', $project);
        
        $requests = $project->requests()->latest()->paginate(20);
        return view('profile.projects.requests', compact('project', 'requests'));
    }

    public function settings(Project $project)
    {
        $this->authorize('update', $project);
        return view('profile.projects.settings', compact('project'));
    }

    public function updateSettings(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'settings' => 'nullable|array',
        ]);

        $project->update(['settings' => $request->settings]);

        return redirect()->route('profile.projects.settings', $project)
            ->with('success', 'Settings updated successfully!');
    }

    public function stats(Project $project)
    {
        $this->authorize('view', $project);
        
        $monthlyStats = $project->requests()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $endpointStats = $project->requests()
            ->selectRaw('endpoint, COUNT(*) as count')
            ->groupBy('endpoint')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        $responseCodeStats = $project->requests()
            ->selectRaw('response_code, COUNT(*) as count')
            ->groupBy('response_code')
            ->orderByDesc('count')
            ->get();

        return view('profile.projects.stats', compact('project', 'monthlyStats', 'endpointStats', 'responseCodeStats'));
    }

    public function getRequestDetails(Project $project, ProjectRequest $request)
    {
        $this->authorize('view', $project);
        
        // Ensure the request belongs to the project
        if ($request->project_id !== $project->id) {
            abort(404);
        }
        
        return response()->json([
            'request_data' => $request->request_data,
            'response_data' => $request->response_data,
            'method' => $request->method,
            'endpoint' => $request->endpoint,
            'response_code' => $request->response_code,
            'response_time' => $request->response_time,
            'ip_address' => $request->ip_address,
            'user_agent' => $request->user_agent,
            'created_at' => $request->created_at->format('Y-m-d H:i:s'),
        ]);
    }
} 