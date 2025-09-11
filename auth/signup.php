<?php
session_start();
require 'db.php';

$error = '';

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pwd_raw = $_POST['password'] ?? '';

    // Basic validation
    if ($username === '' || $email === '' || $pwd_raw === '') {
        $error = 'Please fill all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email.';
    } elseif (strlen($pwd_raw) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        // Prevent duplicate email
        $check = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $check->bind_param('s', $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = 'An account with that email already exists.';
        } else {
            // Insert user with prepared statement
            $hash = password_hash($pwd_raw, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $ins->bind_param('sss', $username, $email, $hash);

           if ($ins->execute()) {
           // Get the new user's ID
          $new_id = $ins->insert_id;

            // Log the user in automatically
            $_SESSION['user_id'] = $new_id;
            $_SESSION['username'] = $username;

           // Redirect to homepage
           header('Location: index.php');
           exit;
       } else {
           $error = 'Database error: ' . $ins->error;
       }
   }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Signup</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../css/register.css">
</head>
<body>
  <div class="card">
    <h2>Create account</h2>
    <p class="muted">Join us — fast and simple.</p>

    <?php if (!empty($error)): ?>
      <div class="msg error"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>

    <form method="post" novalidate>
      <input name="username" placeholder="Username" required>
      <input name="email" type="email" placeholder="Email" required>

      <div class="pw-row">
        <input id="password" name="password" type="password" placeholder="Password (min 6 chars)" required>
        <button type="button" id="togglePw" class="small-btn">Show</button>
      </div>

      <button type="submit" class="primary">Sign up</button>
    </form>

    <p class="muted">Already registered? <a href="login.php">Login</a></p>
  </div>

  <script>
    // Toggle password visibility
    const pw = document.getElementById('password');
    const btn = document.getElementById('togglePw');
    btn.addEventListener('click', () => {
      if (pw.type === 'password') { pw.type = 'text'; btn.textContent = 'Hide'; }
      else { pw.type = 'password'; btn.textContent = 'Show'; }
    });
  </script>
</body>
</html>