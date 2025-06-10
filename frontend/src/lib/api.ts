import axios from 'axios'
import type { 
  Project, 
  User, 
  AuthResponse, 
  CreateProjectData, 
  UpdateProjectData,
  LoginData,
  RegisterData 
} from '@/types'

const API_BASE_URL = import.meta.env.VITE_API_URL || '/api'

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

// Request interceptor to add auth token
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

// Response interceptor for error handling
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('auth_token')
      window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

// Auth API
export const authApi = {
  login: async (data: LoginData): Promise<AuthResponse> => {
    const response = await api.post<AuthResponse>('/login', data)
    return response.data
  },

  register: async (data: RegisterData): Promise<User> => {
    const response = await api.post<User>('/register', data)
    return response.data
  },

  logout: async (): Promise<void> => {
    await api.post('/logout')
  },

  getUser: async (): Promise<User> => {
    const response = await api.get<User>('/user')
    return response.data
  },
}

// Projects API
export const projectsApi = {
  getAll: async (): Promise<Project[]> => {
    const response = await api.get<{ data: Project[] }>('/projects')
    return response.data.data
  },

  getById: async (id: number): Promise<Project> => {
    const response = await api.get<{ data: Project }>(`/projects/${id}`)
    return response.data.data
  },

  create: async (data: CreateProjectData): Promise<Project> => {
    const response = await api.post<{ data: Project }>('/projects', data)
    return response.data.data
  },

  update: async (id: number, data: UpdateProjectData): Promise<Project> => {
    const response = await api.put<{ data: Project }>(`/projects/${id}`, data)
    return response.data.data
  },

  delete: async (id: number): Promise<void> => {
    await api.delete(`/projects/${id}`)
  },
}

export default api