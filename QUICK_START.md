# Portfolio Application - Quick Start

This is a Laravel + React portfolio application that can be started with a single Docker command.

## Prerequisites

- Docker
- Docker Compose

**No PHP or Node.js installation required!**

## Quick Start

### Option 1: Use the start script (recommended)
```bash
./start.sh
```

### Option 2: Manual Docker Compose
```bash
docker-compose up -d --build
```

## Access Points

- **Frontend**: http://localhost:8080
- **Admin Panel**: http://localhost:8080/admin (login with admin123)
- **Health Check**: http://localhost:8080/health

## Useful Commands

```bash
# View logs
docker-compose logs -f

# Stop application
docker-compose down

# Rebuild completely
docker-compose down && docker-compose up -d --build

# Access Laravel container
docker-compose exec app sh

# Run Laravel commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tinker
```

## Troubleshooting

If the application doesn't start:

1. Check logs: `docker-compose logs`
2. Ensure port 8080 is not in use
3. Rebuild: `docker-compose down && docker-compose up -d --build`

## Project Structure

- `backend/` - Laravel API and admin panel
- `frontend/` - React frontend application
- `docker/` - Docker configuration files
- `docker-compose.yml` - Service orchestration
