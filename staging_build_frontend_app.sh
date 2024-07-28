#!/bin/bash

# Application directory
cd ./frontend-app/

# Pull  changes
echo "----Pulling git changes!----"
git pull origin main

# Handling dependencies 
if git diff --name-only HEAD@{1} | grep -qE '(package.json|yarn.lock|package-lock.json)'; then
    # Install/update dependencies
    echo "----Installing/updating dependencies... --"
    yarn install 
fi

# Build application
echo "-----Building Application...----"
yarn build # 

# Restarting with PM2
echo "Restarting the application..."
pm2 restart ecosystem.config.cjs # 

echo "------- Deployment complete------"


# chmod +x build_frontend_app.sh -- run this on server
