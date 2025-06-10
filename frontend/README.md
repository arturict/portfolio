# Portfolio Frontend

A modern React frontend application built with TypeScript, Vite, and Tailwind CSS for the portfolio management system.

## 🚀 Technologies

- **React 18** - Modern React with hooks
- **TypeScript** - Type-safe JavaScript
- **Vite** - Fast build tool and development server
- **Tailwind CSS** - Utility-first CSS framework
- **React Router** - Client-side routing
- **Axios** - HTTP client for API calls
- **React Hook Form** - Form management
- **Zod** - Schema validation
- **Lucide React** - Modern icon library

## 📁 Project Structure

```
src/
├── components/          # Reusable UI components
│   ├── Layout.tsx      # Main application layout
│   └── ProtectedRoute.tsx  # Authentication wrapper
├── pages/              # Page components
│   ├── Home.tsx       # Landing page
│   ├── Projects.tsx   # Projects listing
│   ├── ProjectDetail.tsx  # Individual project view
│   ├── Login.tsx      # Authentication page
│   ├── Register.tsx   # User registration
│   └── Dashboard.tsx  # Admin dashboard
├── contexts/          # React contexts for state management
├── hooks/             # Custom React hooks
├── lib/               # Utility functions and configurations
├── types/             # TypeScript type definitions
├── App.tsx            # Main application component
├── main.tsx           # Application entry point
└── index.css          # Global styles and Tailwind imports
```

## 🛠️ Setup & Development

### Prerequisites

- Node.js 18 or higher
- npm or yarn package manager

### Installation

1. **Install dependencies**
   ```bash
   npm install
   ```

2. **Environment setup**
   ```bash
   cp .env.example .env
   ```

3. **Start development server**
   ```bash
   npm run dev
   ```
   
   The application will be available at `http://localhost:5173`

### Environment Variables

Create a `.env` file with the following variables:

```env
VITE_API_URL=http://localhost:8000/api
VITE_APP_NAME=Portfolio
```

## 🎯 Available Scripts

- `npm run dev` - Start development server with hot reload
- `npm run build` - Build for production (includes TypeScript compilation)
- `npm run preview` - Preview production build locally
- `npm run lint` - Run ESLint for code quality

## 🎨 Styling

The application uses **Tailwind CSS** for styling with a custom configuration:

- **Responsive design** - Mobile-first approach
- **Custom color palette** - Defined in `tailwind.config.js`
- **Component classes** - Utility-first styling approach
- **Dark mode support** - Can be extended for theme switching

### Key Design Patterns

- **Button styles**: `btn-primary`, `btn-outline` classes
- **Card layouts**: Consistent spacing and shadows
- **Typography**: Tailwind's typography scale
- **Icons**: Lucide React icons throughout

## 🔗 Routing

The application uses React Router v6 with the following routes:

- `/` - Home page with portfolio overview
- `/projects` - Projects listing with filtering/search
- `/projects/:id` - Individual project detail page
- `/login` - User authentication
- `/register` - User registration
- `/dashboard` - Protected admin dashboard

### Protected Routes

The `/dashboard` route is protected using the `ProtectedRoute` component, which checks for authentication status.

## 📡 API Integration

The frontend communicates with the Laravel backend through REST API calls:

### API Client Configuration

```typescript
// Example API call structure
const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'

// Projects API
GET    /api/projects      - Fetch all projects
GET    /api/projects/{id} - Fetch single project
POST   /api/projects      - Create new project (auth required)
PUT    /api/projects/{id} - Update project (auth required)
DELETE /api/projects/{id} - Delete project (auth required)
```

### Authentication

The frontend handles authentication through:
- Login/register forms
- Token storage (localStorage/sessionStorage)
- Protected route components
- API request interceptors

## 🎨 Component Guide

### Layout Component
Main application wrapper providing:
- Navigation header
- Footer
- Responsive container
- Global styling context

### Pages

#### Home
- Hero section with portfolio introduction
- Featured projects showcase
- Contact information

#### Projects
- Grid layout of project cards
- Filtering and search functionality
- Pagination support

#### Project Detail
- Full project information display
- Image gallery
- External links (demo, GitHub)
- Technology stack display

#### Dashboard
- Admin interface for project management
- CRUD operations for projects
- User management features

## 🔧 Development Guidelines

### TypeScript

The project uses strict TypeScript configuration:
- All components must be typed
- Props interfaces defined for components
- API response types defined
- Utility type helpers where needed

### Code Style

- **ESLint** configuration for code quality
- **Prettier** integration (if configured)
- Consistent naming conventions
- Component-based architecture

### Performance

- **Lazy loading** for route components
- **Code splitting** with Vite
- **Optimized builds** with tree shaking
- **Image optimization** for project assets

## 🧪 Testing

Currently, the project is set up for testing but doesn't include test files. To add testing:

```bash
# Add testing dependencies
npm install --save-dev @testing-library/react @testing-library/jest-dom vitest jsdom

# Add test script to package.json
"test": "vitest"
```

## 🚀 Production Build

### Build Process

```bash
npm run build
```

This creates:
- Optimized JavaScript bundles
- Minified CSS
- Asset optimization
- Static files in `dist/` directory

### Build Output

```
dist/
├── assets/          # Bundled JS/CSS with hash names
├── index.html       # Main HTML file
└── favicon.ico      # Application favicon
```

### Deployment

The build output can be deployed to:
- **Static hosting** (Netlify, Vercel, GitHub Pages)
- **CDN** with proper routing configuration
- **Docker container** (see root Dockerfile)
- **Traditional web servers** (Apache, Nginx)

### Environment-specific Builds

```bash
# Development build
npm run build -- --mode development

# Production build
npm run build -- --mode production
```

## 🔧 Troubleshooting

### Common Issues

1. **Port conflicts**
   ```bash
   # Change port in vite.config.ts or use flag
   npm run dev -- --port 3000
   ```

2. **API connection issues**
   - Check `VITE_API_URL` in `.env`
   - Ensure backend is running
   - Verify CORS configuration

3. **Build failures**
   - Check TypeScript errors: `npm run build`
   - Clear node_modules: `rm -rf node_modules && npm install`

### Debug Tools

- **React Developer Tools** browser extension
- **Vite's built-in** HMR and error overlay
- **TypeScript** error reporting in IDE
- **Network tab** for API debugging

## 📞 Support

For frontend-specific issues, check:
1. Browser console for JavaScript errors
2. Network tab for API call issues
3. React Developer Tools for component debugging
4. Vite documentation for build issues