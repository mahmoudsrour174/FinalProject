<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = trim($_POST['patient_id'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    if ($patient_id === '' || $amount === '') {
        $message = 'Patient ID and amount are required.';
    } else {
        $patient_id = intval($patient_id);
        $amount = floatval($amount);
        $stmt = $conn->prepare('INSERT INTO invoices (patient_id, amount) VALUES (?, ?)');
        $stmt->bind_param('id', $patient_id, $amount);
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: invoices.php');
            exit;
        }
        $message = 'Unable to save invoice.';
    }
}
$result = $conn->query('SELECT id, patient_id, amount FROM invoices ORDER BY id DESC');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Invoices - Pharmacy</title>
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
      <header><h1>Invoices</h1></header>
      <?php if ($message): ?>
      <section class="messages"><p><?php echo htmlspecialchars($message) ?></p></section>
      <?php endif; ?>
      <section class="page-section form-section">
        <h2>Add Invoice</h2>
        <form method="post">
          <label>Patient ID<br><input type="number" name="patient_id" required></label>
          <label>Amount<br><input type="number" step="0.01" name="amount" required></label>
          <button type="submit">Add Invoice</button>
        </form>
      </section>
      <section class="page-section table-section">
        <h2>Invoice List</h2>
        <table>
          <thead><tr><th>ID</th><th>Patient ID</th><th>Amount</th></tr></thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']) ?></td>
              <td><?php echo htmlspecialchars($row['patient_id']) ?></td>
              <td><?php echo htmlspecialchars($row['amount']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>