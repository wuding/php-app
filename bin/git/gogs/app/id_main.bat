L:
cd L:\Server\VCS\GitHub\app-module\id
set filename=temp\logs\%date:~0,4%%date:~5,2%%date:~8,2%.log
echo #  >>%filename%
echo %date%%time% >>%filename%
"C:\Program Files\Git\cmd\git.exe" pull gogs main >>%filename% 2>&1
echo ##  >>%filename%
git push github main >>%filename% 2>&1
echo ###  >>%filename%
exit
