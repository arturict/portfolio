import React from 'react'
import { useForm } from 'react-hook-form'
import { zodResolver } from '@hookform/resolvers/zod'
import { z } from 'zod'
import type { CreateProjectData, Project } from '@/types'

const projectSchema = z.object({
  name: z.string().min(1, 'Project name is required').max(255, 'Name too long'),
  description: z.string().max(255, 'Description too long').optional(),
  demo_link: z.string().url('Invalid URL').or(z.literal('')).optional(),
  github_link: z.string().url('Invalid URL').or(z.literal('')).optional(),
  image: z.string().url('Invalid URL').or(z.literal('')).optional(),
  status: z.enum(['planned', 'current', 'finished']),
})

type ProjectFormData = z.infer<typeof projectSchema>

interface ProjectFormProps {
  project?: Project
  onSubmit: (data: CreateProjectData) => Promise<void>
  onCancel: () => void
  isLoading?: boolean
}

const ProjectForm: React.FC<ProjectFormProps> = ({
  project,
  onSubmit,
  onCancel,
  isLoading = false,
}) => {
  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<ProjectFormData>({
    resolver: zodResolver(projectSchema),
    defaultValues: project ? {
      name: project.title,
      description: project.description || '',
      demo_link: project.demo_link || '',
      github_link: project.github_link || '',
      image: project.image || '',
      status: project.status,
    } : {
      status: 'planned',
    },
  })

  const handleFormSubmit = async (data: ProjectFormData) => {
    await onSubmit({
      ...data,
      // Convert empty strings to undefined
      description: data.description || undefined,
      demo_link: data.demo_link || undefined,
      github_link: data.github_link || undefined,
      image: data.image || undefined,
    })
  }

  return (
    <form onSubmit={handleSubmit(handleFormSubmit)} className="space-y-6">
      {/* Project Name */}
      <div>
        <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-1">
          Project Name *
        </label>
        <input
          {...register('name')}
          type="text"
          id="name"
          className="input"
          placeholder="Enter project name"
        />
        {errors.name && (
          <p className="mt-1 text-sm text-red-600">{errors.name.message}</p>
        )}
      </div>

      {/* Description */}
      <div>
        <label htmlFor="description" className="block text-sm font-medium text-gray-700 mb-1">
          Description
        </label>
        <textarea
          {...register('description')}
          id="description"
          rows={3}
          className="textarea"
          placeholder="Describe your project"
        />
        {errors.description && (
          <p className="mt-1 text-sm text-red-600">{errors.description.message}</p>
        )}
      </div>

      {/* Status */}
      <div>
        <label htmlFor="status" className="block text-sm font-medium text-gray-700 mb-1">
          Status *
        </label>
        <select {...register('status')} id="status" className="select">
          <option value="planned">Planned</option>
          <option value="current">In Progress</option>
          <option value="finished">Completed</option>
        </select>
        {errors.status && (
          <p className="mt-1 text-sm text-red-600">{errors.status.message}</p>
        )}
      </div>

      {/* Demo Link */}
      <div>
        <label htmlFor="demo_link" className="block text-sm font-medium text-gray-700 mb-1">
          Demo Link
        </label>
        <input
          {...register('demo_link')}
          type="url"
          id="demo_link"
          className="input"
          placeholder="https://example.com"
        />
        {errors.demo_link && (
          <p className="mt-1 text-sm text-red-600">{errors.demo_link.message}</p>
        )}
      </div>

      {/* GitHub Link */}
      <div>
        <label htmlFor="github_link" className="block text-sm font-medium text-gray-700 mb-1">
          GitHub Link
        </label>
        <input
          {...register('github_link')}
          type="url"
          id="github_link"
          className="input"
          placeholder="https://github.com/username/repo"
        />
        {errors.github_link && (
          <p className="mt-1 text-sm text-red-600">{errors.github_link.message}</p>
        )}
      </div>

      {/* Image URL */}
      <div>
        <label htmlFor="image" className="block text-sm font-medium text-gray-700 mb-1">
          Image URL
        </label>
        <input
          {...register('image')}
          type="url"
          id="image"
          className="input"
          placeholder="https://example.com/image.jpg"
        />
        {errors.image && (
          <p className="mt-1 text-sm text-red-600">{errors.image.message}</p>
        )}
      </div>

      {/* Form Actions */}
      <div className="flex items-center justify-end space-x-3 pt-4">
        <button
          type="button"
          onClick={onCancel}
          className="btn-outline"
          disabled={isLoading}
        >
          Cancel
        </button>
        <button
          type="submit"
          className="btn-primary"
          disabled={isLoading}
        >
          {isLoading ? 'Saving...' : project ? 'Update Project' : 'Create Project'}
        </button>
      </div>
    </form>
  )
}

export default ProjectForm