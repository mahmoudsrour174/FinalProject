<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company = trim($_POST['company'] ?? '');
    $coverage = trim($_POST['coverage'] ?? '');
    if ($company === '' || $coverage === '') {
        $message = 'Company and coverage are required.';
    } else {
        $coverage = intval($coverage);
        $stmt = $conn->prepare('INSERT INTO insurance (company, coverage) VALUES (?, ?)');
        $stmt->bind_param('si', $company, $coverage);
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: insurance.php');
            exit;
        }
        $message = 'Unable to save insurance.';
    }
}
$result = $conn->query('SELECT id, company, coverage FROM insurance ORDER BY id DESC');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Insurance - Pharmacy</title>
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
      <header><h1>Insurance</h1></header>
      <?php if ($message): ?>
      <section class="messages"><p><?php echo htmlspecialchars($message) ?></p></section>
      <?php endif; ?>
      <section class="page-section form-section">
        <h2>Add Insurance</h2>
        <form method="post">
          <label>Company<br><input type="text" name="company" required></label>
          <label>Coverage (%)<br><input type="number" name="coverage" required step="1"></label>
          <button type="submit">Add Insurance</button>
        </form>
      </section>
      <section class="page-section table-section">
        <h2>Insurance List</h2>
        <table>
          <thead><tr><th>ID</th><th>Company</th><th>Coverage</th></tr></thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']) ?></td>
              <td><?php echo htmlspecialchars($row['company']) ?></td>
              <td><?php echo htmlspecialchars($row['coverage']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>

