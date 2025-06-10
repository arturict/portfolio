export interface Project {
  id: number
  title: string
  description?: string
  demo_link?: string
  github_link?: string
  image?: string
  status: 'planned' | 'current' | 'finished'
  created_at: string
  updated_at: string
}

export interface User {
  id: number
  name: string
  email: string
  email_verified_at?: string
  created_at: string
  updated_at: string
}

export interface AuthResponse {
  token: string
}

export interface ApiResponse<T> {
  data: T
  message?: string
}

export interface PaginatedResponse<T> {
  data: T[]
  current_page: number
  last_page: number
  per_page: number
  total: number
}

export interface CreateProjectData {
  name: string
  description?: string
  demo_link?: string
  github_link?: string
  image?: string
  status: 'planned' | 'current' | 'finished'
}

export interface UpdateProjectData extends Partial<CreateProjectData> {}

export interface LoginData {
  email: string
  password: string
}

export interface RegisterData {
  name: string
  email: string
  password: string
}