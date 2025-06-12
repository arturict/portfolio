# React Frontend Dockerfile
FROM node:18

# Set working directory
WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies with SSL workaround
RUN npm config set strict-ssl false && \
    npm ci --include=dev

# Copy source code
COPY . .

# Create production environment file
RUN echo "VITE_API_URL=http://localhost:8080/api" > .env.production

# Expose port
EXPOSE 3000

# Start development server that serves both dev and production
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]