<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\MakeProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait

class ProjectController extends Controller
{
    use AuthorizesRequests; // Use the trait
    //
    public function index()
    {
        $projects = Project::all();
        return ProjectResource::collection($projects);
    }

    public function store(MakeProjectRequest $request)
    {
        $newProject = $request->user()->projects()->create($request->validated());
        return ProjectResource::make($newProject);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $project->update($request->validated());
        return ProjectResource::make($project);
    }

    public function show(Project $project)
    {
        return ProjectResource::make($project);
    }
    
    public function delete(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }
}