<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php'); exit;
}
$username = htmlspecialchars($_SESSION['username']);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Welcome</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/register.css">
</head>
<body>
  <div class="card">
    <h2>Welcome, <?=$username?> 🎉</h2>
    <p class="muted">You are logged in.</p>
    <a class="btn-ghost" href="logout.php">Log out</a>
  </div>
</body>
</html>
