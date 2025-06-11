<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\MakeProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of all public projects (for portfolio view)
     */
    public function index()
    {
        $projects = Project::with('user:id,name')->get();
        return ProjectResource::collection($projects);
    }

    /**
     * Display projects for the authenticated user
     */
    public function userProjects(Request $request)
    {
        $user = $request->user();
        $projects = $user->projects()->get();
        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created project
     */
    public function store(MakeProjectRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        
        $project = Project::create($data);
        return ProjectResource::make($project->load('user:id,name'));
    }

    /**
     * Update the specified project
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        // Check if user owns the project
        if ($project->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validated();
        unset($data['name']); // Remove 'name' to avoid DB error
        $project->update($data);
        
        return ProjectResource::make($project->load('user:id,name'));
    }

    /**
     * Display the specified project
     */
    public function show(Project $project)
    {
        return ProjectResource::make($project->load('user:id,name'));
    }
    
    /**
     * Remove the specified project
     */
    public function delete(Request $request, Project $project)
    {
        // Check if user owns the project
        if ($project->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }
}