#!/bin/bash

# Kill any existing PHP servers and Tailwind processes
pkill -f 'php -S' 2>/dev/null
pkill -f tailwindcss 2>/dev/null

# Start Tailwind in the background
cd "$(dirname "$0")/frontend" && node_modules/.bin/tailwindcss -i ./assets/css/input.css -o ./assets/css/style.css --watch &

# Start PHP server
cd "$(dirname "$0")/public" && php -S localhost:8000

# This function will be called when the script is interrupted
cleanup() {
    echo "Stopping servers..."
    pkill -f 'php -S'
    pkill -f tailwindcss
    exit 0
}

# Set up the cleanup function to run when the script receives an interrupt signal
trap cleanup INT
