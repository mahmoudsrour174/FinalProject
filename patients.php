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
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    if ($name === '' || $phone === '') {
        $message = 'Name and phone are required.';
    } else {
        $stmt = $conn->prepare('INSERT INTO patients (name, phone, address) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $name, $phone, $address);
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: patients.php');
            exit;
        }
        $message = 'Unable to save patient.';
    }
}
$result = $conn->query('SELECT id, name, phone, address FROM patients ORDER BY id DESC');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Patients - Pharmacy</title>
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
      <header><h1>Patients</h1></header>
      <?php if ($message): ?>
      <section class="messages"><p><?php echo htmlspecialchars($message) ?></p></section>
      <?php endif; ?>
      <section class="page-section form-section">
        <h2>Add Patient</h2>
        <form method="post">
          <label>Name<br><input type="text" name="name" required></label>
          <label>Phone<br><input type="text" name="phone" required></label>
          <label>Address<br><input type="text" name="address"></label>
          <button type="submit">Add Patient</button>
        </form>
      </section>
      <section class="page-section table-section">
        <h2>Patient List</h2>
        <table>
          <thead>
            <tr><th>ID</th><th>Name</th><th>Phone</th><th>Address</th></tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']) ?></td>
              <td><?php echo htmlspecialchars($row['name']) ?></td>
              <td><?php echo htmlspecialchars($row['phone']) ?></td>
              <td><?php echo htmlspecialchars($row['address']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>


