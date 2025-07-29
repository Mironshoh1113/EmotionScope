<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\HomepageContent;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->is_admin) {
                abort(403, 'Sizda admin huquqi yo‘q!');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.index')->with('success', 'Foydalanuvchi o‘chirildi!');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = auth()->user();
        return view('admin.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'balance' => ['nullable', 'numeric', 'min:0'],
            'request_limit' => ['nullable', 'integer', 'min:1'],
            'requests_used' => ['nullable', 'integer', 'min:0'],
        ]);
        
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->balance = $data['balance'] ?? $user->balance;
        $user->request_limit = $data['request_limit'] ?? $user->request_limit;
        $user->requests_used = $data['requests_used'] ?? $user->requests_used;
        
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        
        $user->save();
        return redirect()->route('admin.profile')->with('success', __('admin.profile_updated_successfully'));
    }

    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-profile', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'is_admin' => ['required', 'boolean'],
            'balance' => ['nullable', 'numeric', 'min:0'],
            'request_limit' => ['nullable', 'integer', 'min:1'],
            'requests_used' => ['nullable', 'integer', 'min:0'],
        ]);
        
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->is_admin = $data['is_admin'];
        $user->balance = $data['balance'] ?? 0;
        $user->request_limit = $data['request_limit'] ?? 1000;
        $user->requests_used = $data['requests_used'] ?? 0;
        
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        
        $user->save();
        return redirect()->route('admin.users.show', $user->id)->with('success', __('admin.user_updated_successfully'));
    }

    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();
        return redirect()->route('admin.users.show', $user->id)->with('success', $user->is_blocked ? 'Foydalanuvchi bloklandi!' : 'Foydalanuvchi blokdan chiqarildi!');
    }

    public function userProjects($id)
    {
        $user = User::findOrFail($id);
        $projects = $user->projects()->with('requests')->paginate(10);
        
        // Check if viewing specific project
        if (request()->has('view_project')) {
            $projectId = request('view_project');
            $project = $user->projects()->findOrFail($projectId);
            return view('admin.user-project-details', compact('user', 'project'));
        }
        
        // Check if viewing project stats
        if (request()->has('stats_project')) {
            $projectId = request('stats_project');
            $project = $user->projects()->findOrFail($projectId);
            return view('admin.user-project-stats', compact('user', 'project'));
        }
        
        return view('admin.user-projects', compact('user', 'projects'));
    }

    public function userRequests($id)
    {
        $user = User::findOrFail($id);
        $requests = $user->requests()->with('project')->latest()->paginate(20);
        return view('admin.user-requests', compact('user', 'requests'));
    }

    public function userStats($id)
    {
        $user = User::findOrFail($id);
        
        // User statistics
        $totalRequests = $user->requests()->count();
        $successfulRequests = $user->requests()->where('response_code', '>=', 200)->where('response_code', '<', 300)->count();
        $failedRequests = $user->requests()->where('response_code', '>=', 400)->count();
        $avgResponseTime = $user->requests()->whereNotNull('response_time')->avg('response_time');
        
        // Project statistics
        $totalProjects = $user->projects()->count();
        $activeProjects = $user->projects()->where('is_active', true)->count();
        $totalProjectRequests = $user->projects()->withCount('requests')->get()->sum('requests_count');
        
        // Monthly stats
        $monthlyStats = \DB::table('project_requests')
            ->join('projects', 'projects.id', '=', 'project_requests.project_id')
            ->selectRaw('DATE(project_requests.created_at) as date, COUNT(*) as count')
            ->where('projects.user_id', $user->id)
            ->where('project_requests.created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.user-stats', compact(
            'user', 
            'totalRequests', 
            'successfulRequests', 
            'failedRequests', 
            'avgResponseTime',
            'totalProjects',
            'activeProjects',
            'totalProjectRequests',
            'monthlyStats'
        ));
    }

    public function allProjects()
    {
        $projects = \App\Models\Project::with(['user', 'requests'])
            ->withCount('requests')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.all-projects', compact('projects'));
    }

    public function allRequests()
    {
        $requests = \App\Models\ProjectRequest::with(['project.user'])
            ->latest()
            ->paginate(20);
        return view('admin.all-requests', compact('requests'));
    }

    public function dashboard()
    {
        // Overall statistics
        $totalUsers = User::count();
        $totalProjects = \App\Models\Project::count();
        $totalRequests = \App\Models\ProjectRequest::count();
        $activeProjects = \App\Models\Project::where('is_active', true)->count();
        
        // Recent activity
        $recentUsers = User::latest()->take(5)->get();
        $recentProjects = \App\Models\Project::with('user')->latest()->take(5)->get();
        $recentRequests = \App\Models\ProjectRequest::with(['project.user'])->latest()->take(10)->get();
        
        // Monthly stats
        $monthlyStats = \App\Models\ProjectRequest::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProjects', 
            'totalRequests',
            'activeProjects',
            'recentUsers',
            'recentProjects',
            'recentRequests',
            'monthlyStats'
        ));
    }

    public function getRequestDetails($projectId, $requestId)
    {
        $project = \App\Models\Project::findOrFail($projectId);
        $request = \App\Models\ProjectRequest::findOrFail($requestId);
        
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

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'boolean',
            'balance' => 'numeric|min:0',
            'request_limit' => 'integer|min:1',
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->is_admin = $validated['is_admin'];
        $user->balance = $validated['balance'];
        $user->request_limit = $validated['request_limit'];
        
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        
        $user->save();
        
        return redirect()->route('admin.users.show', $user->id)
            ->with('success', __('admin.user_updated_successfully'));
    }
} 