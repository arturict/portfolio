import { useState, useEffect } from 'react'
import { projectsApi } from '@/lib/api'
import type { Project, CreateProjectData, UpdateProjectData } from '@/types'
import toast from 'react-hot-toast'

export const useProjects = () => {
  const [projects, setProjects] = useState<Project[]>([])
  const [isLoading, setIsLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  const fetchProjects = async () => {
    try {
      setIsLoading(true)
      setError(null)
      const data = await projectsApi.getUserProjects()
      setProjects(data)
    } catch (err: any) {
      const message = err.response?.data?.message || 'Failed to fetch projects'
      setError(message)
      toast.error(message)
    } finally {
      setIsLoading(false)
    }
  }

  const createProject = async (data: CreateProjectData): Promise<Project | null> => {
    try {
      const newProject = await projectsApi.create(data)
      setProjects(prev => [newProject, ...prev])
      toast.success('Project created successfully!')
      return newProject
    } catch (err: any) {
      const message = err.response?.data?.message || 'Failed to create project'
      toast.error(message)
      return null
    }
  }

  const updateProject = async (id: number, data: UpdateProjectData): Promise<Project | null> => {
    try {
      const updatedProject = await projectsApi.update(id, data)
      setProjects(prev => 
        prev.map(project => 
          project.id === id ? updatedProject : project
        )
      )
      toast.success('Project updated successfully!')
      return updatedProject
    } catch (err: any) {
      const message = err.response?.data?.message || 'Failed to update project'
      toast.error(message)
      return null
    }
  }

  const deleteProject = async (id: number): Promise<boolean> => {
    try {
      await projectsApi.delete(id)
      setProjects(prev => prev.filter(project => project.id !== id))
      toast.success('Project deleted successfully!')
      return true
    } catch (err: any) {
      const message = err.response?.data?.message || 'Failed to delete project'
      toast.error(message)
      return false
    }
  }

  useEffect(() => {
    fetchProjects()
  }, [])

  return {
    projects,
    isLoading,
    error,
    fetchProjects,
    createProject,
    updateProject,
    deleteProject,
  }
}

export const useProject = (id: number) => {
  const [project, setProject] = useState<Project | null>(null)
  const [isLoading, setIsLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    const fetchProject = async () => {
      try {
        setIsLoading(true)
        setError(null)
        const data = await projectsApi.getById(id)
        setProject(data)
      } catch (err: any) {
        const message = err.response?.data?.message || 'Failed to fetch project'
        setError(message)
        toast.error(message)
      } finally {
        setIsLoading(false)
      }
    }

    if (id) {
      fetchProject()
    }
  }, [id])

  return { project, isLoading, error }
}

// Hook for public projects (portfolio view)
export const usePublicProjects = () => {
  const [projects, setProjects] = useState<Project[]>([])
  const [isLoading, setIsLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  const fetchProjects = async () => {
    try {
      setIsLoading(true)
      setError(null)
      const data = await projectsApi.getAll()
      setProjects(data)
    } catch (err: any) {
      const message = err.response?.data?.message || 'Failed to fetch projects'
      setError(message)
      console.error('Error fetching public projects:', message)
    } finally {
      setIsLoading(false)
    }
  }

  useEffect(() => {
    fetchProjects()
  }, [])

  return {
    projects,
    isLoading,
    error,
    fetchProjects,
  }
}