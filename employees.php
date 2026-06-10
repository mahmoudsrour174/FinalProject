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
    $job = trim($_POST['job'] ?? '');
    $salary = $_POST['salary'] ?? '';
    $presence = trim($_POST['presence'] ?? '');
    if ($name === '' || $phone === '') {
        $message = 'Name and phone are required.';
    } else {
        $salary = intval($salary);
        $stmt = $conn->prepare('INSERT INTO employees (name, phone, address, job, salary, presence) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssis', $name, $phone, $address, $job, $salary, $presence);
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: employees.php');
            exit;
        }
        $message = 'Unable to save employee.';
    }
}
$result = $conn->query('SELECT id, name, phone, job, salary FROM employees ORDER BY id DESC');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Employees - Pharmacy</title>
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
      <header><h1>Employees</h1></header>
      <?php if ($message): ?>
      <section class="messages"><p><?php echo htmlspecialchars($message) ?></p></section>
      <?php endif; ?>
      <section class="page-section form-section">
        <h2>Add Employee</h2>
        <form method="post">
          <label>Name<br><input type="text" name="name" required></label>
          <label>Phone<br><input type="text" name="phone" required></label>
          <label>Address<br><input type="text" name="address"></label>
          <label>Job<br><input type="text" name="job"></label>
          <label>Salary<br><input type="number" name="salary" step="1"></label>
          <label>Presence<br><input type="text" name="presence"></label>
          <button type="submit">Add Employee</button>
        </form>
      </section>
      <section class="page-section table-section">
        <h2>Employee List</h2>
        <table>
          <thead><tr><th>ID</th><th>Name</th><th>Phone</th><th>Job</th><th>Salary</th></tr></thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']) ?></td>
              <td><?php echo htmlspecialchars($row['name']) ?></td>
              <td><?php echo htmlspecialchars($row['phone']) ?></td>
              <td><?php echo htmlspecialchars($row['job']) ?></td>
              <td><?php echo htmlspecialchars($row['salary']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>