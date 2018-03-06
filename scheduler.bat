SET bantam_path=%~dp0
schtasks /query /TN "Nav Bantam Sync" >NUL 2>&1 || schTasks /Create /SC DAILY /TN "Nav Bantam Sync" /TR "php %bantam_path%artisan schedule:run" /RI 1 /mo 1 /RU "SYSTEM" /DU "24:00"
pause