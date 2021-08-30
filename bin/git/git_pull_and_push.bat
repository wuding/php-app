@echo off
::CALL conf/config.cmd

%drive_letter%:
CD %repo_path%

ECHO.>>%log_file%
ECHO +----------------------------------------------------------------------+>>%log_file%
ECHO.>>%log_file%

ECHO %time% %date%>>%log_file%
ECHO +-------+>>%log_file%
ECHO ^| %remote_name% ^|>>%log_file%
ECHO +-------+>>%log_file%
%git_path% pull %remote_name% %branch_name% >>%log_file% 2>&1
ECHO.>>%log_file%

FOR %%G IN (%remotes%) DO (
    ECHO %time%>>%log_file%
    ECHO +--------+>>%log_file%
    ECHO ^| %%G ^|>>%log_file%
    ECHO +--------+>>%log_file%
    git push %%G %branch_name% >>%log_file% 2>&1
    ECHO.>>%log_file%
)

ECHO %time%>>%log_file%
EXIT
