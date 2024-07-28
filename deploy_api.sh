#!/bin/bash

# branch names
STAGING_BRANCH="staging"
PRODUCTION_BRANCH="main"

#  Docker Compose files 
STAGING_COMPOSE_FILE="docker-compose.yml"
PRODUCTION_COMPOSE_FILE="docker-compose.prod.yml"

# Docker container names
STAGING_CONTAINER_NAME="events-finalized"
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
if [ "$CURRENT_BRANCH" == "$STAGING_BRANCH" ]; then
    echo "Deploying to Staging Environment..."
    # Use Docker Compose to build and run the application for staging
    docker-compose -f "$STAGING_COMPOSE_FILE" down
    docker-compose -f "$STAGING_COMPOSE_FILE" build
    docker-compose -f "$STAGING_COMPOSE_FILE" up -d
elif [ "$CURRENT_BRANCH" == "$PRODUCTION_BRANCH" ]; then
    echo "Deploying to Production Environment..."
    # Use Docker Compose to build and run the application for production
    docker-compose -f "$PRODUCTION_COMPOSE_FILE" down
    docker-compose -f "$PRODUCTION_COMPOSE_FILE" build
    docker-compose -f "$PRODUCTION_COMPOSE_FILE" up -d
else
    echo "The current branch ($CURRENT_BRANCH) is neither the staging nor production branch. Exiting..."
    exit 1
fi

# Run specific commands
echo "---Running Application migrations..."
docker-compose exec "$STAGING_CONTAINER_NAME" php artisan migrate --force
docker-compose exec "$STAGING_CONTAINER_NAME" php artisan migrate --force

# Optionally clear caches and optimize the application
echo "---Clearing caches..."
docker-compose exec "$STAGING_CONTAINER_NAME" php artisan cache:clear
docker-compose exec "$STAGING_CONTAINER_NAME" php artisan config:clear
docker-compose exec "$STAGING_CONTAINER_NAME" php artisan route:clear
docker-compose exec "$STAGING_CONTAINER_NAME" php artisan view:clear

echo "---Optimizing the application..."
docker-compose exec "$STAGING_CONTAINER_NAME" php artisan config:cache
docker-compose exec "$STAGING_CONTAINER_NAME" php artisan route:cache

echo "Deployment completed successfully."
