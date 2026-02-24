<?php
session_start();

$_SESSION = array();
session_destroy();

if (isset($_COOKIE['remember_username'])) {
    setcookie('remember_username', '', time() - 3600, '/');
}
if (isset($_COOKIE['remember_login'])) {
    setcookie('remember_login', '', time() - 3600, '/');
}

header("Location: login.php");
exit();
?>

