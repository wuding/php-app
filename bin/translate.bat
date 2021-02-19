@ECHO off
SET output=
SET sort=
SET detail=
SET filter=
SET list=

SET /p output=Output filename [translate.txt]:
SET /p sort=List ordering [1 sort 2 ksort]:
SET /p detail=View details [1 Filename 2 Array]:
SET /p filter=Filtering translations [1 Hide untranslated 2 Hide translated]:
SET /p list=List languages [1 Exclude hidden 2 Exclude not hidden]:

php ../src/bin/translate.php -o"%output%" -s%sort% -d%detail% -f%filter% -l%list%
::php lang.php --output="%output%"
