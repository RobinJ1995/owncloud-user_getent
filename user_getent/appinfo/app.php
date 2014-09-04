<?php
require_once('apps/user_getent/user_getent.php');

OC_User::registerBackend ('GETENT');
OC_User::useBackend ('GETENT');
?>
