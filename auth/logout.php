<?php
session_start();
require 'db.php';

// If remember_token cookie exists, clear it both client & server side
if (isset($_COOKIE['remember_token'])) {
    $tok = $_COOKIE['remember_token'];

    // Expire cookie
    setcookie('remember_token', '', time() - 3600, '/', '', false, true);

    // Clear token from DB
    $st = $conn->prepare("UPDATE users SET remember_token = NULL WHERE remember_token = ?");
    $st->bind_param('s', $tok);
    $st->execute();
}

// Destroy all session data
$_SESSION = [];
session_unset();
session_destroy();

// Start fresh session just for the flash message
session_start();
$_SESSION['flash_success'] = "✅ You have been logged out successfully.";

// Redirect to login
header('Location: login.php');
exit;