#!/bin/bash

# Navigate to the Laravel storage logs directory
LOG_DIR="./storage/logs"
LOG_FILE="$LOG_DIR/laravel.log"

# Check if log directory exists
if [ ! -d "$LOG_DIR" ]; then
    echo "Log directory does not exist: $LOG_DIR"
    exit 1
fi

# Function to display logs
display_logs() {
    cat $LOG_DIR/*.log
}

# Function to clear the laravel.log file
clear_log() {
    if [ -f "$LOG_FILE" ]; then
        > "$LOG_FILE"
        echo "Cleared the log file: $LOG_FILE"
    else
        echo "Log file does not exist: \n $LOG_FILE"
    fi
}

# Check for the 'clear' argument
if [ "$1" == "--clear" ]; then
    clear_log
else
    display_logs
fi
