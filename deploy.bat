@echo off
setlocal ENABLEDELAYEDEXPANSION
cd /d "%~dp0"

REM One-click deploy for Yii2 Advanced (Windows)
set PORT_BACKEND=8088
set PORT_FRONTEND=8089
set DB_NAME=war_resistance_db
set DB_HOST=localhost
set DB_USER=root
set DB_PASS=%DB_PASS%

echo [1/4] Checking PHP
where php >nul 2>&1
if errorlevel 1 (
  echo PHP not found. Please install PHP and add it to PATH.
  goto :end_fail
)
php -v | findstr /C:"PHP" >nul 2>&1

echo [2/4] Installing Composer dependencies (if needed)
if exist composer.json (
  if exist vendor\autoload.php (
    rem vendor present, keep silent
  ) else (
    where composer >nul 2>&1
    if errorlevel 1 (
      rem composer not found, skip silently
    ) else (
      composer install >nul 2>&1
    )
  )
)

echo [3/4] Importing database (optional)
where mysql >nul 2>&1
if errorlevel 1 (
  echo MySQL client not found. Skipping DB import.
) else (
  if exist war_resistance_db.sql (
    echo Ensuring database %DB_NAME% exists...
    set MYSQL_AUTH=
    if not "%DB_PASS%"=="" set MYSQL_AUTH=-p%DB_PASS%
    mysql -h%DB_HOST% -u%DB_USER% %MYSQL_AUTH% -e "CREATE DATABASE IF NOT EXISTS %DB_NAME% DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;" 2>nul
    echo Importing war_resistance_db.sql into %DB_NAME% ...
    mysql -h%DB_HOST% -u%DB_USER% %MYSQL_AUTH% %DB_NAME% < war_resistance_db.sql
  ) else (
    echo war_resistance_db.sql not found. Skipping import.
  )
)

echo [4/4] Starting PHP built-in servers
set FRONTEND_WEB=frontend\web
set BACKEND_WEB=backend\web
if not exist "%FRONTEND_WEB%\index.php" (
  echo Frontend index.php not found in %FRONTEND_WEB%. Aborting.
  goto :end_fail
)
if not exist "%BACKEND_WEB%\index.php" (
  echo Backend index.php not found in %BACKEND_WEB%. Aborting.
  goto :end_fail
)

start "backend" php -S 127.0.0.1:%PORT_BACKEND% -t "%BACKEND_WEB%"
start "frontend" php -S 127.0.0.1:%PORT_FRONTEND% -t "%FRONTEND_WEB%"

echo ------------------------------------------------------------
echo Backend is running at:  http://127.0.0.1:%PORT_BACKEND%
echo Frontend is running at: http://127.0.0.1:%PORT_FRONTEND%
echo DB name: %DB_NAME% (configure in common\config\main-local.php as needed)
echo Optional: set DB_PASS env var before running to supply MySQL password.
echo ------------------------------------------------------------
goto :eof

:end_fail
echo Deployment failed. Please resolve the issue above and retry.
exit /b 1
