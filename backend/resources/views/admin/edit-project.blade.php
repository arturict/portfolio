@extends('layouts.admin')

@section('title', 'Edit Project')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Project</h1>
        <a href="{{ route('admin.dashboard') }}" 
           class="text-gray-600 hover:text-gray-800">← Back to Dashboard</a>
    </div>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                <input type="text" name="title" id="title" required 
                       value="{{ old('title', $project->title) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">{{ old('description', $project->description) }}</textarea>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                <select name="status" id="status" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    <option value="planned" {{ old('status', $project->status) === 'planned' ? 'selected' : '' }}>Planned</option>
                    <option value="current" {{ old('status', $project->status) === 'current' ? 'selected' : '' }}>Current</option>
                    <option value="finished" {{ old('status', $project->status) === 'finished' ? 'selected' : '' }}>Finished</option>
                </select>
            </div>

            <div>
                <label for="demo_link" class="block text-sm font-medium text-gray-700">Demo Link</label>
                <input type="url" name="demo_link" id="demo_link" 
                       value="{{ old('demo_link', $project->demo_link) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label for="github_link" class="block text-sm font-medium text-gray-700">GitHub Link</label>
                <input type="url" name="github_link" id="github_link" 
                       value="{{ old('github_link', $project->github_link) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image URL</label>
                <input type="url" name="image" id="image" 
                       value="{{ old('image', $project->image) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.dashboard') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
