#!/bin/bash

# Load .env file
set -o allexport
source ../.env
set +o allexport

# Configuration from .env
DATE=$(date +"%Y-%m-%d_%H-%M-%S")

# Ensure the backup directory exists (on the local machine)
# mkdir -p $BACKUP_DIR

# Perform the backup using docker exec and pg_dump inside the container, but store the backup file on the local machine
docker exec -e PGPASSWORD=$DB_PASSWORD $CONTAINER_NAME pg_dump -U $DB_USER -d $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

# Verify the backup was successful
if [ $? -eq 0 ]; then
    echo "Backup successful: $BACKUP_DIR/db_backup_$DATE.sql"
else
    echo "Backup failed!"
    exit 1
fi

# Remove backups older than RETENTION_DAYS (on the local machine)
find $BACKUP_DIR -type f -name "*.sql" -mtime +$RETENTION_DAYS -exec rm {} \;

echo "Old backups cleaned up."

exit 0
