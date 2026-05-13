@echo off
echo.
echo  ████████╗███████╗ ██████╗██╗  ██╗██╗    ██╗ ██████╗ ███╗   ██╗
echo  ╚══██╔══╝██╔════╝██╔════╝██║  ██║██║    ██║██╔═══██╗████╗  ██║
echo     ██║   █████╗  ██║     ███████║██║ █╗ ██║██║   ██║██╔██╗ ██║
echo     ██║   ██╔══╝  ██║     ██╔══██║██║███╗██║██║   ██║██║╚██╗██║
echo     ██║   ███████╗╚██████╗██║  ██║╚███╔███╔╝╚██████╔╝██║ ╚████║
echo     ╚═╝   ╚══════╝ ╚═════╝╚═╝  ╚═╝ ╚══╝╚══╝  ╚═════╝ ╚═╝  ╚═══╝
echo.
echo  AI Operating Systems for SMBs
echo  ─────────────────────────────────────────────
echo  Starting backend on http://localhost:3001
echo  Frontend served at http://localhost:3001
echo.

cd /d "%~dp0backend"
node server.js

pause
