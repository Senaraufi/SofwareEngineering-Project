#!/bin/bash

pkill -f 'php -S' 2>/dev/null
pkill -f tailwindcss 2>/dev/null

cd "$(dirname "$0")/frontend" && node_modules/.bin/tailwindcss -i ./assets/css/input.css -o ./assets/css/style.css --watch &

cd "$(dirname "$0")/public" && php -S localhost:8000

cleanup() {
    echo "Stopping servers..."
    pkill -f 'php -S'
    pkill -f tailwindcss
    exit 0
}

trap cleanup INT
