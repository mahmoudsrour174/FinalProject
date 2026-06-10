<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        $message = 'Name is required.';
    } else {
        $stmt = $conn->prepare('INSERT INTO diseases (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: diseases.php');
            exit;
        }
        $message = 'Unable to save disease.';
    }
}
$result = $conn->query('SELECT id, name FROM diseases ORDER BY id DESC');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Diseases - Pharmacy</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="page-layout">
    <aside class="sidebar">
      <h2>Menu</h2>
      <nav>
        <a href="patients.php">Patients</a>
        <a href="drugs.php">Drugs</a>
        <a href="employees.php">Employees</a>
        <a href="suppliers.php">Suppliers</a>
        <a href="invoices.php">Invoices</a>
        <a href="insurance.php">Insurance</a>
        <a href="diseases.php">Diseases</a>
        <a href="logout.php">Logout</a>
      </nav>
    </aside>
    <main class="content">
      <header><h1>Diseases</h1></header>
      <?php if ($message): ?>
      <section class="messages"><p><?php echo htmlspecialchars($message) ?></p></section>
      <?php endif; ?>
      <section class="page-section form-section">
        <h2>Add Disease</h2>
        <form method="post">
          <label>Name<br><input type="text" name="name" required></label>
          <button type="submit">Add Disease</button>
        </form>
      </section>
      <section class="page-section table-section">
        <h2>Disease List</h2>
        <table>
          <thead><tr><th>ID</th><th>Name</th></tr></thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']) ?></td>
              <td><?php echo htmlspecialchars($row['name']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>