# API Documentation

This document provides comprehensive documentation for the Portfolio application's REST API.

## 🔗 Base URL

- **Development**: `http://localhost:8000/api`
- **Production**: `https://your-domain.com/api`

## 🔐 Authentication

The API uses Laravel Sanctum for authentication. Most endpoints require authentication via Bearer token.

### Authentication Endpoints

#### Register User
```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response (201 Created):**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2023-12-01T10:00:00.000000Z",
    "updated_at": "2023-12-01T10:00:00.000000Z"
  },
  "token": "1|abcdef123456..."
}
```

#### Login User
```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200 OK):**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2023-12-01T10:00:00.000000Z",
    "updated_at": "2023-12-01T10:00:00.000000Z"
  },
  "token": "2|ghijkl789012..."
}
```

#### Logout User
```http
POST /api/logout
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "message": "Successfully logged out"
}
```

### Using Authentication

Include the Bearer token in the Authorization header:
```http
Authorization: Bearer 1|abcdef123456...
```

## 📋 Project Endpoints

### Get All Projects

```http
GET /api/projects
```

**Parameters:**
- `page` (optional): Page number for pagination
- `per_page` (optional): Items per page (default: 15, max: 100)
- `status` (optional): Filter by status (`active`, `inactive`, `completed`)
- `search` (optional): Search in title and description

**Example:**
```http
GET /api/projects?page=1&per_page=10&status=active&search=web
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Portfolio Website",
      "description": "A modern portfolio website built with Laravel and React",
      "image": "https://example.com/storage/projects/portfolio.jpg",
      "demo_link": "https://portfolio.example.com",
      "github_link": "https://github.com/user/portfolio",
      "status": "active",
      "technologies": ["Laravel", "React", "Tailwind CSS"],
      "created_at": "2023-12-01T10:00:00.000000Z",
      "updated_at": "2023-12-01T10:00:00.000000Z"
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/projects?page=1",
    "last": "http://localhost:8000/api/projects?page=3",
    "prev": null,
    "next": "http://localhost:8000/api/projects?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 3,
    "per_page": 15,
    "to": 15,
    "total": 42
  }
}
```

### Get Single Project

```http
GET /api/projects/{id}
```

**Parameters:**
- `id` (required): Project ID

**Response (200 OK):**
```json
{
  "data": {
    "id": 1,
    "title": "Portfolio Website",
    "description": "A modern portfolio website built with Laravel and React",
    "image": "https://example.com/storage/projects/portfolio.jpg",
    "demo_link": "https://portfolio.example.com",
    "github_link": "https://github.com/user/portfolio",
    "status": "active",
    "technologies": ["Laravel", "React", "Tailwind CSS"],
    "created_at": "2023-12-01T10:00:00.000000Z",
    "updated_at": "2023-12-01T10:00:00.000000Z"
  }
}
```

**Error Response (404 Not Found):**
```json
{
  "message": "Project not found"
}
```

### Create Project

```http
POST /api/projects
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "New Project",
  "description": "Description of the new project",
  "image": "https://example.com/image.jpg",
  "demo_link": "https://demo.example.com",
  "github_link": "https://github.com/user/project",
  "status": "active",
  "technologies": ["Vue.js", "Node.js"]
}
```

**Validation Rules:**
- `title`: required, string, max:255
- `description`: required, string
- `image`: nullable, url
- `demo_link`: nullable, url
- `github_link`: nullable, url
- `status`: required, in:active,inactive,completed
- `technologies`: nullable, array

**Response (201 Created):**
```json
{
  "data": {
    "id": 2,
    "title": "New Project",
    "description": "Description of the new project",
    "image": "https://example.com/image.jpg",
    "demo_link": "https://demo.example.com",
    "github_link": "https://github.com/user/project",
    "status": "active",
    "technologies": ["Vue.js", "Node.js"],
    "created_at": "2023-12-01T11:00:00.000000Z",
    "updated_at": "2023-12-01T11:00:00.000000Z"
  }
}
```

**Validation Error Response (422 Unprocessable Entity):**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."],
    "status": ["The selected status is invalid."]
  }
}
```

### Update Project

```http
PUT /api/projects/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Updated Project Title",
  "description": "Updated description",
  "status": "completed"
}
```

**Parameters:**
- `id` (required): Project ID

**Validation Rules:** Same as create, but all fields are optional

**Response (200 OK):**
```json
{
  "data": {
    "id": 1,
    "title": "Updated Project Title",
    "description": "Updated description",
    "image": "https://example.com/storage/projects/portfolio.jpg",
    "demo_link": "https://portfolio.example.com",
    "github_link": "https://github.com/user/portfolio",
    "status": "completed",
    "technologies": ["Laravel", "React", "Tailwind CSS"],
    "created_at": "2023-12-01T10:00:00.000000Z",
    "updated_at": "2023-12-01T11:30:00.000000Z"
  }
}
```

### Delete Project

```http
DELETE /api/projects/{id}
Authorization: Bearer {token}
```

**Parameters:**
- `id` (required): Project ID

**Response (200 OK):**
```json
{
  "message": "Project deleted successfully"
}
```

**Error Response (404 Not Found):**
```json
{
  "message": "Project not found"
}
```

## 👤 User Endpoints

### Get Current User

```http
GET /api/user
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2023-12-01T10:00:00.000000Z",
    "updated_at": "2023-12-01T10:00:00.000000Z"
  }
}
```

### Update User Profile

```http
PUT /api/user
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "John Smith",
  "email": "johnsmith@example.com"
}
```

**Validation Rules:**
- `name`: required, string, max:255
- `email`: required, email, unique:users,email,{current_user_id}

**Response (200 OK):**
```json
{
  "data": {
    "id": 1,
    "name": "John Smith",
    "email": "johnsmith@example.com",
    "created_at": "2023-12-01T10:00:00.000000Z",
    "updated_at": "2023-12-01T12:00:00.000000Z"
  }
}
```

## ❌ Error Responses

### Common HTTP Status Codes

- `200 OK` - Request successful
- `201 Created` - Resource created successfully
- `400 Bad Request` - Invalid request format
- `401 Unauthorized` - Authentication required or invalid
- `403 Forbidden` - Access denied
- `404 Not Found` - Resource not found
- `422 Unprocessable Entity` - Validation errors
- `429 Too Many Requests` - Rate limit exceeded
- `500 Internal Server Error` - Server error

### Error Response Format

**Authentication Error (401):**
```json
{
  "message": "Unauthenticated."
}
```

**Validation Error (422):**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field_name": [
      "Error message 1",
      "Error message 2"
    ]
  }
}
```

**Server Error (500):**
```json
{
  "message": "Server Error"
}
```

## 🔄 Rate Limiting

The API implements rate limiting to prevent abuse:

- **Authentication endpoints**: 5 requests per minute
- **General API endpoints**: 60 requests per minute for authenticated users
- **Public endpoints**: 30 requests per minute for unauthenticated users

Rate limit headers are included in responses:
```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
X-RateLimit-Reset: 1638360000
```

## 📝 Request/Response Examples

### cURL Examples

**Get all projects:**
```bash
curl -X GET "http://localhost:8000/api/projects" \
  -H "Accept: application/json"
```

**Create project with authentication:**
```bash
curl -X POST "http://localhost:8000/api/projects" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer 1|abcdef123456..." \
  -d '{
    "title": "My New Project",
    "description": "This is a test project",
    "status": "active"
  }'
```

### JavaScript/Axios Examples

**Setup API client:**
```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
});

// Add auth token to requests
api.interceptors.request.use(config => {
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});
```

**Fetch projects:**
```javascript
const fetchProjects = async () => {
  try {
    const response = await api.get('/projects');
    return response.data;
  } catch (error) {
    console.error('Error fetching projects:', error);
    throw error;
  }
};
```

**Create project:**
```javascript
const createProject = async (projectData) => {
  try {
    const response = await api.post('/projects', projectData);
    return response.data;
  } catch (error) {
    if (error.response?.status === 422) {
      // Handle validation errors
      console.error('Validation errors:', error.response.data.errors);
    }
    throw error;
  }
};
```

### PHP/Laravel Examples

**Using HTTP Client:**
```php
use Illuminate\Support\Facades\Http;

$response = Http::withToken($authToken)
    ->post('http://localhost:8000/api/projects', [
        'title' => 'My Project',
        'description' => 'Project description',
        'status' => 'active'
    ]);

if ($response->successful()) {
    $project = $response->json('data');
} else {
    $errors = $response->json('errors');
}
```

## 🧪 Testing the API

### Postman Collection

You can import this Postman collection to test the API:

```json
{
  "info": {
    "name": "Portfolio API",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "auth": {
    "type": "bearer",
    "bearer": [
      {
        "key": "token",
        "value": "{{auth_token}}",
        "type": "string"
      }
    ]
  },
  "variable": [
    {
      "key": "base_url",
      "value": "http://localhost:8000/api"
    },
    {
      "key": "auth_token",
      "value": ""
    }
  ]
}
```

### API Testing Tools

1. **Postman** - GUI-based API testing
2. **Insomnia** - Alternative to Postman
3. **cURL** - Command-line testing
4. **HTTPie** - User-friendly CLI tool
5. **Laravel Telescope** - Debug API calls during development

## 📊 OpenAPI/Swagger Documentation

For interactive API documentation, you can generate OpenAPI/Swagger docs:

```bash
cd backend
composer require --dev darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
php artisan l5-swagger:generate
```

Access the interactive documentation at `/api/documentation`

## 🔍 Debugging

### Enable Debug Mode

In development, set `APP_DEBUG=true` in `.env` for detailed error messages.

### Laravel Telescope

Access detailed request information at `/telescope` during development.

### Log Files

Check Laravel logs for API errors:
```bash
tail -f backend/storage/logs/laravel.log
```