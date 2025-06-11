<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['login']);
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        return view('admin.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $projects = Project::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('projects'));
    }

    public function createProject(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'demo_link' => 'nullable|url|max:255',
                'github_link' => 'nullable|url|max:255',
                'image' => 'nullable|url|max:255',
                'status' => 'required|string|in:planned,current,finished',
            ]);

            $validated['user_id'] = Auth::id();

            Project::create($validated);

            return redirect('/admin/dashboard')->with('success', 'Project created successfully!');
        }

        return view('admin.create-project');
    }

    public function editProject(Request $request, Project $project)
    {
        // Ensure user owns the project
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'demo_link' => 'nullable|url|max:255',
                'github_link' => 'nullable|url|max:255',
                'image' => 'nullable|url|max:255',
                'status' => 'required|string|in:planned,current,finished',
            ]);

            $project->update($validated);

            return redirect('/admin/dashboard')->with('success', 'Project updated successfully!');
        }

        return view('admin.edit-project', compact('project'));
    }

    public function deleteProject(Project $project)
    {
        // Ensure user owns the project
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $project->delete();
        return redirect('/admin/dashboard')->with('success', 'Project deleted successfully!');
    }
}
