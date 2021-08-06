L:
cd L:\Server\Domain\urlnk\org\@\topdb
set filename=temp\logs\%date:~0,4%%date:~5,2%%date:~8,2%.log
echo #  >>%filename%
echo %date%%time% >>%filename%
"C:\Program Files\Git\cmd\git.exe" pull gogs develop >>%filename% 2>&1
echo ##  >>%filename%
git push origin develop >>%filename% 2>&1
echo ###  >>%filename%
exit
