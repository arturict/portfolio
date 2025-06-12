#!/bin/bash

# Portfolio Application Startup Script
echo "🚀 Starting Portfolio Application..."

# Check if Docker and Docker Compose are available
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker first."
    exit 1
fi

if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null; then
    echo "❌ Docker Compose is not available. Please install Docker Compose first."
    exit 1
fi

# Stop any existing containers
echo "🛑 Stopping existing containers..."
docker-compose down

# Build and start the application
echo "🔨 Building and starting the application..."
docker-compose up -d --build

# Wait for the application to be ready
echo "⏳ Waiting for the application to start..."
sleep 10

# Check if the application is running
if curl -s http://localhost:8080/health > /dev/null; then
    echo "✅ Application is running successfully!"
    echo ""
    echo "🌐 Access your application at:"
    echo "   Frontend: http://localhost:8080"
    echo "   Admin Panel: http://localhost:8080/admin"
    echo "   Health Check: http://localhost:8080/health"
    echo ""
    echo "📋 To view logs: docker-compose logs -f"
    echo "🛑 To stop: docker-compose down"
else
    echo "❌ Application failed to start. Check logs with: docker-compose logs"
fi
