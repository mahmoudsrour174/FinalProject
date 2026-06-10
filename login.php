<?php
session_start();
include 'connection.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($username === '' || $password === '') {
        $message = 'Username and password are required.';
    } else {
        $stmt = $conn->prepare('SELECT id FROM users WHERE username = ? AND password = ?');
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $_SESSION['username'] = $username;
            header('Location: drugs.php');
            exit;
        }
        $message = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Pharmacy</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-page">
    <header>
      <h1>My Pharmacy</h1>
    </header>
    <main>
      <section class="page-section form-section">
        <h2>Login</h2>
        <?php if ($message): ?>
        <div class="messages"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
          <label>Username<br><input type="text" name="username" required></label>
          <label>Password<br><input type="password" name="password" required></label>
          <button type="submit">Login</button>
        </form>
      </section>
    </main>
    <footer>
      <p>&copy; 2026 my pharmacy</p>
    </footer>
  </div>
</body>
</html>

