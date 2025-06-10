# Contributing to Portfolio Application

Thank you for your interest in contributing to this portfolio application! We welcome contributions from the community.

## 🚀 Getting Started

### Development Setup

1. **Fork and clone the repository**
   ```bash
   git clone https://github.com/your-username/portfolio.git
   cd portfolio
   ```

2. **Install dependencies**
   ```bash
   # Backend dependencies
   cd backend
   composer install
   
   # Frontend dependencies
   cd ../frontend
   npm install
   ```

3. **Set up environment**
   ```bash
   # Backend
   cd backend
   cp .env.example .env
   php artisan key:generate
   touch database/database.sqlite
   php artisan migrate --seed
   
   # Frontend
   cd ../frontend
   cp .env.example .env
   ```

4. **Start development servers**
   ```bash
   # Terminal 1: Backend
   cd backend
   php artisan serve
   
   # Terminal 2: Frontend
   cd frontend
   npm run dev
   ```

## 📋 Code Style & Standards

### Backend (Laravel/PHP)

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards
- Use Laravel's built-in validation and form requests
- Write meaningful method and class names
- Add PHPDoc comments for complex methods
- Use type hints where possible

**Example:**
```php
/**
 * Create a new project with validation
 */
public function store(MakeProjectRequest $request): ProjectResource
{
    $project = Project::create($request->validated());
    return new ProjectResource($project);
}
```

### Frontend (React/TypeScript)

- Use TypeScript strict mode
- Follow React functional component patterns
- Use meaningful component and prop names
- Implement proper error boundaries
- Follow React hooks best practices

**Example:**
```typescript
interface ProjectCardProps {
  project: Project;
  onEdit?: (project: Project) => void;
}

const ProjectCard: React.FC<ProjectCardProps> = ({ project, onEdit }) => {
  // Component implementation
};
```

### CSS/Styling

- Use Tailwind CSS utility classes
- Create reusable component classes when needed
- Follow mobile-first responsive design
- Maintain consistent spacing and typography

## 🧪 Testing

### Backend Tests

```bash
cd backend
php artisan test
```

- Write feature tests for API endpoints
- Use Laravel's testing utilities
- Test both success and error scenarios
- Mock external services

### Frontend Tests

```bash
cd frontend
npm run lint
npm run build  # TypeScript checking
```

- Add unit tests for utility functions
- Test component rendering and interactions
- Mock API calls in tests

## 🔄 Pull Request Process

1. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. **Make your changes**
   - Follow the coding standards above
   - Add tests for new functionality
   - Update documentation as needed

3. **Test your changes**
   ```bash
   # Backend
   cd backend
   php artisan test
   
   # Frontend
   cd frontend
   npm run lint
   npm run build
   ```

4. **Commit your changes**
   ```bash
   git add .
   git commit -m "feat: add your feature description"
   ```

5. **Push and create PR**
   ```bash
   git push origin feature/your-feature-name
   ```

### Commit Message Convention

Use conventional commits format:

- `feat:` - New features
- `fix:` - Bug fixes
- `docs:` - Documentation changes
- `style:` - Code style changes (formatting, etc.)
- `refactor:` - Code refactoring
- `test:` - Adding or updating tests
- `chore:` - Maintenance tasks

**Examples:**
```
feat: add project filtering functionality
fix: resolve authentication token expiration issue
docs: update API endpoint documentation
```

## 🐛 Bug Reports

When reporting bugs, please include:

1. **Environment details**
   - OS and version
   - PHP version (for backend issues)
   - Node.js version (for frontend issues)
   - Browser version (for frontend issues)

2. **Steps to reproduce**
   - Clear, numbered steps
   - Expected vs actual behavior
   - Screenshots if applicable

3. **Error details**
   - Error messages
   - Console logs
   - Server logs (if applicable)

## 💡 Feature Requests

When suggesting new features:

1. **Describe the problem** the feature would solve
2. **Propose a solution** with implementation details
3. **Consider alternatives** you've thought about
4. **Provide examples** of how it would be used

## 🏗️ Architecture Guidelines

### Backend Architecture

- Follow Laravel conventions
- Use Repository pattern for complex queries
- Implement proper API resource transformations
- Use Laravel's built-in features (validation, middleware, etc.)

### Frontend Architecture

- Use functional components with hooks
- Implement proper state management
- Create reusable components
- Follow React best practices

### Database Design

- Use meaningful table and column names
- Implement proper foreign key relationships
- Add database indexes for performance
- Write clear migration files

## 📚 Documentation

When adding new features:

1. **Update relevant README files**
2. **Add inline code comments** for complex logic
3. **Update API documentation** for new endpoints
4. **Add examples** for new functionality

### API Documentation

For new API endpoints, update the backend README with:
- Endpoint URL and HTTP method
- Request/response examples
- Required parameters
- Authentication requirements

## 🔒 Security Guidelines

- **Never commit sensitive data** (API keys, passwords, etc.)
- **Validate all user inputs** on both frontend and backend
- **Use Laravel's built-in security features**
- **Follow OWASP security guidelines**
- **Report security issues privately** via GitHub security tab

## 🌍 Accessibility

- Use semantic HTML elements
- Implement proper ARIA labels
- Ensure keyboard navigation works
- Test with screen readers
- Maintain color contrast ratios

## 📱 Responsive Design

- Follow mobile-first approach
- Test on multiple screen sizes
- Use Tailwind's responsive utilities
- Ensure touch targets are adequate

## 🤝 Community Guidelines

- Be respectful and inclusive
- Help others learn and grow
- Give constructive feedback
- Follow the code of conduct
- Ask questions when unclear

## 🎯 Areas for Contribution

We especially welcome contributions in:

- **Testing**: Adding unit and integration tests
- **Documentation**: Improving existing docs or adding new ones
- **Accessibility**: Making the app more accessible
- **Performance**: Optimizing frontend and backend performance
- **UI/UX**: Improving the user interface and experience
- **Features**: Adding new portfolio management features

## 📞 Getting Help

If you need help:

1. **Check existing documentation** first
2. **Search existing issues** for similar problems
3. **Ask questions** in GitHub discussions
4. **Create an issue** with detailed information

Thank you for contributing! 🎉