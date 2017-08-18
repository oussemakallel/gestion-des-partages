@echo off
ping %1 -n 3 | findstr /r /c:"[0-9] *ms"
if %errorlevel% == 0 (
    echo SUCCESS
) else (
    echo FAIL
)