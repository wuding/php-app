L:
cd L:\Server\SCM\Github\wuding\php-app\master
set filename=temp\logs\%date:~0,4%%date:~5,2%%date:~8,2%.log
echo #  >>%filename%
echo %date%%time% >>%filename%
"C:\Program Files\Git\cmd\git.exe" pull gogs master >>%filename% 2>&1
echo ##  >>%filename%
git push git00 master >>%filename% 2>&1
echo ###  >>%filename%
exit
