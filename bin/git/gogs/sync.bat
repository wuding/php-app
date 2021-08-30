@echo off
SET cur_dir=L:\Server\Domain\urlnk\org\php-app\bin\git
CALL %cur_dir%\gogs\%3\conf\config.cmd
CALL %cur_dir%\gogs\%3\conf\%2_%1.cmd
CALL %cur_dir%\git_pull_and_push.bat
EXIT
