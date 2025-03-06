REM Windows batch script to start PHP server and Tailwind CSS watcher (PIXIE N OJ!!)

@echo off
setlocal

REM Kill any existing PHP or Tailwind processes
taskkill /F /IM php.exe /FI "WINDOWTITLE eq php -S*" 2>nul
taskkill /F /IM node.exe /FI "WINDOWTITLE eq tailwindcss*" 2>nul

REM Start Tailwind CSS watcher
cd frontend
start "tailwindcss" cmd /c "node_modules\.bin\tailwindcss -i ./assets/css/input.css -o ../public/assets/css/style.css --watch"

REM Start PHP server
cd ..\public
start "php -S localhost:8000" cmd /c "php -S localhost:8000"

echo Servers are running!
echo Press Ctrl+C to stop all servers
echo DO NOT close this window directly - use Ctrl+C to ensure clean shutdown

:loop
timeout /t 1 /nobreak >nul
tasklist | find "php.exe" >nul
if errorlevel 1 (
    echo PHP server stopped, shutting down...
    goto :cleanup
)
tasklist | find "node.exe" >nul
if errorlevel 1 (
    echo Tailwind watcher stopped, shutting down...
    goto :cleanup
)
goto :loop

:cleanup
taskkill /F /IM php.exe /FI "WINDOWTITLE eq php -S*" 2>nul
taskkill /F /IM node.exe /FI "WINDOWTITLE eq tailwindcss*" 2>nul
echo All servers stopped
pause
