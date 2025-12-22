#!/bin/bash

# Local Docker Testing Script
# This script helps you test the Docker build locally before deploying to Dokploy

set -e

echo "================================"
echo "Pixel Positions - Docker Test"
echo "================================"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${YELLOW}⚠ .env file not found${NC}"
    echo "Creating .env from .env.example..."
    cp .env.example .env
    echo -e "${GREEN}✓ .env created${NC}"
    echo ""
    echo "Please edit .env file with your database credentials"
    echo "Then run this script again"
    exit 1
fi

# Check if docker is installed
if ! command -v docker &> /dev/null; then
    echo -e "${RED}✗ Docker is not installed${NC}"
    echo "Please install Docker first: https://docs.docker.com/get-docker/"
    exit 1
fi

# Check if docker-compose is available
if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null; then
    echo -e "${RED}✗ Docker Compose is not installed${NC}"
    echo "Please install Docker Compose first"
    exit 1
fi

echo -e "${GREEN}✓ Docker is installed${NC}"
echo ""

# Function to use either docker-compose or docker compose
docker_compose() {
    if command -v docker-compose &> /dev/null; then
        docker-compose "$@"
    else
        docker compose "$@"
    fi
}

# Menu
echo "What would you like to do?"
echo "1) Build and start containers"
echo "2) Stop containers"
echo "3) View logs"
echo "4) Restart containers"
echo "5) Clean up (remove containers and volumes)"
echo "6) Test build only (no start)"
echo "7) Exit"
echo ""
read -p "Enter your choice [1-7]: " choice

case $choice in
    1)
        echo ""
        echo "Building and starting containers..."
        docker_compose up -d --build
        echo ""
        echo -e "${GREEN}✓ Containers started${NC}"
        echo ""
        echo "Application is running at: http://localhost:8000"
        echo "Database is running on: localhost:3306"
        echo ""
        echo "To view logs, run: docker-compose logs -f"
        echo "To stop, run: docker-compose down"
        ;;
    2)
        echo ""
        echo "Stopping containers..."
        docker_compose down
        echo -e "${GREEN}✓ Containers stopped${NC}"
        ;;
    3)
        echo ""
        echo "Viewing logs (press Ctrl+C to exit)..."
        docker_compose logs -f
        ;;
    4)
        echo ""
        echo "Restarting containers..."
        docker_compose restart
        echo -e "${GREEN}✓ Containers restarted${NC}"
        ;;
    5)
        echo ""
        read -p "This will remove all containers and volumes. Are you sure? (y/N): " confirm
        if [ "$confirm" = "y" ] || [ "$confirm" = "Y" ]; then
            docker_compose down -v
            echo -e "${GREEN}✓ Cleanup complete${NC}"
        else
            echo "Cleanup cancelled"
        fi
        ;;
    6)
        echo ""
        echo "Testing build..."
        docker build -t pixel-positions-test .
        echo ""
        if [ $? -eq 0 ]; then
            echo -e "${GREEN}✓ Build successful${NC}"
            echo ""
            echo "To run the built image:"
            echo "docker run -p 8000:80 -e APP_KEY=your_key pixel-positions-test"
        else
            echo -e "${RED}✗ Build failed${NC}"
            exit 1
        fi
        ;;
    7)
        echo "Exiting..."
        exit 0
        ;;
    *)
        echo -e "${RED}Invalid choice${NC}"
        exit 1
        ;;
esac
