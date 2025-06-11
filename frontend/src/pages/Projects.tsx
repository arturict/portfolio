import React, { useState } from 'react'
import { Search, Filter } from 'lucide-react'
import { usePublicProjects } from '@/hooks/useProjects'
import ProjectCard from '@/components/ProjectCard'
import LoadingSpinner from '@/components/LoadingSpinner'
import type { Project } from '@/types'

const Projects: React.FC = () => {
  const { projects, isLoading, error } = usePublicProjects()
  const [searchTerm, setSearchTerm] = useState('')
  const [statusFilter, setStatusFilter] = useState<Project['status'] | 'all'>('all')

  const filteredProjects = projects.filter((project) => {
    const matchesSearch = project.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         project.description?.toLowerCase().includes(searchTerm.toLowerCase())
    const matchesStatus = statusFilter === 'all' || project.status === statusFilter
    
    return matchesSearch && matchesStatus
  })

  const getProjectCount = (status: Project['status'] | 'all') => {
    if (status === 'all') return projects.length
    return projects.filter(p => p.status === status).length
  }

  if (isLoading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <LoadingSpinner size="lg" />
      </div>
    )
  }

  if (error) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h2 className="text-2xl font-bold text-gray-900 mb-2">Something went wrong</h2>
          <p className="text-gray-600">{error}</p>
        </div>
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-gray-50 py-12">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-12">
          <h1 className="text-4xl font-bold text-gray-900 mb-4">My Projects</h1>
          <p className="text-lg text-gray-600 max-w-2xl mx-auto">
            A collection of web applications and projects I've built using modern technologies.
          </p>
        </div>

        {/* Filters */}
        <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
          <div className="flex flex-col lg:flex-row gap-4">
            {/* Search */}
            <div className="flex-1">
              <div className="relative">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
                <input
                  type="text"
                  placeholder="Search projects..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="input pl-10"
                />
              </div>
            </div>

            {/* Status Filter */}
            <div className="lg:w-64">
              <div className="relative">
                <Filter className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
                <select
                  value={statusFilter}
                  onChange={(e) => setStatusFilter(e.target.value as Project['status'] | 'all')}
                  className="select pl-10"
                >
                  <option value="all">All Projects ({getProjectCount('all')})</option>
                  <option value="finished">Completed ({getProjectCount('finished')})</option>
                  <option value="current">In Progress ({getProjectCount('current')})</option>
                  <option value="planned">Planned ({getProjectCount('planned')})</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        {/* Projects Grid */}
        {filteredProjects.length > 0 ? (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {filteredProjects.map((project) => (
              <ProjectCard key={project.id} project={project} />
            ))}
          </div>
        ) : (
          <div className="text-center py-12">
            <div className="text-gray-400 mb-4">
              <Search className="h-12 w-12 mx-auto" />
            </div>
            <h3 className="text-lg font-medium text-gray-900 mb-2">No projects found</h3>
            <p className="text-gray-600">
              {searchTerm || statusFilter !== 'all'
                ? 'Try adjusting your search or filter criteria.'
                : 'No projects have been added yet.'}
            </p>
          </div>
        )}
      </div>
    </div>
  )
}

export default Projects