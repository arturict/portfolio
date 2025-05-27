# Portfolio Frontend

This is a simple React frontend for testing the portfolio backend API features.

## Features

- View all projects in a responsive grid layout
- View detailed information about individual projects
- User authentication (login and registration)
- Create, edit, and delete projects (for authenticated users)
- Responsive design for various screen sizes

## Getting Started

This project was bootstrapped with [Create React App](https://github.com/facebook/create-react-app).

### Prerequisites

- Node.js (version 14 or higher)
- npm or yarn

### Installation

1. Install dependencies:

```bash
cd frontend
npm install
# or
yarn install
```

2. Start the development server:

```bash
npm start
# or
yarn start
```

The frontend will be accessible at http://localhost:3000

## API Configuration

By default, the frontend expects the backend API to be running at http://localhost:8000/api. You can change this configuration in `src/services/api.js` if your backend is running on a different URL.

## Available Pages

- `/` - Home page with project listings
- `/login` - User login page
- `/register` - User registration page
- `/projects/:id` - Project detail page
- `/projects/new` - Create new project form (requires authentication)
- `/projects/edit/:id` - Edit project form (requires authentication)

## Authentication

The frontend uses token-based authentication. When a user logs in or registers, the API provides a token that is stored in the browser's localStorage. This token is included in the Authorization header for API requests that require authentication.

## Backend Integration

This frontend is designed to work with the Laravel backend API, which provides endpoints for:

- User authentication
- Project CRUD operations

Make sure the backend server is running before using the frontend application.

## Available Scripts

In the project directory, you can run:

### `npm start`

Runs the app in the development mode.\
Open [http://localhost:3000](http://localhost:3000) to view it in your browser.

### `npm test`

Launches the test runner in the interactive watch mode.

### `npm run build`

Builds the app for production to the `build` folder.
