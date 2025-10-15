<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$db_host = '';
$db_name = ''; 
$db_user = '';
$db_pass = '';

if (!defined('PERM_USER')) define('PERM_USER', 0);
if (!defined('PERM_EMPLOYEE')) define('PERM_EMPLOYEE', 1);
if (!defined('PERM_MANAGER')) define('PERM_MANAGER', 2);
if (!defined('PERM_ADMIN')) define('PERM_ADMIN', 3);
