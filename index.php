<?php
session_start();

require 'config.php';
require 'connexion.php';

if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}
?>
