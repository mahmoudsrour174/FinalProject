<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = trim($_POST['company_name'] ?? '');
    $supplier_phone = trim($_POST['supplier_phone'] ?? '');
    if ($company_name === '' || $supplier_phone === '') {
        $message = 'Company name and phone are required.';
    } else {
        $stmt = $conn->prepare('INSERT INTO suppliers (company_name, supplier_phone) VALUES (?, ?)');
        $stmt->bind_param('ss', $company_name, $supplier_phone);
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: suppliers.php');
            exit;
        }
        $message = 'Unable to save supplier.';
    }
}
$result = $conn->query('SELECT id, company_name, supplier_phone FROM suppliers ORDER BY id DESC');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Suppliers - Pharmacy</title>
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
      <header><h1>Suppliers</h1></header>
      <?php if ($message): ?>
      <section class="messages"><p><?php echo htmlspecialchars($message) ?></p></section>
      <?php endif; ?>
      <section class="page-section form-section">
        <h2>Add Supplier</h2>
        <form method="post">
          <label>Company Name<br><input type="text" name="company_name" required></label>
          <label>Phone<br><input type="text" name="supplier_phone" required></label>
          <button type="submit">Add Supplier</button>
        </form>
      </section>
      <section class="page-section table-section">
        <h2>Supplier List</h2>
        <table>
          <thead><tr><th>ID</th><th>Company</th><th>Phone</th></tr></thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']) ?></td>
              <td><?php echo htmlspecialchars($row['company_name']) ?></td>
              <td><?php echo htmlspecialchars($row['supplier_phone']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>