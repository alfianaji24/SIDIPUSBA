@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phpunit/phpcov/phpcov
php "%BIN_TARGET%" %*
