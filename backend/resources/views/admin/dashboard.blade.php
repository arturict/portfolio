@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Project Management</h1>
        <a href="{{ route('admin.projects.create') }}" 
           class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Project
        </a>
    </div>

    @if($projects->count() > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @foreach($projects as $project)
                    <li class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $project->title }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($project->status === 'current') bg-green-100 text-green-800
                                        @elseif($project->status === 'finished') bg-blue-100 text-blue-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </div>
                                <p class="mt-1 text-sm text-gray-600">{{ $project->description }}</p>
                                <div class="mt-2 flex space-x-4 text-sm text-gray-500">
                                    @if($project->demo_link)
                                        <a href="{{ $project->demo_link }}" target="_blank" 
                                           class="text-primary hover:text-blue-700">Demo</a>
                                    @endif
                                    @if($project->github_link)
                                        <a href="{{ $project->github_link }}" target="_blank" 
                                           class="text-primary hover:text-blue-700">GitHub</a>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4 flex space-x-2">
                                <a href="{{ route('admin.projects.edit', $project) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.projects.delete', $project) }}" 
                                      class="inline" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-lg font-medium text-gray-900 mb-2">No projects yet</h3>
            <p class="text-gray-600 mb-4">Get started by creating your first project.</p>
            <a href="{{ route('admin.projects.create') }}" 
               class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Project
            </a>
        </div>
    @endif
</div>
@endsection
