#!/bin/bash

# branch names
PRODUCTION_BRANCH="production"

#  Docker Compose files
PRODUCTION_COMPOSE_FILE="docker-compose.prod.yml"

# Docker container names
PRODUCTION_CONTAINER_NAME="events-app"

#  Project directory
PROJECT_DIR="./backend-api"

# Navigate project directory
cd "$PROJECT_DIR" || exit

# Pull the latest changes
echo "---Pulling latest changes from git..."
git fetch origin

# Get the current branch name
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)

# Check if there are any new changes
if git diff --quiet HEAD..origin/$CURRENT_BRANCH; then
    echo "No new changes to deploy on branch $CURRENT_BRANCH."
    exit 0
fi

# Pull the latest changes
git pull origin "$CURRENT_BRANCH"

# Check which branch is currently checked out and build accordingly
if [ "$CURRENT_BRANCH" == "$PRODUCTION_BRANCH" ]; then
    echo "Deploying to Staging Environment..."
    # Use Docker Compose to build and run the application for staging
    docker-compose -f "$PRODUCTION_COMPOSE_FILE" down
    docker-compose -f "$PRODUCTION_COMPOSE_FILE" build
    docker-compose -f "$PRODUCTION_COMPOSE_FILE" up -d
else
    echo "The current branch ($CURRENT_BRANCH) is not the staging..."
    exit 1
fi

# Run specific commands
echo "---Running Application migrations..."
docker-compose exec "$PRODUCTION_CONTAINER_NAME" php artisan migrate --force

# Optionally clear caches and optimize the application
echo "---Clearing caches..."
docker-compose exec "$PRODUCTION_CONTAINER_NAME" php artisan cache:clear
docker-compose exec "$PRODUCTION_CONTAINER_NAME" php artisan config:clear
docker-compose exec "$PRODUCTION_CONTAINER_NAME" php artisan route:clear
docker-compose exec "$PRODUCTION_CONTAINER_NAME" php artisan view:clear

echo "---Optimizing the application..."
docker-compose exec "$PRODUCTION_CONTAINER_NAME" php artisan config:cache
docker-compose exec "$PRODUCTION_CONTAINER_NAME" php artisan route:cache

echo "Deployment completed successfully."
