::@echo off

L:
cd L:\Server\SCM\Github\app-module\play\master
set filename=temp\logs\%date:~0,4%%date:~5,2%%date:~8,2%.log
echo.>>%filename%
echo +----------------------------------------------------------------------+>>%filename%
echo.>>%filename%

echo %time% %date%>>%filename%
echo +-----+>>%filename%
echo ^| LAN ^|>>%filename%
echo +-----+>>%filename%
"C:\Program Files\Git\cmd\git.exe" pull lan master >>%filename% 2>&1
echo.>>%filename%

echo %time%>>%filename%
echo +------+>>%filename%
echo ^| Gogs ^|>>%filename%
echo +------+>>%filename%
git push origin master >>%filename% 2>&1
echo.>>%filename%

echo %time%>>%filename%
exit
