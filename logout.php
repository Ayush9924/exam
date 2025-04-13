<?php
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Clear cookies
if (isset($_COOKIE['current_user'])) {
    setcookie('current_user', '', time() - 3600, '/');
}

// Redirect to login page
header("Location: login.php");
exit();
?>
