<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\MakeProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
class ProjectController extends Controller
{
    //
    public function index()
    {
        $projects = Project::all();
        return response()->json($projects);

    }
    public function store(MakeProjectRequest $project)
    {
        $project = Project::create($project->validated());
        $project->save();
        return ProjectResource::make($project);

    }
    public function update(UpdateProjectRequest $project)
    {
        $project->update($project->validated());
        return  ProjectResource::make($project);
    }

    public function show(Project $project)
    {
        return ProjectResource::make($project);
    }
    
    public function delete(Project $project)
    {
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }
   
}