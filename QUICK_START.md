# Portfolio Application - Quick Start

This is a Laravel + React portfolio application that can be started with a single Docker command.

## Prerequisites

- Docker
- Docker Compose

**No PHP or Node.js installation required!**

## Quick Start

The application now uses **separate containers** for frontend and backend as requested.

### Option 1: Use the start script (recommended)
```bash
./start.sh
```

### Option 2: Manual Docker Compose
```bash
docker compose up --build
```

## Access Points

- **Frontend**: http://localhost:3000 (React dev server)
- **Backend API**: http://localhost:8080/api 
- **Admin Panel**: http://localhost:8080/admin (login with admin123)
- **Health Check**: http://localhost:8080/health

## Container Architecture

- **Backend Container** (port 8080): Laravel API + Admin with SQLite
- **Frontend Container** (port 3000): React application
- **Database**: SQLite persisted in Docker volumes
- **Admin Configuration**: Only manual step required

## Admin Setup

- **Default**: Email: `artur@ferreiracruz.com`, Password: `admin123`
- **Custom**: Set `ADMIN_PASSWORD` environment variable

## Useful Commands

```bash
# View logs
docker compose logs -f

# Stop application  
docker compose down

# Rebuild completely
docker compose down && docker compose up --build

# Access backend container
docker compose exec backend sh

# Access frontend container
docker compose exec frontend sh

# Run Laravel commands
docker compose exec backend php artisan migrate
docker compose exec backend php artisan tinker
```

## Detailed Documentation

For complete setup instructions, troubleshooting, and configuration options, see:
**[DOCKER_DEPLOYMENT.md](./DOCKER_DEPLOYMENT.md)**

## Troubleshooting

If the application doesn't start:

1. Check logs: `docker compose logs`
2. Ensure ports 3000 and 8080 are not in use
3. Rebuild: `docker compose down && docker compose up --build`
4. See [DOCKER_DEPLOYMENT.md](./DOCKER_DEPLOYMENT.md) for detailed troubleshooting

## Project Structure

- `backend/` - Laravel API and admin panel
- `frontend/` - React frontend application  
- `docker/` - Docker configuration files
- `docker-compose.yml` - Service orchestration (separate containers)
- `backend/Dockerfile` - Backend container definition
- `frontend/Dockerfile` - Frontend container definition
