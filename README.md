# Portfolio Project

This is a portfolio project with a Laravel backend API and a React frontend.

## Project Structure

- **backend**: Laravel backend API for managing portfolio projects and user authentication
- **frontend**: React frontend for displaying and managing portfolio projects

## Getting Started

### Backend Setup

1. Navigate to the backend directory:
```bash
cd backend
```

2. Install dependencies:
```bash
composer install
```

3. Setup the environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in the .env file and run migrations:
```bash
php artisan migrate
```

5. Start the development server:
```bash
php artisan serve
```

The API will be accessible at http://localhost:8000/api

### Frontend Setup

1. Navigate to the frontend directory:
```bash
cd frontend
```

2. Install dependencies:
```bash
npm install
```

3. Start the development server:
```bash
npm start
```

The frontend will be accessible at http://localhost:3000

## API Endpoints

### Authentication
- `POST /api/login` - User login
- `POST /api/register` - User registration

### Projects
- `GET /api/projects` - Get all projects
- `GET /api/projects/{id}` - Get a specific project
- `POST /api/projects` - Create a new project (requires authentication)
- `PUT /api/projects/{id}` - Update a project (requires authentication)
- `DELETE /api/projects/{id}` - Delete a project (requires authentication)

## Frontend Features

- View all projects
- View project details
- User authentication (login and registration)
- Create, edit, and delete projects (for authenticated users)