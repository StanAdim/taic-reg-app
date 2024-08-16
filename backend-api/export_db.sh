#!/bin/bash

# Load variables from .env file
set -o allexport
source .env
set +o allexport

# Variables
CONTAINER_NAME=$DB_HOST
DB_USER=$DB_USERNAME
DB_NAME=$DB_DATABASE
TIMESTAMP=$(date +'%Y%m%d%H%M%S')
BACKUP_PATH="/tmp/${DB_NAME}_${TIMESTAMP}.backup"
LOCAL_BACKUP_PATH="./backups/${DB_NAME}_${TIMESTAMP}.backup"
RETENTION_DAYS=${RETENTION_DAYS:-5}  # Default to 5 days if RETENTION_DAYS is not set

# Ensure the backups directory exists
mkdir -p "./backups"

# Function to export the database as a Custom format file inside the container
export_database() {
    echo "Exporting database ${DB_NAME} from container ${CONTAINER_NAME}..."
    if docker exec -it "$CONTAINER_NAME" pg_dump -U "$DB_USER" -d "$DB_NAME" -F c -f "$BACKUP_PATH"; then
        echo "Database export successful."
    else
        echo "Error exporting database."
        exit 1
    fi
}

# Function to copy the Custom format backup file from the container to the local machine
copy_backup_to_local() {
    echo "Copying backup file to local machine..."
    if docker cp "$CONTAINER_NAME:$BACKUP_PATH" "$LOCAL_BACKUP_PATH"; then
        echo "Backup file copied successfully."
    else
        echo "Error copying backup file."
        exit 1
    fi
}

# Function to clean up the backup file inside the container
cleanup_container() {
    echo "Cleaning up backup file inside the container..."
    if docker exec -it "$CONTAINER_NAME" rm "$BACKUP_PATH"; then
        echo "Cleanup successful."
    else
        echo "Error during cleanup."
    fi
}

# Function to delete old backups
delete_old_backups() {
    echo "Deleting backups older than ${RETENTION_DAYS} days..."
    find ./backups -type f -name "${DB_NAME}_*.backup" -mtime +$RETENTION_DAYS -exec rm {} \;
    echo "Old backups deleted."
}

# Execute functions
export_database
copy_backup_to_local
cleanup_container
delete_old_backups

# Confirmation message
echo "Database backup saved to $LOCAL_BACKUP_PATH"
