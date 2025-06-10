import React from 'react'
import { Link } from 'react-router-dom'
import { ExternalLink, Github, Calendar } from 'lucide-react'
import type { Project } from '@/types'

interface ProjectCardProps {
  project: Project
}

const ProjectCard: React.FC<ProjectCardProps> = ({ project }) => {
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

  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
    })
  }

  return (
    <div className="card group hover:shadow-lg transition-all duration-300">
      {/* Project Image */}
      {project.image && (
        <div className="aspect-video w-full mb-4 overflow-hidden rounded-lg bg-gray-100">
          <img
            src={project.image}
            alt={project.title}
            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
          />
        </div>
      )}

      {/* Project Content */}
      <div className="space-y-3">
        {/* Header */}
        <div className="flex items-start justify-between">
          <h3 className="text-lg font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
            <Link to={`/projects/${project.id}`} className="hover:underline">
              {project.title}
            </Link>
          </h3>
          {getStatusBadge(project.status)}
        </div>

        {/* Description */}
        {project.description && (
          <p className="text-gray-600 text-sm line-clamp-3">
            {project.description}
          </p>
        )}

        {/* Date */}
        <div className="flex items-center text-xs text-gray-500">
          <Calendar className="h-3 w-3 mr-1" />
          {formatDate(project.created_at)}
        </div>

        {/* Links */}
        <div className="flex items-center space-x-3 pt-2">
          {project.demo_link && (
            <a
              href={project.demo_link}
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center text-sm text-primary-600 hover:text-primary-700 transition-colors"
            >
              <ExternalLink className="h-4 w-4 mr-1" />
              Demo
            </a>
          )}
          {project.github_link && (
            <a
              href={project.github_link}
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center text-sm text-gray-600 hover:text-gray-700 transition-colors"
            >
              <Github className="h-4 w-4 mr-1" />
              Code
            </a>
          )}
        </div>
      </div>
    </div>
  )
}

export default ProjectCard