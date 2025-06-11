# Portfolio Application

A modern full-stack portfolio application built with Laravel backend and React frontend, designed to showcase projects and manage portfolio content.

## 🚀 Features

- **Project Management**: Create, update, and display portfolio projects
- **User Authentication**: Register and login functionality
- **Admin Dashboard**: Manage projects through a protected admin interface
- **Responsive Design**: Mobile-friendly React frontend with Tailwind CSS
- **RESTful API**: Laravel backend with comprehensive API endpoints
- **Database Support**: SQLite and MySQL support
- **Docker Ready**: Containerized deployment with Docker

## 🏗️ Architecture

- **Backend**: Laravel 12 (PHP 8.2+) with RESTful API
- **Frontend**: React 18 with TypeScript and Vite
- **Styling**: Tailwind CSS
- **Database**: SQLite (default) or MySQL
- **Authentication**: Laravel Sanctum
- **Deployment**: Docker with multi-stage builds

## 📋 Prerequisites

- PHP 8.2 or higher
- Node.js 18 or higher
- Composer
- Docker and Docker Compose (for containerized deployment)

## 🛠️ Installation & Setup

### Local Development

1. **Clone the repository**
   ```bash
   git clone https://github.com/arturict/portfolio.git
   cd portfolio
   ```

2. **Backend Setup**
   ```bash
   cd backend
   composer install
   cp .env.example .env
   php artisan key:generate
   
   # Setup SQLite database
   touch database/database.sqlite
   php artisan migrate --seed
   ```

3. **Frontend Setup**
   ```bash
   cd frontend
   npm install
   cp .env.example .env
   ```

4. **Environment Configuration**
   
   Update `backend/.env`:
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/portfolio/backend/database/database.sqlite
   MAIL_MAILER=log
   ```

5. **Start Development Servers**
   
   Backend (Laravel):
   ```bash
   cd backend
   php artisan serve
   # Runs on http://localhost:8000
   ```
   
   Frontend (React):
   ```bash
   cd frontend
   npm run dev
   # Runs on http://localhost:5173
   ```

### Docker Deployment

1. **Build and run with Docker Compose**
   ```bash
   docker-compose up --build
   ```
   Die Anwendung ist dann unter `http://localhost:8080` erreichbar.

   **Hinweise:**
   - Persistente Daten werden in `./backend/database` und `./backend/storage` gespeichert (siehe Volumes in `docker-compose.yml`).
   - Umgebungsvariablen können direkt in `docker-compose.yml` oder über eine `.env`-Datei gesetzt werden.
   - Healthcheck prüft `/health`-Route (siehe Laravel-Route-Beispiel in DEPLOYMENT.md).
   - Für MySQL statt SQLite: MySQL-Service in `docker-compose.yml` aktivieren und ENV anpassen.

2. **Production Build & Run (ohne Compose)**
   ```bash
   docker build -t portfolio-app:latest .
   docker run -d \
     --name portfolio-app \
     -p 8080:80 \
     -e APP_ENV=production \
     -e APP_KEY=your-app-key \
     -e DB_CONNECTION=sqlite \
     -v $(pwd)/backend/database:/var/www/database \
     -v $(pwd)/backend/storage:/var/www/storage \
     --restart unless-stopped \
     portfolio-app:latest
   ```
   Für MySQL:
   ```bash
   docker run -d \
     --name portfolio-app \
     -p 8080:80 \
     -e APP_ENV=production \
     -e APP_KEY=your-app-key \
     -e DB_CONNECTION=mysql \
     -e DB_HOST=mysql \
     -e DB_PORT=3306 \
     -e DB_DATABASE=portfolio \
     -e DB_USERNAME=portfolio \
     -e DB_PASSWORD=portfolio \
     portfolio-app:latest
   ```

3. **Datenbank- und Storage-Volumes**
   - SQLite: Volume `./backend/database` wird gemountet.
   - MySQL: Siehe Beispielservice in `docker-compose.yml` und aktiviere das Volume `mysql_data`.

4. **Troubleshooting**
   - Prüfe Logs mit `docker logs portfolio-app`
   - Healthcheck schlägt fehl? Prüfe, ob `/health`-Route in Laravel existiert und erreichbar ist.
   - Berechtigungen: Stelle sicher, dass `backend/storage` und `backend/database` vom Container beschreibbar sind.

## 📁 Project Structure

```
portfolio/
├── backend/                 # Laravel API backend
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── ProjectController.php
│   │   │   └── UserController.php
│   │   ├── Models/
│   │   │   ├── Project.php
│   │   │   └── User.php
│   │   └── ...
│   ├── database/
│   ├── routes/
│   └── README.md           # Backend-specific documentation
├── frontend/               # React frontend
│   ├── src/
│   │   ├── components/
│   │   ├── pages/
│   │   ├── hooks/
│   │   └── types/
│   ├── package.json
│   └── vite.config.ts
├── docker/                 # Docker configuration
├── Dockerfile             # Multi-stage Docker build
├── docker-compose.yml     # Development docker setup
└── README.md              # This file
```

## 🔌 API Endpoints

The backend provides a RESTful API for managing projects:

- `GET /api/projects` - List all projects
- `GET /api/projects/{id}` - Get specific project
- `POST /api/projects` - Create new project (authenticated)
- `PUT /api/projects/{id}` - Update project (authenticated)
- `DELETE /api/projects/{id}` - Delete project (authenticated)

For detailed API documentation, see [backend/README.md](backend/README.md).

## 🎨 Frontend Pages

- `/` - Home page with portfolio overview
- `/projects` - Projects listing page
- `/projects/{id}` - Individual project detail page
- `/login` - User authentication
- `/register` - User registration
- `/dashboard` - Admin dashboard (protected)

## 🧪 Testing

### Backend Tests
```bash
cd backend
php artisan test
```

### Frontend Tests
```bash
cd frontend
npm run lint
npm run build  # Type checking
```

## 📝 Available Scripts

### Backend (Laravel)
- `composer install` - Install PHP dependencies
- `php artisan serve` - Start development server
- `php artisan migrate` - Run database migrations
- `php artisan migrate --seed` - Run migrations with seeders
- `php artisan test` - Run tests

### Frontend (React)
- `npm install` - Install dependencies
- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run preview` - Preview production build
- `npm run lint` - Run ESLint

## 🚀 Deployment

### Production Deployment with Docker

1. **Build production image**
   ```bash
   docker build -t portfolio-app .
   ```

2. **Run production container**
   ```bash
   docker run -p 8080:80 \
     -e APP_ENV=production \
     -e APP_KEY=your-app-key \
     -e DB_CONNECTION=sqlite \
     portfolio-app
   ```

### Manual Deployment

1. **Build frontend**
   ```bash
   cd frontend
   npm run build
   ```

2. **Deploy backend**
   ```bash
   cd backend
   composer install --no-dev --optimize-autoloader
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🔧 Troubleshooting

### Common Issues

1. **Database connection errors**
   - Ensure the SQLite file exists: `touch backend/database/database.sqlite`
   - Check file permissions and absolute paths in `.env`

2. **Frontend build errors**
   - Clear node_modules: `rm -rf node_modules && npm install`
   - Check Node.js version compatibility

3. **Docker issues**
   - Ensure Docker daemon is running
   - Check port availability (8080)

### Development Tools

- **Laravel Telescope**: Available at `/telescope` (development only)
- **API Documentation**: Swagger documentation can be generated (see backend README)
- **Debug Tools**: Laravel Pail for log monitoring

## 📞 Support

For support and questions, please open an issue on the GitHub repository.