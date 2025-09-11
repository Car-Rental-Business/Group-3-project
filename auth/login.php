<?php
session_start();
require 'db.php';

$error = '';

// If already logged in go to welcome
if (isset($_SESSION['username'])) {
  header('Location: index.php'); exit;
}

// Auto-login via cookie token
if (!isset($_SESSION['username']) && !empty($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $st = $conn->prepare("SELECT id, username FROM users WHERE remember_token = ? LIMIT 1");
    $st->bind_param('s', $token);
    $st->execute();
    $res = $st->get_result();
    if ($res && $row = $res->fetch_assoc()) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['id'];
        header('Location: welcome.php'); exit;
    } else {
        setcookie('remember_token', '', time() - 3600, '/');
    }
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pwd = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if ($email === '' || $pwd === '') {
        $error = 'Please enter email and password.';
    } else {
        $st = $conn->prepare("SELECT id, username, password FROM users WHERE email = ? LIMIT 1");
        $st->bind_param('s', $email);
        $st->execute();
        $res = $st->get_result();

        if ($res && $row = $res->fetch_assoc()) {
            if (password_verify($pwd, $row['password'])) {
                // login success
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['id'];

                if ($remember) {
                    $token = bin2hex(random_bytes(16));
                    // HttpOnly cookie, 30 days
                    setcookie('remember_token', $token, time() + 60*60*24*30, '/', '', false, true);

                    $up = $conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                    $up->bind_param('si', $token, $row['id']);
                    $up->execute();
                }

                header('Location: ../index.html'); exit;
            } else {
                $error = 'Incorrect password.';
            }
        } else {
            $error = 'No account found with that email.';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../css/register.css">
</head>
<body>
  <div class="card">
    <h2>Welcome back</h2>
    <p class="muted">Login to continue</p>

    <?php if (!empty($_SESSION['flash_success'])): ?>
      <div class="msg success"><?=htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']);?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
      <div class="msg error"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>

    <form method="post" novalidate>
      <input name="email" type="email" placeholder="Email" required>

      <div class="pw-row">
        <input id="loginPassword" name="password" type="password" placeholder="Password" required>
        <button type="button" id="toggleLoginPw" class="small-btn">Show</button>
      </div>

      <label class="remember"><input type="checkbox" name="remember"> Remember me</label>

      <button type="submit" class="primary">Login</button>
    </form>

    <p class="muted">Don't have an account? <a href="signup.php">Sign up</a></p>
  </div>

  <script>
    // toggles
    const toggleBtn = document.getElementById('toggleLoginPw');
if (toggleBtn) {
  toggleBtn.addEventListener('click', function(){
    const i = document.getElementById('loginPassword');
    if (i.type === 'password') { i.type = 'text'; this.textContent = 'Hide'; }
    else { i.type = 'password'; this.textContent = 'Show'; }
  });
    }
</script>
</body>
</html>
