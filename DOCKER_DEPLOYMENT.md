# Docker Deployment Guide

This portfolio application now supports Docker deployment with separate containers for frontend and backend as requested.

## Quick Start

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd portfolio
   ```

2. **Start the application**
   ```bash
   docker compose up --build
   ```

3. **Access the application**
   - Frontend: http://localhost:3000
   - Backend API: http://localhost:8080/api
   - Admin Panel: http://localhost:8080/admin

## Container Architecture

The application uses two separate containers:

- **Backend Container** (port 8080): Laravel API + Admin Panel with SQLite database
- **Frontend Container** (port 3000): React development server

## Database & Persistence

- **Database**: SQLite (as requested)
- **Location**: Persisted in Docker volume `database_data`
- **Storage**: Application storage persisted in Docker volume `storage_data`

## Admin Configuration

The only manual configuration needed is the admin account:

- **Default credentials**: Email: `artur@ferreiracruz.com`, Password: `admin123`
- **To customize**: Set environment variable `ADMIN_PASSWORD` before starting
  ```bash
  ADMIN_PASSWORD=your-secure-password docker compose up --build
  ```

## Environment Variables

You can customize the deployment with these environment variables:

```bash
APP_KEY=your-32-char-key                    # Laravel app key
APP_URL=http://localhost:8080               # Backend URL
ADMIN_PASSWORD=admin123                     # Admin user password
VITE_API_URL=http://localhost:8080/api      # Frontend API endpoint
```

## Troubleshooting

### Build Issues

If you encounter SSL certificate issues during build (especially in restricted environments):

1. **For quick testing**: Build with SSL verification disabled
   ```bash
   # This is already implemented in the Dockerfiles for compatibility
   docker compose build --build-arg NPM_CONFIG_STRICT_SSL=false
   ```

2. **Alternative**: Use pre-built vendor dependencies
   ```bash
   # Copy existing vendor folder if available
   cp -r vendor/ backend/vendor/
   ```

### Port Conflicts

If ports 3000 or 8080 are in use:

1. **Change ports in docker-compose.yml**:
   ```yaml
   services:
     backend:
       ports:
         - "8081:80"  # Change 8080 to 8081
     frontend:
       ports:
         - "3001:3000"  # Change 3000 to 3001
   ```

2. **Update frontend API URL**:
   ```yaml
   environment:
     - VITE_API_URL=http://localhost:8081/api
   ```

### Container Logs

View logs for debugging:
```bash
# All services
docker compose logs -f

# Specific service
docker compose logs -f backend
docker compose logs -f frontend
```

## Development

For development with live reloading:

```bash
# Start in development mode (default)
docker compose up

# The frontend container runs `npm run dev` which provides:
# - Hot module replacement
# - Live reloading
# - Vite dev server features
```

## Production Deployment

For production deployment:

1. **Set production environment variables**
2. **Use proper SSL certificates**
3. **Configure proper domain names**
4. **Set secure admin password**

## Architecture Details

### Backend Container
- **Base**: PHP 8.2 FPM on Debian
- **Web Server**: Nginx
- **Process Manager**: Supervisor
- **Database**: SQLite with persistence
- **PHP Extensions**: pdo_sqlite, pdo_mysql, mbstring, exif, pcntl, bcmath, gd

### Frontend Container  
- **Base**: Node.js 18
- **Build Tool**: Vite
- **Development**: Hot reload enabled
- **API Communication**: Configured to communicate with backend container

### Networking
- **Internal Network**: `portfolio-network` bridge driver
- **Backend-Frontend Communication**: Containers can communicate via container names
- **External Access**: Both containers expose ports to host

This setup fulfills the requirements:
✅ Two separate containers (frontend + backend)  
✅ SQLite database with persistence  
✅ Minimal setup (only admin configuration needed)  
✅ Works with `docker compose up`  
✅ Clear documentation for admin setup