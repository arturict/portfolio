import React, { useState } from 'react'
import { Plus, Edit, Trash2, Eye } from 'lucide-react'
import { Link } from 'react-router-dom'
import { useProjects } from '@/hooks/useProjects'
import { useAuth } from '@/contexts/AuthContext'
import ProjectForm from '@/components/ProjectForm'
import LoadingSpinner from '@/components/LoadingSpinner'
import type { Project, CreateProjectData } from '@/types'

const Dashboard: React.FC = () => {
  const { user } = useAuth()
  const { projects, isLoading, createProject, updateProject, deleteProject } = useProjects()
  const [showForm, setShowForm] = useState(false)
  const [editingProject, setEditingProject] = useState<Project | null>(null)
  const [isSubmitting, setIsSubmitting] = useState(false)

  const handleCreateProject = async (data: CreateProjectData) => {
    setIsSubmitting(true)
    try {
      const newProject = await createProject(data)
      if (newProject) {
        setShowForm(false)
      }
    } finally {
      setIsSubmitting(false)
    }
  }

  const handleUpdateProject = async (data: CreateProjectData) => {
    if (!editingProject) return
    
    setIsSubmitting(true)
    try {
      const updatedProject = await updateProject(editingProject.id, data)
      if (updatedProject) {
        setEditingProject(null)
      }
    } finally {
      setIsSubmitting(false)
    }
  }

  const handleDeleteProject = async (project: Project) => {
    if (window.confirm(`Are you sure you want to delete "${project.title}"?`)) {
      await deleteProject(project.id)
    }
  }

  const getStatusBadge = (status: Project['status']) => {
    const badges = {
      planned: 'badge-planned',
      current: 'badge-current',
      finished: 'badge-finished',
    }
    
    const labels = {
      planned: 'Planned',
      current: 'In Progress',
      finished: 'Completed',
    }

    return (
      <span className={`badge ${badges[status]}`}>
        {labels[status]}
      </span>
    )
  }

  if (isLoading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <LoadingSpinner size="lg" />
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-gray-50 py-8">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="mb-8">
          <h1 className="text-3xl font-bold text-gray-900">Dashboard</h1>
          <p className="text-gray-600 mt-2">Welcome back, {user?.name}!</p>
        </div>

        {/* Stats */}
        <div className="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <div className="card">
            <div className="text-2xl font-bold text-gray-900">{projects.length}</div>
            <div className="text-sm text-gray-600">Total Projects</div>
          </div>
          <div className="card">
            <div className="text-2xl font-bold text-blue-600">
              {projects.filter(p => p.status === 'current').length}
            </div>
            <div className="text-sm text-gray-600">In Progress</div>
          </div>
          <div className="card">
            <div className="text-2xl font-bold text-green-600">
              {projects.filter(p => p.status === 'finished').length}
            </div>
            <div className="text-sm text-gray-600">Completed</div>
          </div>
          <div className="card">
            <div className="text-2xl font-bold text-yellow-600">
              {projects.filter(p => p.status === 'planned').length}
            </div>
            <div className="text-sm text-gray-600">Planned</div>
          </div>
        </div>

        {/* Projects Section */}
        <div className="card">
          <div className="flex items-center justify-between mb-6">
            <h2 className="text-xl font-semibold text-gray-900">Your Projects</h2>
            <button
              onClick={() => setShowForm(true)}
              className="btn-primary"
            >
              <Plus className="h-4 w-4 mr-2" />
              Add Project
            </button>
          </div>

          {/* Project Form */}
          {(showForm || editingProject) && (
            <div className="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
              <h3 className="text-lg font-medium text-gray-900 mb-4">
                {editingProject ? 'Edit Project' : 'Create New Project'}
              </h3>
              <ProjectForm
                project={editingProject || undefined}
                onSubmit={editingProject ? handleUpdateProject : handleCreateProject}
                onCancel={() => {
                  setShowForm(false)
                  setEditingProject(null)
                }}
                isLoading={isSubmitting}
              />
            </div>
          )}

          {/* Projects List */}
          {projects.length > 0 ? (
            <div className="overflow-x-auto">
              <table className="min-w-full divide-y divide-gray-200">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Project
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Status
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Created
                    </th>
                    <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                  {projects.map((project) => (
                    <tr key={project.id} className="hover:bg-gray-50">
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div>
                          <div className="text-sm font-medium text-gray-900">
                            {project.title}
                          </div>
                          {project.description && (
                            <div className="text-sm text-gray-500 truncate max-w-xs">
                              {project.description}
                            </div>
                          )}
                        </div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        {getStatusBadge(project.status)}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {new Date(project.created_at).toLocaleDateString()}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div className="flex items-center justify-end space-x-2">
                          <Link
                            to={`/projects/${project.id}`}
                            className="text-primary-600 hover:text-primary-700 transition-colors"
                          >
                            <Eye className="h-4 w-4" />
                          </Link>
                          <button
                            onClick={() => setEditingProject(project)}
                            className="text-gray-600 hover:text-gray-700 transition-colors"
                          >
                            <Edit className="h-4 w-4" />
                          </button>
                          <button
                            onClick={() => handleDeleteProject(project)}
                            className="text-red-600 hover:text-red-700 transition-colors"
                          >
                            <Trash2 className="h-4 w-4" />
                          </button>
                        </div>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          ) : (
            <div className="text-center py-12">
              <div className="text-gray-400 mb-4">
                <Plus className="h-12 w-12 mx-auto" />
              </div>
              <h3 className="text-lg font-medium text-gray-900 mb-2">No projects yet</h3>
              <p className="text-gray-600 mb-4">Get started by creating your first project.</p>
              <button
                onClick={() => setShowForm(true)}
                className="btn-primary"
              >
                Create Project
              </button>
            </div>
          )}
        </div>
      </div>
    </div>
  )
}

export default Dashboard